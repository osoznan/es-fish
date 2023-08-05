<?php

namespace App\Admin\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Components\ImageManager;
use App\Http\Requests\CreateImageRequest;
use App\Http\Requests\MainGalleryCreateRequest;
use App\Http\Requests\MainGalleryUpdateRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Widgets\Admin\ImageColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class ImageSection
 *
 * @property \App\Models\Image $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class MainGallerySection extends Section implements Initializable
{
    use TSectionValidator;

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Главная галерея';

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
            AdminColumn::link('title', 'Title')
                ->setSearchCallback(function($column, $query, $search){
                    return $query
                        ->orWhere('name', 'like', '%'.$search.'%');
                }),
            AdminColumn::text('text', 'Text'),
            AdminColumn::text('link', 'Link'),
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
        $image = AdminFormElement::image('fullUrl', 'Image');
        $image = $id ? $image->setReadonly(true) : $image;

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title', 'Title'),
                AdminFormElement::text('link', 'Link'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('text', 'Text')->setRows(3),
                AdminFormElement::selectajax('image_id', 'Image')
                    ->setModelForOptions(Image::class)
                    ->setSearch('name')
                    ->setDisplay(function ($model) {
                        return '<a href="'.ImageManager::getPhotosUrl($model->url).'" data-toggle="lightbox">
                                <img src="'.ImageManager::getThumbsUrl($model->url).'" width="60" height="50">
                            </a>
                            <span style="cursor: pointer">'.$model->name.'</span>';
                    }),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),

            AdminFormElement::html('<hr>'),

            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title_en', 'Title EN'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('text_en', 'Text EN')->setRows(3),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),

            AdminFormElement::html('<hr>'),

            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title_ua', 'Title UA'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('text_ua', 'Text UA')->setRows(3),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),


        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        $this->attachValidators($form,
            ($id > 0 ? (new MainGalleryUpdateRequest()) : (new MainGalleryCreateRequest()))->rules()
        );

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
