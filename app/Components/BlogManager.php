<?php

namespace App\Components;

use App\Models\BlogArticle;
use App\Components\Translation as t;

class BlogManager {

    const CATEGORY_ALIASES = [
        'ru' => [1 => 'Новости', 2 => 'Рецепты', 3 => 'Статьи'],
        'ua' => [1 => 'Новини', 2 => 'Рецепти', 3 => 'Статті'],
        'en' => [1 => 'news', 2 => 'recipes', 3 => 'articles']

    ];

    public static function getUrl(BlogArticle $article) {
        $locale = Translation::getLocale();
        return ($locale != 'ru' ? ('/' . $locale) : '') . '/blog/' . static::getCategoryAlias($article->category_id) . '/' . $article->getLocaleAlias();
    }

    public static function getCategoryUrl($id) {
        $locale = Translation::getLocale();
        return ($locale != 'ru' ? ('/' . $locale) : '') . '/blog/' . static::getCategoryAlias($id);
    }

    public static function getCategoryAlias($id, $lang = null) {
        if (is_int((int)$id)) {
            return static::CATEGORY_ALIASES['en'][$id];
        }

        throw new \Exception('wrong blog category id: ' . $id);
    }

    public static function getCategoryIdByAlias($alias) {
        return array_search($alias, static::CATEGORY_ALIASES['en']);
    }
}
