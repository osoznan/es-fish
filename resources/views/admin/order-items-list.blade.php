<?php


?>

<table class="table-primary table-hover th-center table datatables dataTable no-footer">
    <theader>
        <tr><th>ID</th><th>Product</th><th>How many</th><th>Price for 1</th><th>Total Price</th></tr>
    </theader>
@foreach($list as $el)
    <tr>
        <td>#{{ $el->product->id }}</td>
        <td><a href="/admin/products/{{ $el->product_id }}/edit">{{ $el->product->name }}</td>
        <td>{{ $el->amount }}</td>
        <td>{{ $el->product->price }}</td>
        <td>{{ $el->product->price * $el->amount }}</td>
    </tr>
@endforeach
</table>
