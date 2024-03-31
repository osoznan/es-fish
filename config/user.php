<?php

$code = '044';
$number = '221-2637';

return [
    'site-name' => 'FISH',
    'phone' => [
        'full' => "($code)$number",
        'code' => $code,
        'number' => $number
    ],
    'email' => 'sale@fish-way.com.ua',
    'admin-email' => 'admin@fish.com',

    'viber' => 'https://viber',
    'instagram' => 'https://instagram',
    'facebook' => 'https://facebook',
    'linkedin' => 'https://linkedin',

    'delivery-cost-ranges' => [3000, 5000],

    'top-category-pictures' => [
        1 => '/img/fish.svg',
        2 => '/img/chicken.svg',
        3 => '/img/meat.svg',
        4 => '/img/cheese.svg',
        5 => '/img/beer.svg',
        6 => '/img/chicken-wings.svg'
    ],

    'available_locales' => [
        'ru', 'ua', 'en'
    ]

];
