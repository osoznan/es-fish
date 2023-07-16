<?php

namespace App\Components;

use Illuminate\Support\Facades\App;

class Translation {

    protected static $locale;
    protected static $localeStrings = [];

    public static function getLocale() {
        if (!self::$locale) {
            self::$locale = App::getLocale();
        }

        return self::$locale;
    }

    public static function setLocale($locale) {
        App::setLocale($locale);
        self::$locale = App::getLocale();
    }

    public static function getLocaleStrings($locale = null) {
        if (!$locale) {
            $locale = static::getLocale();
        }

        if (!isset(static::$localeStrings[$locale])) {
            static::$localeStrings[$locale] = require(Top::$app->basePath . '/../site/lang/' . $locale . '.php');
        }

        return static::$localeStrings[$locale];
    }

    public static function getLocaleString($alias, $lang = null) {
        $keys = explode('.', $alias);
        $config = static::getLocaleStrings($lang);
        $notFound = false;

        foreach ($keys as $key) {
            if (array_key_exists($key, $config)) {
                if (!empty($config[$key])) {
                    $config = $config[$key];
                } else {
                    $notFound = true;
                    break;
                }
            } else {
                $notFound = true;
                break;
            }
        }

        if ($notFound && static::getLocale() != 'ru') {
            // return self::getLocaleString($alias, 'ru');
        }

        return $config;
    }

    public static function t($alias, ...$args) {
        return static::tf($alias, ...$args);
    }

    public static function tf($alias, ...$args) {
        $string = self::getLocaleString($alias);

        $i = 1;
        foreach ($args as $arg) {
            $string = str_replace('{' . $i . '}', $arg, $string);
        }

        return is_array($string) ? $alias : $string;
    }

    public static function getLocaleField($object, $field, $lang = null) {
        if (is_array($object)) {
            if (!empty($object[self::getLocaleFieldName($field, $lang)])) {
                return $object[self::getLocaleFieldName($field, $lang)];
            }
            return $object[$field];
        }

        if (!empty($object->{self::getLocaleFieldName($field, $lang)})) {
            return $object->{self::getLocaleFieldName($field, $lang)};
        }
        return $object->$field;
    }

    public static function getLocaleFieldName($field, $lang = null) {
        $locale = $lang ?? self::getLocale();

        if (in_array($locale, ['ua', 'en'])) {
            return $field . '_' . $locale;
        }

        return $field;
    }

    public static function inPlace($str) {
        $translations = explode('|', $str);
        $langIdx = ['ru' => 0, 'ua' => 1, 'en' => 2];

        return $translations[$langIdx[static::getLocale()]];
    }

}
