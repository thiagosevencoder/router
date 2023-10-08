<?php

class CoreLoader
{
    protected static string $fileExt = '.php';
    protected static string $path;
    protected static $fileIterator = null;

    public static function loader(string $className)
    {
        $directory = new RecursiveDirectoryIterator(static::$path, RecursiveDirectoryIterator::SKIP_DOTS);

        if (is_null(static::$fileIterator)) {
            static::$fileIterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::LEAVES_ONLY);
        }

        $fileName = $className . static::$fileExt;

        foreach (static::$fileIterator as $file) {

            if (strtolower($file->getFileName()) === strtolower($fileName)) {

                if ($file->isReadable()){
                    include_once $file->getPathName();
                }
                break;
            }
        }
    }

    public static function setFileExt($fileExt) {
        self::$fileExt = $fileExt;
    }

    public static function setPath(string $path)
    {
        self::$path = $path;
    }
}