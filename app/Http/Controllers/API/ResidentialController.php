<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\Residential;
use PhpParser\Node\Expr\Cast\Object_;

class ResidentialController extends BaseController
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'idUser' => 'required',
                'name' => 'required',
                'nTowers' => 'required',
                'nApartmentsXTower' => 'required',
                'nFloorXTower' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }

            //Asignamos a una variable el valor del json
            $input = $request->all();

            Residential::create($input);

            DB::commit();
            return $this->sendResponse('positive', 'Datos de Residencia guardados correctamente', 100, $input);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function getNumberTower(int $idUser)
    {
        try {

            $prueba = DB::table('residential')
                ->select(
                    'residential.nTowers',
                )
                ->where('residential.idUser', $idUser)->count();


            if ($prueba) {

                $dataUser = DB::table('residential')
                    ->select('nTowers', 'id', 'name')
                    ->where('idUser', $idUser)
                    ->orderBy('id')
                    ->first();

                $dataUser->tower = DB::table('residential')
                    ->join('tower', 'residential.id', '=', 'tower.idResidential')
                    ->select(
                        'tower.id',
                        'tower.idResidential',
                        'tower.name',
                        'tower.nApartments',
                        'tower.nApartmentsXFloor',
                        'tower.nFloor',
                    )
                    ->orderBy('tower.id')
                    ->where('residential.idUser', $idUser)->get();

                $dataUser->apartment = DB::table('residential')
                    ->join('tower', 'residential.id', '=', 'tower.idResidential')
                    ->join('apartment', 'tower.id', '=', 'apartment.idTower')
                    ->select(
                        'apartment.id',
                        'apartment.idTower',
                        'apartment.idUser',
                        'apartment.name',
                        'apartment.floor',
                        'apartment.apartment',
                        'apartment.intercom',
                        'apartment.parking',
                        'apartment.aliquot',
                    )
                    ->orderBy('apartment.id')
                    ->where('residential.idUser', $idUser)->get();
            } else {
                $dataUser = DB::table('residential')
                    ->select('nTowers')
                    ->where('idUser', $idUser)
                    ->orderBy('id')
                    ->first();
            }


            return $this->sendResponse('positive', 'Datos de torres', 100, $dataUser);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function getAliquotDifferent(int $idResidential)
    {
        try {
            $dataAliquot = DB::table('residential')
                ->join('tower', 'residential.id', '=', 'tower.idResidential')
                ->join('apartment', 'tower.id', '=', 'apartment.idTower')
                ->select(
                    'apartment.id',
                    'apartment.aliquot',
                )
                ->where('residential.id', $idResidential)
                ->distinct('aliquot')
                ->get();
            return $this->sendResponse('positive', 'Datos de torres', 100, $dataAliquot);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function getApartmentAliquot(int $idResidential)
    {
        try {
            $dataAliquot = DB::table('residential')
                ->join('tower', 'residential.id', '=', 'tower.idResidential')
                ->join('apartment', 'tower.id', '=', 'apartment.idTower')
                ->select(
                    'apartment.id',
                    'apartment.name',
                    'apartment.apartment',
                    'apartment.aliquot',
                )
                ->where('residential.id', $idResidential)
                ->get();
            return $this->sendResponse('positive', 'Datos de torres', 100, $dataAliquot);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function getResidentialById(int $idResidential)
    {
        try {
            $dataResidence = DB::table('residential')
                ->join('address', 'residential.id', '=', 'address.idEntity')
                ->leftJoin('logoResidential', 'residential.id', '=', 'logoResidential.idResidential')
                ->join('identity', 'residential.id', '=', 'identity.idEntity')
                ->join('entitySubClass', 'identity.idTypeDocument', '=', 'entitySubClass.id')
                ->select(
                    'residential.name',
                    'residential.nTowers',
                    'logoResidential.logo',
                    'address.description as address',
                    'identity.idTypeDocument',
                    'entitySubClass.code',
                    'identity.number',
                )
                ->where('residential.id', $idResidential)
                ->where('address.idTypeEntity', 131)
                ->where('identity.idTypeEntity', 131)
                ->first();

            if ($dataResidence->logo)
                $dataResidence->logoURL = 'http://127.0.0.1:8000' . Storage::url($dataResidence->logo);
            else
                $dataResidence->logoURL = null;

            return $this->sendResponse('positive', 'Datos de Residencia', 100, $dataResidence);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }


    public function getTowerCredential(int $idUser)
    {
        try {

            $element = DB::table('residential')
                ->join('tower', 'residential.id', '=', 'tower.idResidential')
                ->select(
                    'residential.nTowers',
                    'tower.id',
                )
                ->where('residential.idUser', $idUser)->count();
            if ($element) {
                $dataTower = DB::table('residential')
                    ->join('tower', 'residential.id', '=', 'tower.idResidential')
                    ->select('residential.nTowers', 'tower.id')
                    ->where('residential.idUser', $idUser)
                    ->orderBy('residential.id')
                    ->first();

                $dataTower->tower = DB::table('residential')
                    ->join('tower', 'residential.id', '=', 'tower.idResidential')
                    ->select(
                        'tower.id',
                        'tower.name',
                        'tower.nApartments',
                    )
                    ->orderBy('tower.id')
                    ->where('residential.idUser', $idUser)->get();

                $dataTower->apartment = DB::table('residential')
                    ->join('tower', 'residential.id', '=', 'tower.idResidential')
                    ->join('apartment', 'tower.id', '=', 'apartment.idTower')
                    ->leftJoin('user', 'apartment.idUser', '=', 'user.id')
                    ->select(
                        'apartment.id',
                        'apartment.idTower',
                        'apartment.idUser',
                        'apartment.name',
                        'user.email',
                        'apartment.apartment',
                        'apartment.floor',
                    )
                    ->orderBy('apartment.id')
                    ->where('residential.idUser', $idUser)->get();


                foreach ($dataTower->apartment as &$value) {

                    $element = DB::table('temp_auth')
                        ->select(
                            'id',
                        )
                        ->where('email', $value->email)->count();
                    if ($element) {
                        $value->changePassword = $element ? false : true;
                        $value->credentials = true;

                        $elementOwner = DB::table('owner')
                            ->select(
                                'id',
                                'document',
                            )
                            ->where('idApartment', $value->id)->first();


                        if ($elementOwner->document)
                            $value->documentURL = 'http://127.0.0.1:8000' . Storage::url($elementOwner->document);
                        else
                            $value->documentURL = null;
                    } else {
                        $element2 = DB::table('user')
                            ->select(
                                'id',
                            )
                            ->where('email', $value->email)->count();

                        $value->changePassword = $element2 ? true : false;
                        $value->credentials = $element2 ? true : false;
                        if ($element2) {
                            $elementOwner = DB::table('owner')
                                ->select(
                                    'id',
                                    'document',
                                )
                                ->where('idApartment', $value->id)->first();


                            if ($elementOwner->document)
                                $value->documentURL = 'http://127.0.0.1:8000' . Storage::url($elementOwner->document);
                            else
                                $value->documentURL = null;
                        } else {
                            $value->documentURL = null;
                        }
                    }
                }
            } else {
                $dataTower = DB::table('residential')
                    ->join('tower', 'residential.id', '=', 'tower.idResidential')
                    ->select('residential.nTowers', 'tower.id as idTower')
                    ->where('residential.idUser', $idUser)
                    ->orderBy('residential.id')
                    ->first();
            }


            return $this->sendResponse('positive', 'Datos de torres', 100, $dataTower);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function getIdResidential(int $idUser)
    {
        try {
            $dataUser = DB::table('residential')
                ->select('id')
                ->where('idUser', $idUser)
                ->first();

            return $this->sendResponse('positive', 'Datos de torres', 100, $dataUser);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function getConfigPay(int $idUser)
    {
        try {
            $dataUser = DB::table('residential')
                ->join('configPay', 'residential.id', '=', 'configPay.idResidential')
                ->select(
                    'configPay.id',
                    'configPay.payDay',
                )
                ->where('residential.idUser', $idUser)
                ->first();

            return $this->sendResponse('positive', 'Datos de torres', 100, $dataUser);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Obtienes las torres y apartamentos segun idResidential
    public function getTowerApartmentByIdResdential(int $idResidential)
    {
        try {
            $dataTower = DB::table('tower')
                ->select(
                    'id',
                    'name',
                    'nApartments',
                )
                ->orderBy('id')
                ->where('idResidential', $idResidential)->first();

            $dataTower->apartment = DB::table('residential')
                ->join('tower', 'residential.id', '=', 'tower.idResidential')
                ->join('apartment', 'tower.id', '=', 'apartment.idTower')
                ->select(
                    'apartment.id',
                    'apartment.idTower',
                    'apartment.idUser',
                    'apartment.name',
                    'apartment.aliquot',
                    'apartment.apartment',
                    'apartment.floor',
                )
                ->orderBy('apartment.id')
                ->where('residential.id', $idResidential)->get();


            return $this->sendResponse('positive', 'Datos de torres', 100, $dataTower);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function getBanksDataResidence(int $idResidential)
    {
        try {
            $dataResidence = DB::table('residential')
                ->join('bankResidential', 'residential.id', '=', 'bankResidential.idResidential')
                ->join('phone', 'residential.id', '=', 'phone.idEntity')
                ->join('entitySubClass', 'bankResidential.idBank', '=', 'entitySubClass.id')
                ->join('entitySubClass as entitySubClass2', 'bankResidential.idTypeAccount', '=', 'entitySubClass2.id')
                ->join('entitySubClass as entitySubClass3', 'bankResidential.idTypeRif', '=', 'entitySubClass3.id')
                ->join('entitySubClass as entitySubClass4', 'phone.idAreaCode', '=', 'entitySubClass4.id')
                ->select(
                    'entitySubClass.description as bank',
                    'entitySubClass2.description as typeAccount',
                    'entitySubClass3.code as typeRif',
                    'entitySubClass4.description as typePhone',
                    'phone.number',
                    'bankResidential.rif',
                    'bankResidential.bankAccount',
                )
                ->where('residential.id', $idResidential)
                //Tipo de entidad Residencia
                ->where('phone.idTypeEntity', 131)
                //Para indicar que es telefono CELULAR
                ->where('phone.idTypePhone', 74)
                ->first();

            return $this->sendResponse('positive', 'Datos de torres', 100, $dataResidence);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
}