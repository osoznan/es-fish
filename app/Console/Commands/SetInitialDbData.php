<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\DeliveryType;
use App\Models\ModuleData;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ProductImage;
use Faker\Factory;
use Illuminate\Console\Command;

class SetInitialDbData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-initial-db-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Иннициализация дефолтных данных с начала работы магазина';

    protected array $categoryData = [
        1 => [
            'name' => 'РЫБА И МОРЕПРОДУКТЫ',
            'children' => ['Вяленая рыба', 'Рыба холодного копчения', 'Рыба горячего копчения', 'Слабосоленая рыба',
                'Свежезамороженная рыба', 'Свежезамороженные морепродукты']
        ],
        2 => [
            'name' => 'ПТИЦА',
            'children' => ['Утка холодного копчения', 'Утка сыровяленая']
        ],
        3 => [
            'name' => 'МЯСО',
            'children' => ['Ветчина сыровяленая', 'Вяленая баранина']
        ],
        4 => [
            'name' => 'СЫРЫ',
            'children' => ['Брынза овечья', 'Брынза коровья']
        ],
        5 => [
            'name' => 'НАПИТКИ',
            'children' => ['Крепкий алкоголь', 'Вино', 'Настойки/Наливки']
        ],
        6 => [
            'name' => 'НАБОРЫ ДЛЯ ОТДЫХА',
            'children' => ['Наборы для отдыха Strong', 'Наборы для отдыха DeLuxe', 'Наборы для отдыха Soft', 'Наборы для отдыха Premium']
        ],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
/*        ProductImage::truncate();
        Product::truncate();
        Category::truncate();*/

        $this->addCommonLists(); return 1;

        \DB::transaction(function () {

            $faker = Factory::create();

            foreach ($this->categoryData as $key => $category) {
                $newCat = new Category();
                $newCat->id = $key;
                $newCat->name = $category['name'];
                $newCat->name_en = $category['name'];
                $newCat->name_ua = $category['name'];
                $newCat->description = $faker->text;
                $newCat->description_en = $faker->text;
                $newCat->description_ua = $faker->text;
                $newCat->main_page_present = 0;
                $newCat->save();
            }

            foreach ($this->categoryData as $key => $category) {
                foreach ($category['children'] as $subCatName) {
                    $newCat = new Category();
                    $newCat->parent_category_id = $key;
                    $newCat->name = $subCatName;
                    $newCat->name_en = $subCatName;
                    $newCat->name_ua = $subCatName;
                    $newCat->description = $faker->text;
                    $newCat->description_en = $faker->text;
                    $newCat->description_ua = $faker->text;
                    $newCat->image_id = random_int(1, 10);
                    $newCat->main_page_present = 0;
                    $newCat->save();

                    for ($i = 0; $i < random_int(2, 6); $i++) {
                        $product = new Product([
                            'category_id' => $newCat->id,
                            'name' => $name = $faker->name,
                            'name_en' => $name,
                            'name_ua' => $name,
                            'description' => $description = $faker->text,
                            'description_en' => $description,
                            'description_ua' => $description,
                            'price' => random_int(10, 1000),
                            'old_price' => random_int(10, 1000),
                            'weight' => random_int(1, 7),
                            'image_id' => random_int(1, 10),
                            'calc_type' => $faker->randomElement([0, 1]),
                            'hidden' => $faker->randomElement([0, 0, 0, 1]),
                            'menu_present' => $faker->randomElement([0, 0, 1]),
                            'properties' => $faker->text(50)
                        ]);
                        $product->save();
                    }
                }
            }

        });

        echo 'Done';
    }

    function addCommonLists() {
        //PaymentType::truncate();
        PaymentType::query()->insert([
            ['id' => 1, 'name' => 'Наличными', 'name_en' => 'Cash', 'name_ua' => 'Готiвка'],
	        ['id' => 2, 'name' => 'Безналичный расчет', 'name_en' => 'Cash 2', 'name_ua' => 'Безготiвковий розрахунок'],
            ['id' => 3, 'name' => 'Предоплата на карту "ПриватБанка"', 'name_en' => 'Pre-pay, credit card', 'name_ua' => 'Передоплата на ПриватБанк'],
            ['id' => 4, 'name' => 'Наложенный платеж', 'name_en' => 'who knows', 'name_ua' => 'Накладний платiж']
        ]);

        //DeliveryType::truncate();
        DeliveryType::query()->insert([
            ['id' => 1, 'name' => 'Самовывоз', 'name_en' => 'Delivery by oneself', 'name_ua' => 'Самовывiз'],
            ['id' => 2, 'name' => 'Курьер', 'name_en' => 'Delivery', 'name_ua' => 'Кур\'ер'],
            ['id' => 3, 'name' => 'Новая почта', 'name_en' => 'Nova Poshta', 'name_ua' => 'Нова пошта'],
            ['id' => 4, 'name' => 'Другие способы доставки', 'name_en' => 'Other', 'name_ua' => 'Iншi способи доставки']
        ]);

        //DeliveryType::truncate();
        DeliveryType::query()->insert([
            ['id' => 1, 'name' => 'Самовывоз', 'name_en' => 'Delivery by oneself', 'name_ua' => 'Самовывiз'],
            ['id' => 2, 'name' => 'Курьер', 'name_en' => 'Delivery', 'name_ua' => 'Кур\'ер'],
            ['id' => 3, 'name' => 'Новая почта', 'name_en' => 'Nova Poshta', 'name_ua' => 'Нова пошта'],
            ['id' => 4, 'name' => 'Другие способы доставки', 'name_en' => 'Other', 'name_ua' => 'Iншi способи доставки']
        ]);
    }

    function setModuleData() {
        $data = [
            [
                'name' => 'seo-mainpage-module',
                'module_title' => 'СЕО на главной',
                'params' => '[{"name": "title", "label": "Заголовок", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content", "label": "Текст", "rules": "required|string|min:20|max:5000", "control": "textarea"}, {"name": "image", "label": "Картинка", "control": "image"}, {"name": "title_en", "label": "Заголовок EN", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_en", "label": "Текст EN", "rules": "required|string|min:20|max:5000", "control": "textarea"}, {"name": "title_ua", "label": "Заголовок UA", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_ua", "label": "Текст UA", "rules": "required|string|min:20|max:5000", "control": "textarea"}]',
                'hidden' => 0
            ],
            [
                'name' => 'about',
                'module_title' => 'Страница "О нас"',
                'params' => '[{"name": "title", "label": "Заголовок", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content", "label": "Текст", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_en", "label": "Заголовок EN", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_en", "label": "Текст EN", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_ua", "label": "Заголовок UA", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_ua", "label": "Текст UA", "rules": "required|string|min:50|max:20000", "control": "textarea"}]',
                'hidden' => 0
            ],
            [
                'name' => 'cooperation',
                'module_title' => 'Страница "Сотрудничество"',
                'params' => '[{"name": "title", "label": "Заголовок", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content", "label": "Текст", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_en", "label": "Заголовок EN", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_en", "label": "Текст EN", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_ua", "label": "Заголовок UA", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_ua", "label": "Текст UA", "rules": "required|string|min:50|max:20000", "control": "textarea"}]',
                'hidden' => 0
            ],
            [
                'name' => 'guarantees',
                'module_title' => 'Страница "Гарантии"',
                'params' => '[{"name": "title", "label": "Заголовок", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content", "label": "Текст", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_en", "label": "Заголовок EN", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_en", "label": "Текст EN", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_ua", "label": "Заголовок UA", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_ua", "label": "Текст UA", "rules": "required|string|min:50|max:20000", "control": "textarea"}]',
                'hidden' => 0
            ],
            [
                'name' => 'delivery-payment',
                'module_title' => 'Страница "Доставка и оплата"',
                'params' => '[{"name": "title", "label": "Заголовок", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content", "label": "Текст", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_en", "label": "Заголовок EN", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_en", "label": "Текст EN", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_ua", "label": "Заголовок UA", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_ua", "label": "Текст UA", "rules": "required|string|min:50|max:20000", "control": "textarea"}]',
                'hidden' => 0
            ],
            [
                'name' => 'faq',
                'module_title' => 'Страница "FAQ"',
                'params' => '[{"name": "title", "label": "Заголовок", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content", "label": "Текст", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_en", "label": "Заголовок EN", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_en", "label": "Текст EN", "rules": "required|string|min:50|max:20000", "control": "textarea"}, {"name": "title_ua", "label": "Заголовок UA", "rules": "required|string|min:5|max:50", "control": "text"}, {"name": "content_ua", "label": "Текст UA", "rules": "required|string|min:50|max:20000", "control": "textarea"}]',
                'hidden' => 0
            ],
        ];

        ModuleData::insert($data);
    }
}
