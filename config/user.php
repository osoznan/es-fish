<?php

$code = '044';
$number = '494-00-00';

return [
    'site-name' => 'FISH',
    'phone' => [
        'full' => "($code)$number",
        'code' => $code,
        'number' => $number
    ],
    'email' => 'test@fish.com',
    'admin-email' => 'admin@fish.com',

    'delivery-cost-ranges' => [3000, 5000]
];
