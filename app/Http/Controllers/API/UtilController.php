<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Mail\AuthGenerateMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PlanInvoice;
use App\Models\Person;
use App\Models\Phone;
use App\Models\Identity;
use App\Models\AuthGenerate;
use App\Models\EntitySubClass;
use App\Models\MCountry;
use App\Models\MState;
use App\Models\MCity;
use App\Models\MParish;
use App\Models\MPhoneCodeArea;
use App\Models\Receipt;
use App\Models\Role;
//Para las api's Externas

use GuzzleHttp;

class UtilController extends BaseController
{
    public function generateAuth(Request $request)
    {

        try {
            DB::beginTransaction();
            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'idPlan' => 'required',
                'paymentDate' => 'required',
                'amount' => 'required',
                'idTime' => 'required',
                'idBank' => 'required',
                'referenceNumber' => 'required',
                'name' => 'required',
                'surname' => 'required',
                'phones' => 'required',
                'idTypeCI' => 'required',
                'cedula' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }
            $userExist = User::where('email', $request->email)->first();
            $input = $request->all();
            if (!$userExist) {

                //Primero se crea el usuario
                // Available alpha caracters
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                // generate a pin based on 2 * 7 digits + a random character
                $pin = mt_Rand(1000000, 9999999)
                    . mt_Rand(1000000, 9999999)
                    . $characters[Rand(0, strlen($characters) - 1)];

                // shuffle the result
                $string = str_shuffle($pin);

                $pin = $string;

                //Creacion de usuario en la tabal user

                $password = bcrypt($pin);

                // $data = Arr::add($data, 'password', $pin);
                // $data = Arr::add($data, 'email', $pin);

                //agregamos los datos para añadir a la tabla user
                $idRoleAdmin =  Role::where('description', '=', 'Administrador')->first();

                $idStatus =  EntityClass::where('description', '=', 'Estatus Usuarios')->first();
                $idStatusActive =  EntitySubClass::where('idEntityClass', '=', $idStatus->id)->where('description', '=', 'Activo')->first();

                $idEntityClassTE =  EntityClass::where('description', '=', 'Tipo de Entidades')->first();
                $idTypeEntityUser =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTE->id)->where('description', '=', 'Usuario')->first();

                $input = Arr::add($input, 'idRole', $idRoleAdmin->id);
                $input = Arr::add($input, 'password', $password);
                $input = Arr::add($input, 'cpassword', $password);
                $input = Arr::add($input, 'status', $idStatusActive->id);

                if (!$input['pathArchive']) {
                    Arr::forget($input, 'pathArchive');
                }



                $user = User::create($input);
                $input = Arr::add($input, 'idTypeEntity', $idTypeEntityUser->id);
                $input = Arr::add($input, 'idEntity', $user['id']);
                $input = Arr::add($input, 'idUser', $user['id']);

                $authCreate = AuthGenerate::create($input);

                //Indicator tendra 2 valores 1 para transferencia en Bs y 2 para Zelle
                if ($input['indicator'] == "1") {

                    $planInvoice = PlanInvoice::create($input);
                } else {
                    return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
                }
                $input = Arr::add($input, 'idPlanInvoice', $planInvoice['id']);
                //Guardamos en la tabla Person
                Person::create($input);

                //Guardamos en la tabla Phone

                foreach ($input['phones'] as $item) {
                    $dataPhone = [];
                    $dataPhone['idTypeEntity'] = $input['idTypeEntity'];
                    $dataPhone['idEntity'] = $input['idEntity'];
                    $dataPhone['idTypePhone'] = $item['idTypePhone'];
                    $dataPhone['idAreaCode'] = $item['idAreaCode'];
                    $dataPhone['number'] = $item['number'];
                    Phone::create($dataPhone);
                }

                //Guardamos en la tabla Identity
                $idEntityClassTI =  EntityClass::where('description', '=', 'Tipo de Identidad')->first();
                $idTypeIdentityCedula =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTI->id)->where('description', '=', 'Cédula')->first();
                $dataIdentity = [];
                $dataIdentity['idTypeEntity'] = $input['idTypeEntity'];
                $dataIdentity['idEntity'] = $input['idEntity'];
                $dataIdentity['idTypeIdentity'] = $idTypeIdentityCedula->id;
                $dataIdentity['idTypeDocument'] = $input['idTypeCI'];
                $dataIdentity['number'] = $input['cedula'];
                Identity::create($dataIdentity);

                $mailable = new AuthGenerateMail($request->email, $pin);
                Mail::to($request->email)->send($mailable);
                DB::commit();
                return $this->sendResponse('positive', 'Se ha enviado a su correo, el usuario y contraseña para iniciar sesión', 100, $pin);
            } else {
                $input = Arr::add($input, 'idUser', $userExist['id']);

                //Indicator tendra 2 valores 1 para transferencia en Bs y 2 para Zelle
                if ($input['indicator'] == "1" && $input['idTime'] == "") {
                    $planInvoice = PlanInvoice::create($input);
                } else {
                    return $this->sendResponse('negative', 'Error', 401, 'Usuario existente');
                }

                $input = Arr::add($input, 'idPlanInvoice', $planInvoice['id']);
                //Guardamos en la tabla Person
                $dataPerson = Person::where('idUser', '=', $input['idUser'])->first();
                $dataPerson->name = $input['name'];
                $dataPerson->surname = $input['surname'];
                $dataPerson->secondName = $input['secondName'];
                $dataPerson->secondSurname = $input['secondSurname'];
                $dataPerson->save();

                //Guardamos en la tabla Phone
                foreach ($input['phones'] as $item) {
                    $dataPhone = Phone::where('idEntity', '=', $input['idEntity'])->where('idTypeEntity', '=', $input['idTypeEntity'])->where('idTypePhone', '=', $item['idTypePhone'])->first();
                    $dataPhone->number = $item['phone'];
                    $dataPhone->save();
                }
                //Guardamos en la tabla Phone
                //  $dataPhone = Phone::where('idUser', '=', $input['idUser'])->first();
                //  $dataPhone->phone = $input['phone'];
                //  $dataPhone->localphone = $input['localphone'];
                //  $dataPhone->save();

                //Guardamos en la tabla Identity
                $dataIdentity = Identity::where('idEntity', '=', $input['idEntity'])->where('idTypeEntity', '=', $input['idTypeEntity'])->first();
                $dataIdentity->number = $input['cedula'];
                $dataIdentity->save();


                $mailable = new AuthGenerateMail($request->email, $pin);
                Mail::to($request->email)->send($mailable);
                DB::commit();
                return $this->sendResponse('positive', 'Se han enviado los datos de su usuario al correo', 100, $pin);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
            DB::rollBack();
        }
    }

    public function forgotPassword(Request $request)
    {
        if ($request->email != null) {
            try {
                DB::beginTransaction();
                // Available alpha caracters
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                // generate a pin based on 2 * 7 digits + a random character
                $pin = mt_Rand(1000000, 9999999)
                    . mt_Rand(1000000, 9999999)
                    . $characters[Rand(0, strlen($characters) - 1)];

                // shuffle the result
                $string = str_shuffle($pin);

                $pin = $string;

                $mailable = new AuthGenerateMail($request->email, $pin);

                Mail::to($request->email)->send($mailable);



                //Creacion de usuario en la tabal user
                $password = bcrypt($pin);

                //Asignamos a una variable el valor del json
                $input = $request->all();
                $input = Arr::add($input, 'password', $password);

                //agregamos los datos para añadir a la tabla user
                $dataUser = User::where('email', '=', $input['email'])->first();
                $dataUser->password = $password;
                $dataUser->save();

                $authCreate = AuthGenerate::create($input);

                DB::commit();
                return $this->sendResponse('positive', 'Se han enviado los datos de su usuario al correo', 100, $pin);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
            }
        } else {
            return $this->sendResponse('negative', 'El email es incorrecto', 401, []);
        }
    }

    //Devuelve los tipo de documentos
    public function getTypeDocument()
    {
        try {

            $typeDocument = DB::table('entitySubClass')->where('idEntityClass', 12)->select('id', 'description')->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $typeDocument);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los bancos
    public function getBanks()
    {
        try {

            $banks = DB::table('entitySubClass')->where('idEntityClass', 1)->select('id', 'description')->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $banks);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los planes segun su plan principal
    public function getPlans()
    {
        try {

            $plan = DB::table('plan')->select('id', 'name', 'cost', 'user', 'profile', 'email', 'billboard')->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $plan);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los planes segun su plan principal
    public function getTimePlan()
    {
        try {

            $timePlan = DB::table('entitySubClass')->where('idEntityClass', 13)->select('id', 'description', 'code')->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $timePlan);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
    //Devuelve los paises
    public function getCountry()
    {
        try {

            $country = MCountry::all();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $country);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los paises por ID
    public function getCountryById(int $id)
    {
        try {

            $country = MCountry::where('id', $id);

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $country);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los estados por IDCountry
    public function getStateById(int $id)
    {
        try {

            $state = MState::where('idCountry', $id);

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $state);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
    //Devuelve las ciudades por IDState
    public function getCityByIdState(int $id)
    {
        try {

            $city = MCity::where('idState', $id);

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $city);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve las ciudades por IDCountry
    public function getCityByIdCountry(int $id)
    {
        try {

            $city = MCity::where('idCountry', $id);

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $city);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve las parroquias por IDCity
    public function getParishByIdCity(int $id)
    {
        try {

            $city = MParish::where('idCity', $id);

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $city);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los codigos de area por IDCity
    public function getPhoneAreaCodeByIdCity(int $id)
    {
        try {

            $city = MPhoneCodeArea::where('idCity', $id);

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $city);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
    //Devuelve los codigos de area
    public function getPhoneAreaCod()
    {
        try {

            $areaCode = DB::table('entitySubClass')->select('id', 'code', 'description')->where('idEntityClass', 19)->get();
            return $this->sendResponse('positive', 'Datos conseguidos', 100, $areaCode);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los tipos de cuenta bancaria
    public function getBankTypeAccount()
    {
        try {

            $areaCode = DB::table('entitySubClass')->select('id', 'code', 'description')->where('idEntityClass', 15)->get();
            return $this->sendResponse('positive', 'Datos conseguidos', 100, $areaCode);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los tipos de Cedula
    public function getCIType()
    {
        try {

            $areaCode = DB::table('entitySubClass')->select('id', 'code', 'description')->where('idEntityClass', 17)->get();
            return $this->sendResponse('positive', 'Datos conseguidos', 100, $areaCode);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los tipos de rif
    public function getRifType()
    {
        try {

            $areaCode = DB::table('entitySubClass')->select('id', 'code', 'description')->where('idEntityClass', 18)->get();
            return $this->sendResponse('positive', 'Datos conseguidos', 100, $areaCode);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los tipos de Métodos de cobro
    public function getChargesMethods()
    {
        try {

            $areaCode = DB::table('entitySubClass')->select('id', 'code', 'description')->where('idEntityClass', 22)->get();
            return $this->sendResponse('positive', 'Datos conseguidos', 100, $areaCode);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los tipos de Métodos de pago
    public function getPaymentMethods()
    {
        try {

            $areaCode = DB::table('entitySubClass')->select('id', 'code', 'description')->where('idEntityClass', 25)->get();
            return $this->sendResponse('positive', 'Datos conseguidos', 100, $areaCode);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve el precio del dolar a tasa BCV
    public function getValueUSD()
    {
        try {
            $client = new GuzzleHttp\Client();

            $url = "https://s3.amazonaws.com/dolartoday/data.json";
            $res = $client->request(
                'GET',
                $url

            );
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $responseBody = json_decode($response->getBody());

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $res);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Obtiene los datos del comprador del plan
    public function getPerfilData(int $idUser)
    {
        try {

            $adminData = DB::table('person')
                ->join('identity', 'person.idUser', '=', 'identity.idEntity')
                ->select(
                    'person.name',
                    'person.surname',
                    'person.secondName',
                    'person.secondSurname',
                    'person.birthday',
                    'identity.idTypeDocument',
                    'identity.number as ci',

                )
                ->where('idUser', $idUser)
                ->where('identity.idTypeEntity', '130')->first();

            $dataPhone = DB::table('phone')
                ->select(
                    'id',
                    'idTypePhone',
                    'idAreaCode',
                    'number',
                )
                ->where('idEntity', $idUser)
                ->where('idTypeEntity', '130')
                ->get();

            $adminData->phones =  $dataPhone;

            $dataAddress = DB::table('address')
                ->select(
                    'id',
                    'description as address',
                )
                ->where('idEntity', $idUser)
                ->where('idTypeEntity', '130')
                ->first();

            $adminData->address =  $dataAddress;
            return $this->sendResponse('positive', 'Datos conseguidos', 100, $adminData);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
}