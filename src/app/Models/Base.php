<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Base
 *
 * @mixin \Eloquent
 */
class Base extends Model
{
    /**
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getConnectionNameStatic()
    {
        return with(new static)->getConnectionName();
    }

    public function getEditableColumns()
    {
        return $this->fillable;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getLocalizedColumn($key)
    {
        $locale = \App::getLocale();
        if (empty($locale)) {
            $locale = 'en';
        }
        $localizedKey = $key.'_'.strtolower($locale);
        $value = $this->$localizedKey;
        if (empty($value)) {
            $localizedKey = $key.'_en';
            $value = $this->$localizedKey;
        }

        return $value;
    }

    public function getFillableColumns()
    {
        return $this->fillable;
    }
}
