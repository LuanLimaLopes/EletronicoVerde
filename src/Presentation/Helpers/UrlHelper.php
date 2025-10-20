<?php
<?php
namespace EletronicoVerde\Presentation\Helpers;

class UrlHelper
{
    public static function asset($path)
    {
        return BASE_URL . '/assets/' . ltrim($path, '/');
    }

    public static function route($path)
    {
        return BASE_URL . '/' . ltrim($path, '/');
    }
}