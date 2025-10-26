<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasRank
{

    public function getNextRank($modelClass): int
    {
        return DB::transaction(function () use ($modelClass) {
            $table = (new $modelClass)->getTable();

            $maxRank = DB::table($table)->lockForUpdate()->max('rank');

            return ($maxRank ?? 0) + 1;
        });
    }

    public function makeRankOne($modelClass, $adId): bool
    {
        return DB::transaction(function () use ($modelClass, $adId) {
            $model = new $modelClass;
            $table = $model->getTable();
            DB::table($table)->lockForUpdate()->get();

            $ad = $modelClass::where('id', $adId)->lockForUpdate()->first();
            if (!$ad)
                return false;

            DB::table($table)->increment('rank');
            $ad->update(['rank' => 1]);

            return true;
        });
    }
}
