<?php


namespace Hboudaoud\Config\Bin;


use Hboudaoud\Config\ConfigException;

include_once '../ConfigException.php';
class DotEnv
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected $path;


    public function __construct(string $path)
    {
        if(!file_exists($path)) {
            throw new ConfigException(sprintf('%s does not exist', $path));
        }
        $this->path = $path;
    }

    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new ConfigException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }


            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim(explode('#',$value)[0]);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                if($name=='APP_ENV' && !empty($value)){
                    $value = $this->modeDev($value);
                    switch ($value){
                        case 'dev':
                            ini_set('display_errors', 1);
                            ini_set('display_startup_errors', 1);
                            ini_set('track_errors' ,1);
                            error_reporting(-1);
                            break;
                        default:
                            ini_set('display_errors', 0);
                            ini_set('display_startup_errors', 0);
                            ini_set('track_errors' ,0);
                            error_reporting(0);
                            break;
                    }
                }

                if($name=='APP_DEV_IP'){
                    $values=explode(',',preg_replace('/ /', '',$value));
                    // putenv(sprintf('%s=', $name),$values);
                    $_ENV[$name]  = $values;
                    $_SERVER[$name] = $values;
                }else {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }

    private function modeDev(string $value): string
    {
        if($value!='prod' && !in_array($_SERVER['REMOTE_ADDR'],$_SERVER['APP_DEV_IP']) ){
            return 'prod';
        }
        return $value;
    }

}