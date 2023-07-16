<?php

namespace App\Components;

use App\Models\BlogArticle;

class BlogManager {

    const CATEGORY_ALIASES = [
        'ru' => [1 => 'Новости', 2 => 'Рецепты', 3 => 'Статьи'],
        'ua' => [1 => 'novyny', 2 => 'recepty', 3 => 'statji'],
        'en' => [1 => 'news', 2 => 'recipes', 3 => 'articles']

    ];

    public static function getUrl(BlogArticle $article) {
        return '/' . Translation::getLocale() . '/blog/' . static::getCategoryAlias($article->category_id) . '/' . $article->getLocaleAlias();
    }

    public static function getCategoryUrl($id) {
        return '/' . Translation::getLocale() . '/blog/' . static::getCategoryAlias($id);
    }

    public static function getCategoryAlias($id, $lang = null) {
        if (is_int((int)$id)) {
            return static::CATEGORY_ALIASES[$lang ?? Translation::getLocale()][$id];
        }

        throw new \Exception('wrong blog category id: ' . $id);
    }

    public static function getCategoryIdByAlias($alias) {
        foreach (static::CATEGORY_ALIASES as $aliases) {
            return array_search($alias, $aliases);
        }
    }
}
