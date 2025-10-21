<?php

namespace EletronicoVerde\Presentation\Helpers;

class UrlHelper
{
    public static function asset(string $path): string
    {
        $baseUrl = '/EletronicoVerde';
        return sprintf('%s/public/assets/%s', $baseUrl, ltrim($path, '/'));
    }

    public static function css(string $filename): string
    {
        return self::asset('css/' . ltrim($filename, '/'));
    }
}