<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Components\ImageManager;
use App\Models\Image;
use App\Widgets\Admin\ImageColumn;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class ProductSection
 *
 * @property \App\Models\Product $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class ProductSection extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Продукты';

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
            AdminColumn::text('id', '#')->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('name', 'Name', 'description')
                ->setSearchCallback(function($column, $query, $search){
                    return $query
                        ->orWhere('name', 'like', '%'.$search.'%')
                        ->orWhere('created_at', 'like', '%'.$search.'%')
                    ;
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('created_at', $direction);
                })
            ,
            AdminColumn::boolean('hidden', 'Hidden'),
            AdminColumn::custom('Image', function($model) {
                return ImageColumn::widget(['filename' => $model->image->url]);
            }),
            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
            ,
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
                AdminFormElement::text('name', 'Name'),
                AdminFormElement::number('price', 'Price'),
                AdminFormElement::number('old_price', 'Old Price'),
                AdminFormElement::number('weight', 'Weight'),
                AdminFormElement::select('calc_type', 'Calc Type', ['0' => 'Type 1', '1' => 'Type 2']),
                AdminFormElement::text('seo_title', 'Seo Title'),
                AdminFormElement::text('seo_keywords', 'Seo Keywords'),
                AdminFormElement::text('seo_description', 'Seo Description'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('description', 'Description'),
                AdminFormElement::selectajax('image_id', 'Image')
                    ->setModelForOptions(Image::class)
                    ->setSearch('name')
                    ->setDisplay(function ($model) {
                        return '<a href="'.ImageManager::getPhotosUrl($model->url).'" data-toggle="lightbox">
                                <img src="'.ImageManager::getThumbsUrl($model->url).'" width="60" height="50">
                            </a>
                            <span style="cursor: pointer">'.$model->name.'</span>';
                    }),
                AdminFormElement::multiselectajax('image_ids', 'Images')
                    ->setModelForOptions(Image::class)
                    ->setSearch('name')
                    ->setDisplay(function ($model) {
                        return '<a href="'.ImageManager::getPhotosUrl($model->url).'" data-toggle="lightbox">
                                <img src="'.ImageManager::getThumbsUrl($model->url).'" width="60" height="50">
                            </a>
                            <span style="cursor: pointer">'.$model->name.'</span>';
                    }),
                AdminFormElement::checkbox('hidden', 'Hidden'),
                AdminFormElement::checkbox('present', 'Present'),
                AdminFormElement::text('properties', 'Properties'),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),

            AdminFormElement::html('<hr>'),

            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name_en', 'Name EN'),
                AdminFormElement::text('seo_title_en', 'Seo Title EN'),
                AdminFormElement::text('seo_keywords_en', 'Seo Keywords EN'),
                AdminFormElement::text('seo_description_en', 'Seo Description EN'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('description_en', 'Description EN'),
                AdminFormElement::text('properties_en', 'Properties EN')
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),

            AdminFormElement::html('<hr>'),

            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name_ua', 'Name UA'),
                AdminFormElement::text('seo_title_ua', 'Seo Title UA'),
                AdminFormElement::text('seo_keywords_ua', 'Seo Keywords UA'),
                AdminFormElement::text('seo_description_ua', 'Seo Description UA')
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('description_ua', 'Description UA'),
                AdminFormElement::text('properties_ua', 'Properties')
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8')
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
