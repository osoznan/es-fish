<?php

namespace App\Widgets;

trait AjaxWidget {

    static protected $_registeredAjaxClasses = array();

    /**
     * Возвращает ajax-обработчики зарегистрированные в этом компоненте и во вложенных компонентах
     */
    static function getRegisteredAjaxClasses(): array {
        $classes = static::$_registeredAjaxClasses;
        foreach(static::$_registeredAjaxClasses as $handlerClass){
            if (method_exists($handlerClass, 'getRegisteredAjaxClasses')){
                $classes[] = $handlerClass::getRegisteredAjaxClasses();
            }
        }
        return $classes;
    }

    public static function getAjaxHandlers() {}

}
