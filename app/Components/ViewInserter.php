<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace App\Components;

/**
 * Class View
 * The base View object
 */
class ViewInserter {

    protected static $_css = [];
    protected static $_js = [];
    protected static $_cssFiles = [];
    protected static $_jsFiles = [];

    public static function insertCss($css, $key = null) {
        static::$_css[$key] = $css;
    }

    public static function insertJs($js, $key = null) {
        static::$_js[$key] = $js;
    }

    public static function insertCssFile($css, $key = null) {
        static::$_cssFiles[$key ?? $css] = $css;
    }

    public static function insertJsFile($js) {
        static::$_jsFiles[$js] = $js;
    }

    public static function getInlineScripts() {
        return static::$_js;
    }

    public static function getInlineCss() {
        return static::$_css;
    }

    public static function getScriptFiles() {
        return static::$_jsFiles;
    }

    public static function getCssFiles() {
        return static::$_cssFiles;
    }

}
