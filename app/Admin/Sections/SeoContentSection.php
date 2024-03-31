<?php

namespace App\Admin\Sections;

use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use AdminColumnEditable;

class SeoContentSection extends Section implements Initializable {

    use ModuleSettings;
    use TSectionValidator;

    protected $checkAccess = false;

    protected $title = 'Модули';

    public function initialize() {
        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('module_title', 'Title', 'descriptionShort')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('name', 'like', '%'.$search.'%');
                }),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        return $display;
    }

    public function onEdit($id = null, $payload = [])
    {
        $attributes = $this->getModelValue()->params;
        $elements = [
            AdminFormElement::text('name', 'Название')->setReadonly(true)
        ];

        foreach ($attributes as $attribute) {
            $elements[] = $this->getFormElementFromName(
                $attribute['control'],
                $attribute['name'],
                $attribute['label']
            )->setValidationRules($attribute['rules'] ?? null);
        }

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn($elements)
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

}
