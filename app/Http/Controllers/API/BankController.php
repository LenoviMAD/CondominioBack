<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use Validator;
use App\Models\User;
use App\Models\Bank;
use App\Models\BankResidence;
use App\Models\BankResidential;
use App\Models\Residentials;

class BankController extends BaseController
{
    public function saveBank(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'idUser' => 'required',
                'bank' => 'required',
            ]);

            //Asignamos a una variable el valor del json
            $input = $request->all();

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }
            $success = [];
            //Guardamos en la tabla bank
            foreach ($input['bank'] as $item) {
                $dataBank->idUser = $input['idUser'];
                $dataBank->idBank = $item['idBank'];
                $dataBank->bankAccount = $item['bankAccount'];
                $bank = bank::create($dataBank);
                array_push($success, $bank);
            }




            DB::commit();
            return $this->sendResponse('positive', 'Banco', 100, $success);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Banco', 400, $th->getMessage());
        }
    }

    public function updateBank(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'idUser' => 'required',
                'bank' => 'required',
            ]);

            //Asignamos a una variable el valor del json
            $input = $request->all();

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }
            $success = [];
            //Guardamos en la tabla bank
            foreach ($input['bank'] as $item) {
                $dataBank->idUser = $input['idUser'];
                $dataBank->idBank = $item['idBank'];
                $dataBank->bankAccount = $item['bankAccount'];
                $dataBank->save();
                array_push($success, $dataBank);
            }

            DB::commit();
            return $this->sendResponse('positive', 'Banco', 100, $success);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Banco', 400, $th->getMessage());
        }
    }

    public function getBankByUser(int $id)
    {
        try {

            $bank = DB::table('bank')
                ->select(
                    'id',
                    'idUser',
                    'idBank',
                    'bankAccount',
                )
                ->orderBy('id')
                ->where('idUser', $id)->get();

            return $this->sendResponse('positive', 'Banco', 100, $bank);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Banco', 400, $th->getMessage());
        }
    }

    public function saveBankResidential(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'idResidential' => 'required',
                'idBank' => 'required',
                'bankAccount' => 'required',
                'holder' => 'required',
                'dni' => 'required',
            ]);

            //Asignamos a una variable el valor del json
            $input = $request->all();

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }
            $success = BankResidential::create($input);



            DB::commit();
            return $this->sendResponse('positive', 'Banco', 100, $success);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Banco', 400, $th->getMessage());
        }
    }

    public function updateBankResidential(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'idResidential' => 'required',
                'idBank' => 'required',
                'bankAccount' => 'required',
                'holder' => 'required',
                'dni' => 'required',
            ]);

            //Asignamos a una variable el valor del json
            $input = $request->all();

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }
            $success = [];
            $bankResidential->idBank = $input['idBank'];
            $bankResidential->bankAccount = $input['bankAccount'];
            $bankResidential->holder = $input['holder'];
            $bankResidential->dni = $input['dni'];
            $bankResidential->save();
            array_push($success, $bankResidential);

            DB::commit();
            return $this->sendResponse('positive', 'Los datos se actualizaron correctamente', 100, $success);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Banco', 400, $th->getMessage());
        }
    }

    public function getBankByResidential(int $id)
    {
        try {

            $bankResidential = DB::table('bankResidential')
                ->select(
                    'id',
                    'idResidential',
                    'idBank',
                    'bankAccount',
                    'holder',
                    'dni',
                )
                ->orderBy('id')
                ->where('idResidential', $id)->first();

            return $this->sendResponse('positive', 'Banco de la residencia', 100, $bankResidential);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Banco', 400, $th->getMessage());
        }
    }
}
