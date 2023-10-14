<?php

namespace SevenCoder\Router;

class Sanitize
{
    private static $data;

    public static function tratyRequest($data): void {
        self::$data = $data;
        
        self::clearEmptySpaces();
        self::removeTagsPhpAndHtml();
        self::addBackslashesToString();
        self::removeComandSql();
    }
    
    private static function clearEmptySpaces(): void {
        self::$data = trim(self::$data);
    }

    private static function removeTagsPhpAndHtml(): void {
        self::$data = strip_tags(self::$data);
    }

    private static function addBackslashesToString(): void {
        self::$data = addslashes(self::$data);
    }

    private static function removeComandSql(): void {
        self::$data = preg_replace(
            "/(from|select|insert|delete|where|drop table|show tables|#|;|\*|--|\\\\)/",
            "" ,
            self::$data
        );
    }
}
