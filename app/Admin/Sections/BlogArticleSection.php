<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Components\BlogManager;
use App\Components\ImageManager;
use App\Http\Requests\BlogArticleCreateRequest;
use App\Http\Requests\BlogArticleUpdateRequest;
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
 * Class BlogArticleSection
 *
 * @property \App\Models\BlogArticle $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class BlogArticleSection extends Section implements Initializable
{
    use TSectionValidator;

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Статьи';

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
            AdminColumn::link('title', 'title', 'created_at')
                ->setSearchCallback(function($column, $query, $search){
                    return $query
                        ->orWhere('title', 'like', '%'.$search.'%')
                    ;
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('created_at', $direction);
                })
            ,
            AdminColumn::boolean('hidden', 'Off'),
            AdminColumn::custom('url', function($model) {
                return ImageColumn::widget(['filename' => $model->image->url]);
            }),
            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
                ->setWidth('160px')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('updated_at', $direction);
                })
                ->setSearchable(false)
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

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\BlogArticle::class, 'name')
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
                AdminFormElement::text('title', 'Name'),
                AdminFormElement::select('category_id', 'Category Id', BlogManager::CATEGORY_ALIASES['ru']),
                AdminFormElement::selectajax('image_id', 'Image')
                    ->setModelForOptions(Image::class)
                    ->setSearch(['name' => 'contains', 'description' => 'contains'])
                    ->setDisplay(function ($model) {
                        return '<a href="'.ImageManager::getPhotosUrl($model->url).'" data-toggle="lightbox">
                                <img src="'.ImageManager::getThumbsUrl($model->url).'" width="60" height="50">
                            </a>
                            <span style="cursor: pointer">'.$model->name.'</span>';
                    }),
                AdminFormElement::checkbox('hidden', 'Hidden'),
                AdminFormElement::datetime('created_at', 'Created At')->setReadonly(true),
            ], 'col-xs-12 col-sm-4')->addColumn([
                AdminFormElement::wysiwyg('text', 'Text'),
            ], 'col-xs-12 col-sm-8'),

            AdminFormElement::html('<hr>'),

            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title_en', 'Title EN'),
            ], 'col-xs-12 col-sm-4')->addColumn([
                AdminFormElement::wysiwyg('text_en', 'Text EN'),
            ], 'col-xs-12 col-sm-8'),

            AdminFormElement::html('<hr>'),

            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title_ua', 'Title UA')
                    ->required()
                ,
            ], 'col-xs-12 col-sm-4')->addColumn([
                AdminFormElement::wysiwyg('text_ua', 'Text UA')
                    ->required()
                ,
            ], 'col-xs-12 col-sm-8')
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        $this->attachValidators($form, ($id > 0 ? (new BlogArticleUpdateRequest()) : (new BlogArticleCreateRequest()))->rules());

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

    public function getAlias()
    {
        return 'articles';
    }
}
