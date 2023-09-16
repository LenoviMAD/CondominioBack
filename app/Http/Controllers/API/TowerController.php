<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\TowerDetail;
use App\Models\Apartment;
use App\Models\Tower;

class TowerController extends BaseController
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'tower' => 'required',
            ]);

            $inputs = $request->all();

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }

            foreach ($inputs['tower'] as &$item) {

                // $towerD = new tower();

                // $towerD->idTower = $tower['idTower'];
                // $towerD->name = $tower['name'];
                // $towerD->nApartments = $tower['nApartments'];
                // $towerD->nApartmentsXFloor = $tower['nApartmentsXFloor'];
                // $towerD->nFloor = $tower['nFloor'];
                // $towerD->save();

                $tower = Tower::create($item);
                $item = Arr::add($item, 'id', $tower['id']);
                // return $this->sendResponse('warning', 'Torres guardados correctamente', 100, $tower);
            }


            DB::commit();
            return $this->sendResponse('positive', 'Torres guardados correctamente', 100, $inputs);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'tower' => 'required',
            ]);

            $inputs = $request->all();

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }

            foreach ($inputs['tower'] as $tower) {

                $towerD = Tower::where('id', '=', $tower['id'])->first();
                $towerD->id = $tower['id'];
                $towerD->name = $tower['name'];
                $towerD->nApartments = $tower['nApartments'];
                $towerD->nApartmentsXFloor = $tower['nApartmentsXFloor'];
                $towerD->save();
                // return $this->sendResponse('warning', 'Torres guardados correctamente', 100, $towerDetail);
            }


            DB::commit();
            return $this->sendResponse('positive', 'Torres actualizada correctamente', 100, $inputs);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
}
