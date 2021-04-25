<?php


namespace Hboudaoud\Config\Bin;


use Hboudaoud\Config\ConfigException;
use HBoudaoud\Router\Router;
use ReflectionClass;
use Exception;
use ReflectionException;

class RouteReflector
{

    /**
     * @var ReflectionClass|null
     */
    private $reflector;
    /**
     * @var string|null
     */
    private $className;
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     * @param string|null $className
     * @throws ReflectionException
     */
    public function __construct(Router $router, ?string $className = '')
    {
        $this->router = $router;
        $this->setClassName($className);
    }


    /**
     * @return ReflectionClass
     */
    public function getReflector(): ReflectionClass
    {
        return $this->reflector;
    }


    /**
     * @param string|null $className
     * @return RouteReflector
     * @throws ReflectionException
     */
    public function setClassName(?string $className): RouteReflector
    {
        if (!empty(trim($className))) {
            $this->className = $className;
            $this->reflector = new ReflectionClass($className);
        }
        return $this;

    }

    public function load()
    {
        //echo "<br />**************** " . $this->reflector->getName() . ' ************<br />';
        $classpath = '';
        preg_match(
            '/@BasePath\((.+)\)/',
            $this->reflector->getDocComment(),
            $matches,
            PREG_OFFSET_CAPTURE);
        $classpath = isset($matches[1][0])
            ? $matches[1][0]
            : '';
        //echo "<br>classpath : $classpath : ".print_r($matches,1);

        foreach ($this->reflector->getMethods() as $action) {
            if ($action->isPublic()) {
                $docComment = $this->reflector->getMethod($action->name)->getDocComment();
            }

            if ($action->isPublic() && !empty($docComment)) {
                try {
                    $docComment = $this->reflector->getMethod($action->name)->getDocComment();
                } catch (ReflectionException $e) {
                    throw new ConfigException($e->getMessage());
                }
                // var_dump("<br>--- isPublic : {$action->getName()} - docComment : $docComment");
                preg_match_all(
                    '/@Route\((.+)\)/',
                    $docComment,
                    $matches,
                    PREG_OFFSET_CAPTURE);

                array_shift($matches);

                // echo "<br>class={$action->class}, action={$action->name}, " .print_r($matches,1);

//                // to test string JSON
//                $routeParams = '{"'.str_replace('""', '"',
//                        str_replace([' ',"'", '",', '\\', '='], ['','"', '","', '\\\\', '":'],
//                            (preg_match('/path=/', $matches[0][0])
//                                ? $matches[1][0]
//                                : "path=" . $matches[1][0]
//                            ) . '}'
//                        )
//                    );


                foreach ($matches[0] as $match) {
                    //echo "<br>match[0] {$match[0]}";
                    $this->setNewPath($match[0], $action,$classpath);
                }
            }
        }

    }


    private function setNewPath(string $match, \ReflectionMethod $action, $classpath)
    {
        $routeParams = json_decode(
            '{"' . str_replace('""', '"',
                str_replace([' ', "'", '",', '\\', '='], ['', '"', '","', '\\\\', '":'],
                    (preg_match('/path=/', $match)
                        ? $match
                        : "path=" . $match
                    ) . '}'
                )
            )
        );

        //echo('<br />' . $action->class . ' - ' .$action->name . ' - '); //.print_r($routeParams,1));
        if (!isset($routeParams->methods) || !is_array($routeParams->methods)) {
            $routeParams->methods = ['GET'];
        }
        if (!isset($routeParams->name) || empty(trim($routeParams->name))) {
            $routeParams->name = str_replace(
                    '\\',
                    '_',
                    $action->class
                ) . "#{$action->name}";
        }


        $regexParams = [];

        $pattern = '/\{(.*)\}([-]*)/';

        if (preg_match($pattern, $routeParams->path)) {
            $getParams = explode(':', $routeParams->path);
            array_shift($getParams);
            //print_r($getParams);
            foreach ($getParams as $param) {
                preg_match(
                    $pattern,
                    $param,
                    $matches,
                    PREG_OFFSET_CAPTURE
                );
                $regexParams[preg_replace($pattern, '', $param)] = !empty($matches[1][0]) ? $matches[1][0] : null;
            }
        }
        $routeParams->path = $classpath . preg_replace($pattern, '', $routeParams->path);

        foreach ($routeParams->methods as $method) {
            // echo "$routeParams->path, $this->className, $action->getName(), $routeParams->name, $method, ".print_r($regexParams,1);
            $this->addRout(
                $routeParams->path,
                $this->className,
                $action->getName(),
                $routeParams->name,
                $method,
                $regexParams
            );
        }
    }

    private function addRout($path,$className, $action, $name, $method, $regexParams)
    {
        //echo "<br/>$method action : $className->$action --- $name :   $path";
        $this->router->add(
            $path,
            function () use ($action, $className) {
                $numargs = func_num_args();
                $params = [];
                for ($num=0;$num<$numargs;$num++ ) {
                    $params[$num] = preg_replace('/^-/','',func_get_arg($num));
                    //echo "<br> params[$num] ".$params[$num];
                }
                $_ENV['APP_CONTENT'] .= call_user_func_array([(new $className()), $action],$params);
            },
            $name,
            $method
        )->withParams($regexParams);
    }


}