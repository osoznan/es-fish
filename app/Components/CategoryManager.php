<?php

namespace App\Components;

use App\Models\Category;
use App\Components\Translation as t;
use Illuminate\Support\Facades\Cache;

class CategoryManager {

    public const CACHE_KEY = 'CategoryManager-list';

    public static function getAll($key = null) {
        if (!Cache::has(static::CACHE_KEY)) {
            Cache::put(
                static::CACHE_KEY,
                Category::search()
                    ->get()->keyBy('id'),
                120
            );
        }

        $all = Cache::get(static::CACHE_KEY);

        return !$key ? $all : $all[$key];
    }


    public static function getCategory($id) {
        $all = static::getAll();
        if (isset($all[$id])) {
            return $all[$id];
        }
    }

    /**
     * @param int $categoryId id of category or subcategory
     * @return string
     */
    public static function getUrl($categoryId) {
        $subCategoryAlias = t::getLocaleField($category = static::getCategory($categoryId), 'alias');
        $categoryAlias = $category->parent_category_id ? t::getLocaleField(static::getCategory($category->parent_category_id), 'alias') : '';

        return '/' . t::getLocale() . ($categoryAlias  ? ('/' . $categoryAlias) : '') . ($subCategoryAlias ? ('/' .$subCategoryAlias) : '');
    }

    public static function getCategoryInfo($catAlias, $subCatAlias) {

        $category = Category::search()
            ->where([t::getLocaleFieldName('alias') => $catAlias, 'hidden' => 0])
            ->first();

        if ($subCatAlias) {
            $subCategory = Category::search()
                ->where([
                    t::getLocaleFieldName('alias') => $subCatAlias,
                    'parent_category_id' => $category->id,
                    'hidden' => 0
                ])->first();
        }

        return [$category, $subCategory ?? null];
    }
}
