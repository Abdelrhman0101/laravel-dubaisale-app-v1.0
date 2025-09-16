<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\CarTrim;
use App\Models\CarYear;
use Illuminate\Http\Request;

class CarSaleFilterManagementController extends Controller
{
    // ====== Car Makes Management ======
    public function getMakes() { return response()->json(CarMake::orderBy('name')->get()); }
    public function addMake(Request $request) {
        $data = $request->validate(['name' => 'required|string|unique:car_makes,name']);
        return response()->json(CarMake::create($data), 201);
    }
    public function updateMake(Request $request, CarMake $make) {
        $data = $request->validate(['name' => 'required|string|unique:car_makes,name,' . $make->id]);
        $make->update($data);
        return response()->json($make);
    }
    public function deleteMake(CarMake $make) {
        $make->delete();
        return response()->json(null, 204);
    }

    // ====== Car Models Management ======
    public function getModels($makeId) { 
        // التحقق من صحة الـ ID
        if ($makeId == -1 || !is_numeric($makeId)) {
            return response()->json([], 200); // إرجاع قائمة فارغة بدلاً من خطأ 404
        }
        
        $make = CarMake::find($makeId);
        if (!$make) {
            return response()->json([], 200); // إرجاع قائمة فارغة بدلاً من خطأ 404
        }
        
        return response()->json($make->carModels()->orderBy('name')->get()); 
    }
    public function addModel(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'car_make_id' => 'required|exists:car_makes,id'
        ]);
        return response()->json(CarModel::create($data), 201);
    }
    public function updateModel(Request $request, CarModel $model) {
        $data = $request->validate(['name' => 'required|string']);
        $model->update($data);
        return response()->json($model);
    }
    public function deleteModel(CarModel $model) {
        $model->delete();
        return response()->json(null, 204);
    }

    // ====== Car Trims Management ======
    public function getTrims($modelId) { 
        // التحقق من صحة الـ ID
        if ($modelId == -1 || !is_numeric($modelId)) {
            return response()->json([], 200); // إرجاع قائمة فارغة بدلاً من خطأ 404
        }
        
        $model = CarModel::find($modelId);
        if (!$model) {
            return response()->json([], 200); // إرجاع قائمة فارغة بدلاً من خطأ 404
        }
        
        return response()->json($model->carTrims()->orderBy('name')->get()); 
    }
    public function addTrim(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'car_model_id' => 'required|exists:car_models,id'
        ]);
        return response()->json(CarTrim::create($data), 201);
    }
    public function updateTrim(Request $request, CarTrim $trim) {
        $data = $request->validate(['name' => 'required|string']);
        $trim->update($data);
        return response()->json($trim);
    }
    public function deleteTrim(CarTrim $trim) {
        $trim->delete();
        return response()->json(null, 204);
    }

    // ====== Car Years Management ======
    public function getYears() {
        return response()->json(CarYear::orderBy('year', 'desc')->get());
    }

    public function addYear(Request $request) {
        $data = $request->validate(['year' => 'required|integer|unique:car_years,year']);
        return response()->json(CarYear::create($data), 201);
    }

    public function updateYear(Request $request, CarYear $year) {
        $data = $request->validate(['year' => 'required|integer|unique:car_years,year,' . $year->id]);
        $year->update($data);
        return response()->json($year);
    }

    public function deleteYear(CarYear $year) {
        $year->delete();
        return response()->json(null, 204);
    }
}