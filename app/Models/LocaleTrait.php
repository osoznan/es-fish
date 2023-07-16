<?php

namespace App\Models;

use App\Components\Translation as t;

trait LocaleTrait {

    public function locale($attribute, $lang = null) {
        return t::getLocaleField($this, $attribute, $lang);
    }

    public function localeField($attribute, $lang = null) {
        return t::getLocaleFieldName($attribute, $lang);
    }

    public function localeFieldValue($attribute, $lang = null) {
        return $this->{t::getLocaleFieldName($attribute, $lang)};
    }

    public function getLocaleAlias($lang = null) {

        return t::getLocaleField($this, 'alias', $lang);
    }

}
