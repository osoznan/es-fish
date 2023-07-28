<?php

namespace App\Components;

use App\Facades\Telegram;
use App\Models\Category;
use App\Components\Translation as t;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CategoryManager {

    public const CACHE_KEY = 'CategoryManager-list';

    public static function getAll($key = null) {
        if (!Cache::has(static::CACHE_KEY)) {
            Cache::put(
                static::CACHE_KEY,
                Category::searchActive()->with('image')
                    ->get()->keyBy('id'),
                120
            );
        }

        $all = Cache::get(static::CACHE_KEY);

        return !$key ? $all : $all[$key];
    }


    public static function getCategory($id) {
        return self::tryHitCachedCategories($id);

        $all = static::getAll();
        if (isset($all[$id])) {
            return $all[$id];
        }

        return null;
    }

    protected static function getParent(Category $category) {
        return self::tryHitCachedCategory($category->parent_category_id) ?? $category->parent;
    }

    /**
     * @param int $categoryId id of category or subcategory
     * @return string
     */
    public static function getUrl($category): string {
        $subCategoryAlias = t::getLocaleField($category, 'alias');
        $categoryAlias = $category->parent_category_id > 0 ?
            t::getLocaleField(self::getParent($category), 'alias') : '';

        return (t::getLocale() != 'ru' ? ('/' . t::getLocale()) : null) . ($categoryAlias  ? ('/' . $categoryAlias) : '') . ($subCategoryAlias ? ('/' .$subCategoryAlias) : '');
    }

    public static function getCategoryInfo(string $catAlias, ?string $subCatAlias): array {
        $category = Category::searchActive()
            ->where(t::getLocaleFieldName('alias'), $catAlias)
            ->first();

        if ($subCatAlias) {
            Log::debug('category alias ' . $catAlias . $_SERVER['REQUEST_URI']);

            $subCategory = Category::searchActive()->where([
                t::getLocaleFieldName('alias') => $subCatAlias,
                'parent_category_id' => $category->id
            ])->first();
        }

        return [$category, $subCategory ?? null];
    }

    /**
     * Категории и товары топовых категорий лучше кешануть
     */
    public static function tryHitCachedCategory($id) {
        if (!Cache::has(static::CACHE_KEY)) {
            Cache::put(
                static::CACHE_KEY,
                Category::searchTopMost()
                    ->with('image')->with('parent')
                    ->get()->keyBy('id'),
                60
            );
        }

        return Cache::get(static::CACHE_KEY)[$id] ?? null;
    }
}
