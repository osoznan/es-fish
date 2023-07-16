<?php


?>

<table class="table-primary table-hover th-center table datatables dataTable no-footer">
@foreach($list as $el)
    <tr>
        <td>#{{ $el->product->id }}</td>
        <td>{{ $el->product->name }}</td>
        <td>{{ $el->amount }}</td>
        <td>{{ $el->product->price * $el->amount }}</td>
    </tr>
@endforeach
</table>
