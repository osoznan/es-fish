<?php

namespace App\Components\helpers;

class Form {

    const INPUT_DEFAULT = 'input';
    const INPUT_CHECKBOX = 'checkbox';
    const INPUT_RADIO = 'radio';
    const INPUT_INT = 'int';
    const INPUT_PASSWORD = 'password';
    const INPUT_HIDDEN = 'hidden';

    public static function begin($options = []) {
        return '<form ' . static::attributesFromArray($options) . '><div class="form__general-error-label bg-danger"></div><div>';
    }

    public static function end() {
        return '</div></form>';
    }

    public static function input($type, $name, $label, $initValue, $options) {
        return static::label($label, $options) . static::errorLabel($name) . '<input type="' . $type . '" name="' . $name . '" value="' . $initValue . '" ' . static::attributesFromArray($options) . '>';
    }

    public static function textarea($name, $label, $initValue, $options) {
        return static::label($label, $options) . static::errorLabel($name) . '<textarea name="' . $name . '" ' . static::attributesFromArray($options) . '>' . $initValue . '</textarea>';
    }

    public static function button($label, $options = []) {
        return '<button ' . static::attributesFromArray($options) . '>' . $label . '</textarea>';
    }

    public static function select($name, $label, $initValue = null, $items = [], $options = []) {
        $html = static::label($label, $options) . static::errorLabel($name)
            .'<select name="'.$name.'" '.static::attributesFromArray($options) . '><option>';
        foreach ($items as $key => $elem) {
            $html .= "<option value=\"$key\">$elem</option>";
        }
        return $html.'</select>';
    }

    public static function label($title, $options = []) {
        return '<label class="form-label" ' . static::attributesFromArray($options) . '>' . $title . '</label>'
            . (isset($options['@required']) ? '*' : '');
    }

    public static function errorLabel($name) {
        return '<div class="form__error-label bg-danger text-white" data-name="' . $name . '"></div>';
    }

    public static function attributesFromArray($attrs) {
        $arr = [];
        foreach ($attrs as $name => $value) {
            $arr[] = "$name=\"$value\"";
        }

        return join(' ', $arr);
    }

}
