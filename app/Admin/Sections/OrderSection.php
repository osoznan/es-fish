<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\OrderItem;
use App\Widgets\Admin\OrderStatusHistoryEditor;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Section;

/**
 * Class OrderSection
 *
 * @property \App\Models\Order $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class OrderSection extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Заказы';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('name', 'Name', 'created_at')
                ->setSearchCallback(function($column, $query, $search){
                    return $query
                        ->orWhere('name', 'like', '%'.$search.'%');
                })
            ,
            AdminColumn::text('total', 'Total'),
            AdminColumn::text('created_at', 'Created')
                ->setWidth('160px')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('created_at', $direction);
                })
            ,
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([['created_at']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Order::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('name')
                ->setPlaceholder('All names')
            ,
        ]);
        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name', 'Name')->setReadonly(true),
                AdminFormElement::text('payment_type.name', 'Payment Type')->setReadonly(true)
            ], 'col-xs-12 col-sm-4')->addColumn([
                AdminFormElement::text('phone', 'Phone')->setReadonly(true),
                AdminFormElement::text('delivery_type.name', 'Delivery Type')->setReadonly(true)
            ], 'col-xs-12 col-sm-4')->addColumn([
                AdminFormElement::datetime('created_at', 'Created At')->setReadonly(true),
                AdminFormElement::text('status.name', 'Status')->setReadonly(true),
            ], 'col-xs-12 col-sm-4'),

            AdminFormElement::view('admin/order-items-list', [
                'list' => OrderItem::with('product')->where('order_id', $id)->get()
            ]),

            AdminFormElement::html(OrderStatusHistoryEditor::widget(['orderId'=> $id]))
        ]);

        $form->getButtons()->setButtons([
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return false;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
