<?php

namespace App\Components;

class Translit {

    const TRANSLITED_AS_IS = '0123456789-abcdefghijklmnopqrstuvwxyzі';

    const GLOBAL_RULES = [
        ' ' => '-',
        '_' => '-',

        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'ж' => 'zh',
        'з' => 'z',
        'й' => 'j',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'ts',
        'ч' => '4',
        'ш' => 'sh',
        'щ' => 's4',
        'ю' => 'yu',
        'я' => 'ya',
        'ь' => 'j',
    ];

    const RULES = [
        'ru' => [
            'е' => 'e',
            'ё' => 'yo',
            'и' => 'i',
            'ъ,' => 'j',
            'ы' => 'y',
            'э' => 'e',
        ],
        'ua' => [
            'і' => 'i',
            'и' => 'y',
            'е' => 'e',
            'ї' => 'yi',
            'є' => 'ye',
        ],
        'en' => []
    ];

    public static function process($str, $langCode) {
        $str = mb_strtolower($str);
        $map = array_merge(static::GLOBAL_RULES, static::RULES[$langCode]);
        $res = '';

        // $str = mb_convert_encoding($str, "UTF-8", "ASCII");

        for ($i = 0; $i < mb_strlen($str); $i++) {
            $char = mb_substr($str, $i, 1);
            if (isset($map[$char])) {
                $res .= $map[$char];
            } elseif (strpos(static::TRANSLITED_AS_IS, $char) !== false) {
                $res .= $char;
            }
        }

        return $res;
    }

}
