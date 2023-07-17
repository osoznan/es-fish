<?php

use App\Components\helpers\Form;

/** @var $statuses */

?>

<div class="order-status-history-editor" data-id="{{ $orderId }}">
    <label class="form-label">Order Statuses</label>

    <div data-thing="error" class="alert alert-danger alert-message text-white" style="display: none"></div>

    <div class="row">
        <div class="col-xs-12 col-lg-3"><?=Form::select('status', 'New Status', '', $statuses, ['class' => 'form-control'])?></div>
        <div class="col-xs-12 col-lg-3"><?=Form::textarea('description', 'Comment', null, ['class' => 'form-control'])?></div>
        <div class="col-xs-12 col-lg-2"><?=Form::button('Add Status', ['class' => 'btn btn-primary'])?></div>
    </div>
    <p></p>
    <table class="table-primary table-hover th-center table datatables dataTable no-footer">
        <tr><th>Date</th><th>Status</th><th>Description</th>
    @foreach ($items as $item)
        <tr>
            <td class="col-xs-12 col-md-4">{{ $item->created_at }}</td>
            <td class="col-xs-12 col-md-4">{{ $item->order_status->name }}</td>
            <td class="col-xs-12 col-md-4">{{ $item->description }}</td>
        </tr>
    @endforeach
    </table>

    @empty($items)
        <div>There is no status changes yet</div>
    @endempty
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        class OrderStatusHistoryEditor {
            constructor() {
                this.el = $('.order-status-history-editor');
                this.error = this.el.find('[data-thing="error"]')
                this.el.find('button').click(() => {
                    return this.send()
                })
            }

            send() {
                $.ajax({
                    method: 'post',
                    url: '/admin/ajax',
                    data: {
                        component: '\\App\\Widgets\\Admin\\OrderStatusHistoryEditor', command: 'content',
                        params: {
                            order_id: {{ $orderId }},
                            status_id: this.el.find('select').val(),
                            description: this.el.find('textarea').val()
                        }
                    }
                }).then((data) => {
                    if (data.content) {
                        this.el.replaceWith(data.content);
                        orderStatusHistoryEditor = new OrderStatusHistoryEditor()
                        this.error.hide()
                    } else {
                        this.error.show().html(data.message)
                    }
                })

                return false;
            }
        }
        orderStatusHistoryEditor = new OrderStatusHistoryEditor()
    })
</script>
