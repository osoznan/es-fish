<?php

use App\Models\PaymentType;
use App\Models\DeliveryType;

/**
 * @var $order \App\Models\Order
 * @var $orderItems \App\Models\OrderItem[]
 */

$ex_data = json_decode($order->extra_data);

?>

<h2>Заказ</h2>

<?php if (isset($error)): ?>
    <h2><?= $error ?></h2>
<?php endif; ?>

Время: <?= date('d.m.Y H:i:s') ?>
<p>
    Телефон: <?= $order->phone ?><br>
    Имя: <?= $order->name ?><br>
    Способ оплаты: <?= PaymentType::getAllValues($order->payment_type_id)['name'] ?> <br>
    Способ доставки: <?= DeliveryType::getAllValues($order->delivery_type_id)['name'] ?> <br>

<h3>Заказанные товары:</h3>

<?php
$sum = 0;

foreach ($orderItems as $id => $item) {
    $data = json_decode($item->data);
    $sum += $data->price * $item->amount;
    echo 'Наименование: ' . $data->name, '<p>',
    'Количество: ' . $item->amount . 'шт.<p>',
    'Стоимость: ' , $data->price * $item->amount . ' грн.<hr>';
}

?>
<P></P>

Итого (без стоимости доставки): <b><?= $sum ?> грн.</b><p></p>
Итого (с доставкой): <b><?= $order->total ?> грн.</b>
