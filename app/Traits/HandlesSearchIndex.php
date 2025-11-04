<?php

namespace App\Traits;

use App\Models\SearchIndex;
use Illuminate\Support\Facades\Log;


trait HandlesSearchIndex
{
    public static function bootHandlesSearchIndex()
    {
        static::created(function ($model) {
            static::syncSearchIndex($model);
        });

        static::updated(function ($model) {
            $type = static::getSearchType();

            SearchIndex::where('item_type', $type)
                ->where('item_id', $model->getKey())
                ->update([
                    'title' => $model->title,
                    'category_slug' => $type,
                ]);
        });


        static::deleted(function ($model) {
            SearchIndex::where('item_type', static::getSearchType())
                ->where('item_id', $model->getKey())
                ->delete();
        });
    }

    protected static function syncSearchIndex($model)
    {
        if ($model->add_status !== 'Valid') {
            return; 
        }
        $type = static::getSearchType();

        $existing = SearchIndex::where('item_type', $type)
            ->where('item_id', $model->getKey())
            ->first();

        if ($existing) {
            $existing->update([
                'category_slug' => $type,
                'title' => $model->title,
            ]);
        } else {
            SearchIndex::create([
                'item_type' => $type,
                'item_id' => $model->getKey(),
                'category_slug' => $type,
                'title' => $model->title,
            ]);
        }
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
