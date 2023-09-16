<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use App\Mail\AuthGenerateMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\User;
use App\Models\Phone;
use App\Models\Person;
use App\Models\Owner;
use App\Models\Tower;
use App\Models\Identity;
use App\Models\Address;
use App\Models\Residential;
use App\Models\AuthGenerate;
use App\Models\Apartment;
use App\Models\Admin;
use App\Models\AddressResidential;
use App\Models\BankResidential;
use App\Models\EntityClass;
use App\Models\EntitySubClass;
use App\Models\PhoneResidential;
use App\Models\LogoResidential;
use App\Models\IdentityResidential;

class AuthController extends BaseController
{

    //Logear
    public function signin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // $authUser = Auth::user();

            $authUser = DB::table('user')
                // ->join('person', 'user.id', '=', 'person.idUser')
                ->join('entitySubClass', 'user.status', '=', 'entitySubClass.id')
                ->select(
                    'user.id',
                    'user.idRole',
                    'entitySubClass.description as status',
                )
                ->where('user.email', $request->email)
                ->first();



            $firstStatus = AuthGenerate::where('email', '=', $request->email)->count();


            // $success['id'] = $authUser->id;
            $authUser->first = $firstStatus;
            // $success['role'] = $authUser->idRole;
            // $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            // $success['status'] =  $authUser->status;


            $adminCount = DB::table('admin')
                // ->join('person', 'admin.id', '=', 'person.idadmin')
                ->select()
                ->where('admin.idUser', $authUser->id)
                ->count();

            $residentialUser = [];
            if ($authUser->idRole == "4") {
                $residentialUser = DB::table('apartment')
                    ->join('tower', 'tower.id', '=', 'apartment.idTower')
                    ->join('residential', 'residential.id', '=', 'tower.idResidential')
                    ->select(
                        'residential.id as idResidential',
                        'tower.id as idTower',
                        'residential.name as nameResidential',
                        'tower.name as nameTower',
                        'apartment.id as idApartment',
                        'apartment.name as nameApartment',
                        'apartment.floor',
                        'apartment.intercom',
                        'apartment.parking',
                        'apartment.aliquot',
                    )
                    ->where('apartment.idUser', $authUser->id)
                    ->get();
            } else if ($authUser->idRole == "2") {
                $residentialUser = DB::table('residential')
                    ->select(
                        'residential.id as idResidential',
                        'residential.name as nameResidential',
                    )
                    ->where('residential.idUser', $authUser->id)
                    ->get();
            }
            $towerCount = DB::table('residential')
                ->select()
                ->where('residential.idUser', $authUser->id)
                ->count();

            $configPay = DB::table('residential')
                ->join('configPay', 'residential.id', '=', 'configPay.idResidential')
                ->select()
                ->where('residential.idUser', $authUser->id)
                ->count();

            $authUser->adminCount = $adminCount;
            $authUser->towerCount = $towerCount;
            $authUser->configPay = $configPay;
            $authUser->residential = $residentialUser;

            //Validar cuando sea administrador cuantos condominios tiene, si 0, 1 y >1
            if ($authUser->status == 'Activo') {
                return $this->sendResponse('positive', 'Bienvenido', 100, $authUser);
            } else {
                return $this->sendResponse('warning', 'El email esta inactivo', 200, []);
            }
        } else {
            return $this->sendResponse('negative', 'El email o contraseña es incorrecto', 401, []);
        }
    }

    //Registrar
    public function signup(Request $request)
    {
        try {
            DB::beginTransaction();

            $idEntityClassTE =  EntityClass::where('description', '=', 'Tipo de Entidades')->first();
            $idTypeEntityUser =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTE->id)->where('description', '=', 'Usuario')->first();
            $idTypeEntityResidence =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTE->id)->where('description', '=', 'Residencia')->first();

            $idEntityClassTI =  EntityClass::where('description', '=', 'Tipo de Identidad')->first();
            $idTypeIdentityRif =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTI->id)->where('description', '=', 'Rif')->first();

            $validator = Validator::make($request->all(), [
                'idUser' => 'required',
                'idRole' => 'required',
                'name' => 'required',
                'surname' => 'required',
                'idTypeDocumentAdmin' => 'required',
                'ciAdmin' => 'required',
                'address' => 'required',
                'phones' => 'required',
                'idTypeRifResidential' => 'required',
                'rifResidential' => 'required',
                'addressResidential' => 'required',
                'phonesResidential' => 'required',
                'email' => 'required',
                'nTowers' => 'required',
                'residentialName' => 'required',
                'typeAdmin' => 'required',
                //bancos
                'idBank' => 'required',
                'idTypeAccount' => 'required',
                'bankAccount' => 'required',
                'idTypeRifBank' => 'required',
                'rifBank' => 'required',
            ]);

            //Asignamos a una variable el valor del json
            $input = $request->all();

            //Se valida si el json viene con parametro idRole
            $exists = Arr::exists($input, 'idRole');
            if (!$exists) {
                $input = Arr::add($input, 'idRole', '4');
            }

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }


            //Guardamos en la tabla person
            $dataPerson = Person::where('idUser', '=', $input['idUser'])->first();
            $dataPerson->name = $input['name'];
            $dataPerson->surname = $input['surname'];
            $dataPerson->secondName = $input['secondName'];
            $dataPerson->secondSurname = $input['secondSurname'];
            $dataPerson->save();

            //Guardamos en la tabla person
            $admin = [];
            $admin['idUser'] = $input['idUser'];
            $admin['idTypeAdmin'] = $input['typeAdmin'];
            Admin::create($admin);

            //Guardamos en la tabla address
            $address = [];
            $address['idTypeEntity'] = $idTypeEntityUser->id;
            $address['idEntity'] = $input['idUser'];
            $address['description'] = $input['address'];
            Address::create($address);

            //Guardamos en la tabla Phone
            $arrayPhone = json_decode($input['phones'], true);
            foreach ($arrayPhone as $item) {
                $dataPhone = Phone::where('idEntity', '=', $input['idUser'])->where('idTypePhone', '=', $item['idTypePhone'])->first();
                $dataPhone->idTypeEntity = $idTypeEntityUser->id;
                $dataPhone->idEntity = $input['idUser'];
                $dataPhone->number = $item['number'];
                $dataPhone->save();
            }
            // return $this->sendResponse('warning', 'Error de validación', 200, $input);

            //78 es cedula 79 rif
            //Guardamos en la tabla Identity
            $dataIdentity = Identity::where('idEntity', '=', $input['idUser'])->where('idTypeIdentity', '=', '78')->first();
            $dataIdentity->idEntity = $input['idUser'];
            $dataIdentity->idTypeDocument = $input['idTypeDocumentAdmin'];
            $dataIdentity->number = $input['ciAdmin'];
            $dataIdentity->save();


            //Guardamos en la tabla Residential
            $residential = [];
            $residential['idUser'] = $input['idUser'];
            $residential['name'] = $input['residentialName'];
            $residential['nTowers'] = $input['nTowers'];
            $residential['email'] = $input['email'];
            $residential = Residential::create($residential);

            //Guardamos en la tabla bankResidential
            $bankResidential = [];
            $bankResidential['idResidential'] = $residential->id;
            $bankResidential['idBank'] = $input['idBank'];
            $bankResidential['idTypeAccount'] = $input['idTypeAccount'];
            $bankResidential['bankAccount'] = $input['bankAccount'];
            $bankResidential['idTypeRif'] = $input['idTypeRifBank'];
            $bankResidential['rif'] = $input['rifBank'];
            // return $this->sendResponse('warning', 'Error de validación', 200, $bankResidential);
            // $bankResidential['holder'] = $input['holder'];
            // $bankResidential['ciHolder'] = $input['ciHolder'];
            BankResidential::create($bankResidential);

            //logo
            if ($input['logo']) {
                $fileUpload = new LogoResidential;
                $file = $request->file('logo');

                $file_name = time() . '_' . $file->getClientOriginalName();
                $file_path = $request->file('logo')->storeAs('uploads/logo', $file_name, 'public');

                $fileUpload->idResidential = $residential->id;
                $fileUpload->logo = `/storage/` . $file_path;
                if (!LogoResidential::where('idResidential', '=', $residential->id)->first()) {
                    LogoResidential::create($fileUpload->toArray());
                } else {
                    $searchLogo = LogoResidential::where('idResidential', '=', $residential->id)->first();
                    $searchLogo->logo = $fileUpload->logo;
                    $searchLogo->save();
                }
            }


            //Telefonos Residencia
            $arrayPhonesResidential = json_decode($input['phonesResidential'], true);
            foreach ($arrayPhonesResidential as $item) {
                $dataPhone = [];
                $dataPhone['idTypeEntity']  = $idTypeEntityResidence->id;
                $dataPhone['idEntity'] = $residential->id;
                $dataPhone['idTypePhone'] = $item['idTypePhone'];
                $dataPhone['idAreaCode'] = $item['idAreaCode'];
                $dataPhone['number'] = $item['number'];
                Phone::create($dataPhone);
            }

            //Identidad de la residencia
            $dataIdentity = [];
            $dataIdentity['idEntity'] = $residential->id;
            $dataIdentity['idTypeEntity'] = $idTypeEntityResidence->id;
            $dataIdentity['idTypeIdentity'] = $idTypeIdentityRif->id;
            $dataIdentity['idTypeDocument'] = $input['idTypeRifResidential'];
            $dataIdentity['number'] = $input['rifResidential'];
            Identity::create($dataIdentity);

            //Guardamos en la tabla address
            $addressResidential = [];
            $addressResidential['idEntity'] = $residential->id;
            $addressResidential['idTypeEntity'] = $idTypeEntityResidence->id;
            $addressResidential['description'] = $input['addressResidential'];
            Address::create($addressResidential);
            $success['id'] = $residential->id;
            DB::commit();
            return $this->sendResponse('positive', 'Usuario creado satisfactoriamente.', 100, $success);
        } catch (\Throwable $th) {

            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
                'cpassword' => 'required|same:password',

            ]);

            //Asignamos a una variable el valor del json
            $input = $request->all();

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }

            //agregamos los datos para añadir a la tabla user
            $dataUser = User::where('email', '=', $input['email'])->first();
            $dataUser->password = bcrypt($input['password']);
            $dataUser->save();
            if (AuthGenerate::where('email', '=', $input['email'])->count() > 0) {
                $dataAuth = AuthGenerate::where('email', '=', $input['email'])->first();
                $dataAuth->delete();
            }

            if ($dataUser->idRole == "4") {
                $dataOwner = Owner::where('idUser', '=', $dataUser->id)->first();
                $dataOwner->changePassword = true;
                $dataOwner->credentials = true;
                $dataOwner->save();
            }


            DB::commit();
            return $this->sendResponse('positive', 'Cambio de contraseña existosa', 100, $dataUser);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function getUser(int $id)
    {
        try {

            $users = DB::table('user')
                ->join('person', 'user.id', '=', 'person.idUser')
                ->join('identity', 'user.id', '=', 'identity.idEntity')
                ->join('entitySubClass', 'user.status', '=', 'entitySubClass.id')
                ->select(
                    'user.email',
                    'person.name',
                    'person.secondName',
                    'person.surname',
                    'person.secondSurname',
                    'person.birthday',
                    'identity.idTypeIdentity',
                    'identity.idTypeDocument',
                    'identity.number as ci',
                )
                ->where('user.id', $id)
                ->where('identity.idTypeEntity', 130)
                ->where('user.status', 53)
                ->first();

            $users->phones = DB::table('phone')
                ->join('user', 'phone.idEntity', '=', 'user.id')
                ->select(
                    'phone.id',
                    'phone.idTypePhone',
                    'phone.idAreaCode',
                    'phone.number',
                )
                ->where('user.id', $id)
                ->where('user.status', 53)
                ->where('phone.idTypeEntity', 130)
                ->get();

            return $this->sendResponse('positive', 'Usuario', 100, $users);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Usuario', 400, $th->getMessage());
        }
    }

    public function deleteUser(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $dataUser = User::where('id', '=', $input['id'])->first();
            $dataUser->status = 54;
            $dataUser->save();


            $success = DB::table('user')
                ->join('entitySubClass', 'user.status', '=', 'entitySubClass.id')
                ->select(
                    'user.id',
                    'entitySubClass.description as status'
                )
                ->where('user.id', $input['id'])
                ->first();

            DB::commit();
            return $this->sendResponse('positive', 'Eliminado correctamente', 100, $success);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Eliminación de usuario', 400, $th->getMessage());
        }
    }

    //Registrar
    public function registerUserTower(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $validator = Validator::make($request->all(), [
                'apartments' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }

            foreach ($input['apartments'] as &$item) {
                foreach ($item['apartments'] as &$item2) {

                    $validator3 = Validator::make($item2, [
                        'email' => 'required',
                    ]);

                    if (!$validator3->fails()) {
                        $userExist = User::where('email', $item2['email'])->first();
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

                            //Creacion de usuario en la tabla user

                            $password = bcrypt($pin);

                            // $data = Arr::add($data, 'password', $pin);
                            // $data = Arr::add($data, 'email', $pin);

                            //agregamos los datos para añadir a la tabla user
                            $item2 = Arr::add($item2, 'idTower', $item['idTower']);
                            $item2 = Arr::add($item2, 'idResidential', $item['idResidential']);
                            $item2 = Arr::add($item2, 'idRole', '4');
                            $item2 = Arr::add($item2, 'password', $password);
                            $item2 = Arr::add($item2, 'passwordCredential', $pin);
                            $item2 = Arr::add($item2, 'cpassword', $password);
                            $item2 = Arr::add($item2, 'status', 53);
                            $item2 = Arr::add($item2, 'idApartment', $item2['id']);

                            $user = User::create($item2);
                            $item2 = Arr::add($item2, 'idUser', $user['id']);
                            $item2['credentials'] = true;
                            $item2['changePassword'] = false;
                            $authCreate = AuthGenerate::create($item2);


                            //actualizamos la tabla apartments con el idUser creado
                            $apartment = Apartment::where('id', '=', $item2['id'])->first();
                            $apartment->idUser = $item2['idUser'];
                            $apartment->save();

                            //Creamos los propietarios en la tabla Owner
                            $owner = [];
                            $owner['idUser'] = $item2['idUser'];
                            $owner['idApartment'] = $apartment->id;
                            $owner['credentials'] = true;
                            $owner['changePassword'] = false;
                            $ownerCreate = Owner::create($owner);

                            unset($item2['idTower']);
                            unset($item2['idResidential']);
                            unset($item2['idRole']);
                            // unset($item2['password']);
                            // unset($item2['cpassword']);
                            unset($item2['status']);


                            $mailable = new AuthGenerateMail($item2['email'], $pin);
                            Mail::to($item2['email'])->send($mailable);
                        } else {
                            $item2 = Arr::add($item2, 'idTower', $item['idTower']);
                            $item2 = Arr::add($item2, 'idResidential', $item['idResidential']);
                        }
                    }
                }
            }

            DB::commit();
            return $this->sendResponse('positive', 'Usuario(s) creado(s) satisfactoriamente.', 100, $input['apartments']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
}