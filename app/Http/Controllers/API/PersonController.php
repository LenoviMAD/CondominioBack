<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Apartment;
use Illuminate\Support\Arr;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Models\AuthGenerate;
use App\Models\User;
use App\Models\Person;
use App\Models\Phone;
use App\Models\Identity;
use App\Models\Owner;

class PersonController extends BaseController
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'name' => 'required',
                'surname' => 'required',
                'birthday' => 'required',
                'password' => 'required',
                'cpassword' => 'required|same:password',
                'phones' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }

            //Asignamos a una variable el valor del json
            $input = $request->all();

            //Encripta la contrasena
            $input['password'] = bcrypt($input['password']);

            //Guardamos en la tabla user
            $dataUser = User::where('email', '=', $input['email'])->first();;
            $dataUser->password = $input['password'];
            $dataUser->save();


            $input = Arr::add($input, 'idUser', $dataUser->id);
            //Guardamos en la tabla person
            Person::create($input);

            //Guardamos en la tabla Identity
            Identity::create($input);

            //Guardamos en la tabla Phone
            Phone::create($input);

            $dataAuth = AuthGenerate::where('email', '=', $input['email'])->first();
            $dataAuth->delete();

            DB::commit();
            return $this->sendResponse('positive', 'Clave generada', 100, $dataUser);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Muestra la informacion de phone, person, address del usuario por id
    public function showId(string $email)
    {
        try {
            $dataUser = DB::table('users')->where('email', $email)->select('id', 'idRoles')->first();

            $dataPerson = Person::findOrFail($dataUser->id);
            $dataIdentity = Identity::findOrFail($dataUser->id);
            $dataPhone = Phone::findOrFail($dataUser->id);

            $result = array_merge($dataPerson->toArray(), $dataIdentity->toArray(), $dataPhone->toArray());
            return json_encode($result);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Person', 400, $th->getMessage());
        }
    }


    //Metodo para guardar los datos del perfil se usuario en las tablas, person, identityy y phone
    public function savePerfil(Request $request)
    {
        DB::beginTransaction();
        try {

            $idEntityClassTE =  EntityClass::where('description', '=', 'Tipo de Entidades')->first();
            $idTypeEntityUser =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTE->id)->where('description', '=', 'Usuario')->first();
            $idTypeEntityResidence =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTE->id)->where('description', '=', 'Residencia')->first();

            $idEntityClassTI =  EntityClass::where('description', '=', 'Tipo de Identidad')->first();
            $idTypeIdentityCedula =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTI->id)->where('description', '=', 'Cédula')->first();
            $idTypeIdentityRif =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTI->id)->where('description', '=', 'Rif')->first();

            //Validamos los campos requeridos

            $validator = Validator::make($request->all(), [
                'idUser' => 'required',
                'idApartment' => 'required',
                'name' => 'required',
                'surname' => 'required',
                'ci' => 'required',
                'birthday' => 'required',
                'phones' => 'required',
                'documentProperty' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }

            //Asignamos a una variable el valor del json
            $input = $request->all();


            $dataPerson = Person::where('idUser', '=', $input['idUser'])->first();

            if ($dataPerson) {
                $dataPerson->name = $input['name'];
                $dataPerson->surname = $input['surname'];
                $dataPerson->secondName = $input['secondName'];
                $dataPerson->secondSurname = $input['secondSurname'];
                $dataPerson->save();
            } else {
                //Guardamos en la tabla person
                Person::create($input);
            }

            //Guardamos en la tabla Identity
            $dataIdentity = Identity::where('idEntity', '=', $input['idUser'])->where('idTypeIdentity', '=', $idTypeIdentityCedula->id)->where('idTypeEntity', '=', $idTypeEntityUser->id)->first();

            if ($dataIdentity) {
                $dataIdentity->idTypeDocument = $input['idTypeCi'];
                $dataIdentity->number = $input['ci'];
                $dataIdentity->save();
            } else {
                //Guardamos en la tabla Identity
                $dataIdentity = [];
                $dataIdentity['idTypeEntity'] = $input['idTypeEntity'];
                $dataIdentity['idEntity'] = $input['idUser'];
                $dataIdentity['idTypeIdentity'] = $idTypeIdentityCedula->id;
                $dataIdentity['idTypeDocument'] = $input['idTypeCi'];
                $dataIdentity['number'] = $input['ci'];
                Identity::create($dataIdentity);
            }

            //Guardamos en la tabla Owner
            if ($input['documentProperty']) {
                $fileUpload = new Owner;
                $file = $request->file('documentProperty');

                $file_name = time() . '_' . $file->getClientOriginalName();
                $file_path = $request->file('documentProperty')->storeAs('uploads/propertyDocument', $file_name, 'public');

                $fileUpload->idUser = $input['idUser'];
                $fileUpload->idApartment = $request->idApartment;
                $fileUpload->credentials = true;
                $fileUpload->changePassword = true;
                $fileUpload->document = `/storage/` . $file_path;
                if (!Owner::where('idUser', '=', $input['idUser'])->first()) {
                    Owner::create($fileUpload->toArray());
                } else {
                    $fileUpload->save();
                }
            }
            $dataOwner = Owner::where('idUser', '=', $input['idUser'])->first();
            if ($dataOwner) {;
                $dataOwner->document = $input['documentProperty'];
                $dataOwner->save();
            } else {
                //Guardamos en la tabla Identity
                $dataOwner = [];
                $dataOwner['document'] = $input['documentProperty'];
                Owner::create($dataOwner);
            }

            // $dataPhone = Phone::where('idUser', '=', $input['idUser'])->first();
            // if ($dataPhone) {
            //     $dataPhone->phone = $input['phone'];
            //     $dataPhone->localphone = $input['localphone'];
            //     $dataPhone->save();
            // } else {
            //     //Guardamos en la tabla Phone
            //     Phone::create($input);
            // }
            $dataPhone = Phone::where('idEntity', '=', $input['idUser'])->where('idTypeEntity', '=', $idTypeEntityUser->id)->first();
            $arrayPhone = json_decode($input['phones'], true);
            if ($dataPhone) {
                //Guardamos en la tabla Phone
                foreach ($arrayPhone as $item) {
                    $dataPhone = Phone::where('idEntity', '=', $input['idUser'])->where('idTypePhone', '=', $item['idTypePhone'])->where('idTypeEntity', '=', $idTypeEntityUser->id)->first();
                    $dataPhone->number = $item['number'];
                    $dataPhone->save();
                }
            } else {
                //Guardamos en la tabla Phone
                foreach ($arrayPhone as $item) {
                    $dataPhone = [];
                    $dataPhone['idTypeEntity'] = $input['idTypeEntity'];
                    $dataPhone['idEntity'] = $input['idUser'];
                    $dataPhone['idTypePhone'] = $item['idTypePhone'];
                    $dataPhone['idAreaCode'] = $item['idAreaCode'];
                    $dataPhone['number'] = $item['number'];
                    Phone::create($dataPhone);
                }
            }

            DB::commit();
            return $this->sendResponse('positive', 'Perfil guardado correctamente', 100, $input);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
}