<?php


namespace Config\DevCoder;


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
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }
        $this->path = $path;
    }

    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
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
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

}