<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigPay;
use App\Models\Defaulter;

class ConfigPayController extends BaseController
{
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'idResidential' => 'required',
                'payDay' => 'required',
                'publishDay' => 'required',
                'delinquencyAllowed' => 'required',
                'indicator' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }
            $input = $request->all();

            //Guardamos en la tabla ConfigPay
            $configPay = [];
            $configPay['idResidential'] = $input['idResidential'];
            $configPay['payDay'] = $input['payDay'];
            $configPay['publishDay'] = $input['publishDay'];
            $configPay['delinquencyAllowed'] = $input['delinquencyAllowed'];
            $respConfigPay = ConfigPay::create($configPay);

            if ($input['indicator'] == 'true') {
                $validator2 = Validator::make($request->all(), [

                    'penaltyPercent' => 'required',
                    'certificate' => 'required',
                ]);

                if ($validator2->fails()) {
                    return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
                }
                $fileUpload = new Defaulter;
                $file = $request->file('certificate');
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file_path = $request->file('certificate')->storeAs('uploads/certificate', $file_name, 'public');

                $fileUpload->idResidential = $request->idResidential;
                $fileUpload->penaltyPercent = $request->penaltyPercent;
                $fileUpload->certificate = `/storage/` . $file_path;

                if (!Defaulter::where('idResidential', '=',  $request->idResidential)->first()) {
                    Defaulter::create($fileUpload);
                } else {
                    $fileUpload->save();
                }
                // Defaulter::create($towerDetail);
            }


            $success['allSave'] = true;
            DB::commit();
            return $this->sendResponse('positive', 'Configuración de pagos guardado correctamente', 100, $success);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
}
