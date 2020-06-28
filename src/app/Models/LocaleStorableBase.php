<?php

namespace App\Models;

/**
 * App\Models\LocaleStorableBase
 *
 * @mixin \Eloquent
 */
class LocaleStorableBase extends Base
{
    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = strtolower($locale);
        $this->save();
    }
}
