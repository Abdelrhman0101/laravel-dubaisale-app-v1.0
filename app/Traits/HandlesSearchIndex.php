<?php

namespace App\Traits;

use App\Models\SearchIndex;

trait HandlesSearchIndex
{
    public static function bootHandlesSearchIndex()
    {
        static::created(function ($model) {
            static::syncSearchIndex($model);
        });

        static::updated(function ($model) {
            static::syncSearchIndex($model);
        });

        static::deleted(function ($model) {
            SearchIndex::where('item_type', static::getSearchType())
                ->where('item_id', $model->id)
                ->delete();
        });
    }

    protected static function syncSearchIndex($model)
    {
        SearchIndex::updateOrCreate(
            [
                'item_type' => static::getSearchType(),
                'item_id' => $model->id,
            ],
            [
                'category_slug' => static::getSearchType(),
                'title' => $model->title,
            ]
        );
    }

    /**
     * Get the search type for the model.
     * Models using this trait should define a static $searchType property.
     * 
     * @return string
     */
    protected static function getSearchType()
    {
        if (property_exists(static::class, 'searchType')) {
            /** @var class-string $class */
            $class = static::class;
            return $class::$searchType;
        }
        
        return class_basename(static::class);
    }
}
