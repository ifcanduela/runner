<?php

namespace app\services;

class Runner
{
    const USE_RANDOM_FILENAME = false;

    public function run($code)
    {
        $name = static::USE_RANDOM_FILENAME ? random_int(10000, 99999) : "runner";
        $filename = root("www", "{$name}.php");

        file_put_contents($filename, $code);
        exec("php {$filename}", $output);

        return $output;
    }
}
