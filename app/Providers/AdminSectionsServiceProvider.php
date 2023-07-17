<?php

namespace App\Providers;

use App\Models\BlogArticle;
use App\Models\Category;
use App\Models\Comment;
use App\Models\DeliveryType;
use App\Models\Image;
use App\Models\MainGallery;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentType;
use App\Models\Product;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        Product::class => 'App\Admin\Sections\ProductSection',
        Category::class => 'App\Admin\Sections\ProductCategorySection',
        Order::class => 'App\Admin\Sections\OrderSection',
        Image::class => 'App\Admin\Sections\ImageSection',
        BlogArticle::class => 'App\Admin\Sections\BlogArticleSection',
        Comment::class => 'App\Admin\Sections\FeedbackSection',
        DeliveryType::class => 'App\Admin\Sections\DeliveryTypeSection',
        OrderStatus::class => 'App\Admin\Sections\OrderStatusSection',
        PaymentType::class => 'App\Admin\Sections\PaymentTypeSection',
        MainGallery::class => 'App\Admin\Sections\MainGallerySection',
    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        $this->loadViewsFrom( base_path( "resources/views/" ), 'admin' );

        parent::boot($admin);
    }
}
