<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Components\ImageManager;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Image;
use App\Widgets\Admin\ImageColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class ProductCategorySection
 *
 * @property \App\Models\Category $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class ProductCategorySection extends Section implements Initializable
{
    use TSectionValidator;
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Категории';

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
            AdminColumn::text('id', '#')
                ->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('name', 'Name', 'descriptionShort')
                ->setSearchCallback(function($column, $query, $search){
                    return $query
                        ->orWhere('name', 'like', '%'.$search.'%');
                })
            ,
            AdminColumn::text('parent.name', 'Parent'),
            AdminColumn::custom('Image', function($model) {
                return ImageColumn::widget(['filename' => $model->image->url ?? '']);
            }),
            AdminColumnEditable::checkbox('hidden', 'Hidden'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(20)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->with('parent', 'image')
        ;

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Category::class, 'name')
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
                AdminFormElement::text('name', 'Name'),
                AdminFormElement::selectajax('parent_category_id', 'Parent Category')
                    ->setModelForOptions(Category::class)
                    ->setSearch('name')
                    ->setDisplay(function ($model) {
                        return $model->name;
                    }),
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
                AdminFormElement::checkbox('hidden', 'Hidden'),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),

            AdminFormElement::html('<hr>'),

            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name_en', 'Name EN'),
                AdminFormElement::text('seo_title_en', 'Seo Title EN'),
                AdminFormElement::text('seo_keywords_en', 'Seo Keywords EN'),
                AdminFormElement::text('seo_description_en', 'Seo Description EN'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('description', 'Description EN')
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),

            AdminFormElement::html('<hr>'),

            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name_ua', 'Name UA'),
                AdminFormElement::text('seo_title_ua', 'Seo Title UA'),
                AdminFormElement::text('seo_keywords_ua', 'Seo Keywords UA'),
                AdminFormElement::text('seo_description_ua', 'Seo Description UA'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('description', 'Description UA')
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        $this->attachValidators($form, ($id > 0 ? (new UpdateCategoryRequest()) : (new CreateCategoryRequest()))->rules());

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
