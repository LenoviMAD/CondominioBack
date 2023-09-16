<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\Tower;
use App\Models\Apartment;
use GrahamCampbell\ResultType\Success;


class ApartmentController extends BaseController
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


            $arraySuccess = [];
            $saveApartment = [];
            // $saveApartment = new \stdClass();
            foreach ($inputs['tower'] as $tower) {

                foreach ($tower['apartments'] as $apartment) {
                    $saveApartment['idTower'] = $tower['id'];
                    $saveApartment['name'] = $apartment['name'];
                    $saveApartment['floor'] = $apartment['floor'];
                    $saveApartment['apartment'] = $apartment['apartment'];
                    $saveApartment['intercom'] = $apartment['intercom'];
                    $saveApartment['parking'] = $apartment['parking'];
                    $saveApartment['aliquot'] = $apartment['aliquot'];
                    $save = Apartment::create($saveApartment);
                }
                $success = DB::table('apartment')
                    ->select(
                        'id',
                        'idTower',
                        'idUser',
                        'name',
                        'floor',
                        'apartment',
                        'intercom',
                        'parking',
                        'aliquot',
                    )
                    ->orderBy('id')
                    ->where('idTower', $tower['id'])->get();

                array_push($arraySuccess, $success);
            }


            DB::commit();
            return $this->sendResponse('positive', 'Apartamentos guardados correctamente', 100, $arraySuccess);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }


    public function update(Request $request)
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

            foreach ($inputs['tower'] as $tower) {

                foreach ($tower['apartments'] as $apartment) {
                    // return $this->sendResponse('warning', 'Error de validación', 200, $apartment);
                    $saveApartment = Apartment::where('id', '=', $apartment['id'])->first();
                    $saveApartment->idTower = $tower['id'];
                    $saveApartment->name = $apartment['name'];
                    $saveApartment->intercom = $apartment['intercom'];
                    $saveApartment->parking = $apartment['parking'];
                    $saveApartment->aliquot = $apartment['aliquot'];
                    $saveApartment->save();
                }
            }


            DB::commit();
            return $this->sendResponse('positive', 'Apartamentos actualizados correctamente', 100, $inputs);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los tipos de rif
    public function getOwnerDocument(int $idUser)
    {
        try {

            $ownerData = DB::table('owner')
                ->select(
                    'document',
                )
                ->where('idUser', $idUser)->first();

            $document = [];
            $document['url'] = 'http://127.0.0.1:8000' . Storage::url($ownerData->document);
            $extracName = explode("/", $document['url']);
            $document['name'] = end($extracName);

            // $path = '/' . $ownerData->document;
            // $archive = Storage::disk('public')->get($path);
            // $document['archive'] = mb_convert_encoding($archive, 'UTF-8', 'UTF-8');

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $document);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
}
