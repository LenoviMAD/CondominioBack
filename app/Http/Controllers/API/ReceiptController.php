<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;
use App\Models\Residential;
use App\Models\Receipt;
use App\Models\ReceiptDetail;
use App\Models\Voucher;
use App\Models\BillDivision;
use App\Models\Identity;
use App\Models\Bank;
use App\Models\Address;
use App\Models\Creditor;
use App\Models\Phone;
use App\Models\PaymentRecord;
use App\Models\ReceiptPriceRecord;
use App\Models\Payment;
use App\Models\ExpenseByApartment;
use App\Models\EntityClass;
use App\Models\EntitySubClass;
use Illuminate\Support\Facades\File;

class ReceiptController extends BaseController
{
    public function saveReceipt(Request $request)
    {
        DB::beginTransaction();
        try {


            $idEntityClassTE =  EntityClass::where('description', '=', 'Tipo de Entidades')->first();
            $idTypeEntityUser =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTE->id)->where('description', '=', 'Usuario')->first();
            $idTypeEntityResidence =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTE->id)->where('description', '=', 'Residencia')->first();

            $idEntityClassTI =  EntityClass::where('description', '=', 'Tipo de Identificacion')->first();
            $idTypeIdentityCedula =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTI->id)->where('description', '=', 'Cédula')->first();
            $idTypeIdentityRif =  EntitySubClass::where('idEntityClass', '=', $idEntityClassTI->id)->where('description', '=', 'Rif')->first();


            $idEntityClassER =  EntityClass::where('description', '=', 'Estado de Recibo')->first();
            $idStatusReceiptBo =  EntitySubClass::where('idEntityClass', '=', $idEntityClassER->id)->where('description', '=', 'Borrador')->first();
            $idStatusReceiptPu =  EntitySubClass::where('idEntityClass', '=', $idEntityClassER->id)->where('description', '=', 'Pendiente por cobrar')->first();

            $input = $request->all();

            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'idResidential' => 'required',
                'nroReceipt' => 'required',
                'date' => 'required',
                'address' => 'required',
                'total' => 'required',
                'totalUSD' => 'required',
                'receiptDetail' => 'required',
                'vouchers' => 'required',
                // 'billDivision' => 'required',
                //'uncommonExpenses' => 'required',


            ]);
            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }


            //Guardamos en la tabla receipt
            $receipt = [];
            $receipt['idResidential'] = $input['idResidential'];
            $receipt['number'] = $input['nroReceipt'];
            $receipt['date'] = $input['date'];
            $receipt['price'] = $input['total'];
            $receipt['priceUsd'] = $input['totalUSD'];
            //El estatus viene desde el front
            if ($input['status'] == 'Publicar') {
                $receipt['status'] = $idStatusReceiptPu->id;
            } else if ($input['status'] == 'Guardar') {
                $receipt['status'] = $idStatusReceiptBo->id;
            }
            $respReceipt = Receipt::create($receipt);


            $receiptPriceRecord = [];
            $receiptPriceRecord['idReceipt'] = $respReceipt->id;
            $receiptPriceRecord['price'] = $input['total'];
            $receiptPriceRecord['priceUsd'] = $input['totalUSD'];
            $respReceipt = ReceiptPriceRecord::create($receiptPriceRecord);



            $allApartment = DB::table('tower')
                ->join('apartment', 'tower.id', '=', 'apartment.idTower')
                ->select(
                    'tower.id as idTower',
                    'apartment.id',
                    'apartment.aliquot',
                )
                ->orderBy('id')
                ->where('tower.idResidential', $input['idResidential'])->get();

            $idStatusReceipt =  EntityClass::where('description', '=', 'Estado de Recibo')->first();
            $idStatusReceiptPending =  EntitySubClass::where('idEntityClass', '=', $idStatusReceipt->id)->where('description', '=', 'Pendiente por pagar')->first();

            foreach (json_decode($allApartment)  as &$value) {
                $value->idApartment = $value->id;
                $value->idReceipt = $respReceipt->id;
                $value->amountPaymentBs = bcdiv((((float)$value->aliquot / 100) * $input['total']), 1, 4);
                $value->amountPaymentUsd = ((float)$value->aliquot / 100) * $input['totalUSD'];
                $value->status = $idStatusReceiptPending->id;
                //payRecord
                $respPaymentRecord = PaymentRecord::create((array)$value);
            }

            /*-----------------------------receiptDetail-----------------------------------*/
            $saveReceiptDetail = [];
            $successReceiptDetail = [];

            $arrayReceiptDetail = json_decode($input['receiptDetail'], true);
            // return $this->sendResponse('warning', 'Error de mensaje', 200, $arrayReceiptDetail);
            foreach ($arrayReceiptDetail as $receiptDetail) {
                $requestReceiptDetail = new Request($receiptDetail);
                //Validamos los campos requeridos
                $validator2 = Validator::make($requestReceiptDetail->all(), [
                    'item' => 'required',
                    'bs' => 'required',
                    'usd' => 'required',
                ]);
                if ($validator2->fails()) {
                }

                $idExpenseType =  EntityClass::where('description', '=', 'Tipo de gastos')->first();

                $idExpenseTypeCommon =  EntitySubClass::where('idEntityClass', '=', $idExpenseType->id)->where('description', '=', 'Gasto común')->first();

                $idExpenseTypeNoCommon =  EntitySubClass::where('idEntityClass', '=', $idExpenseType->id)->where('description', '=', 'Gasto no común')->first();

                $idExpenseTypeByApartment =  EntitySubClass::where('idEntityClass', '=', $idExpenseType->id)->where('description', '=', 'Gasto por apartamento')->first();

                $saveReceiptDetail['idReceipt'] = $respReceipt->id;
                if ($receiptDetail['typeItem'] == "1") {
                    $saveReceiptDetail['idTypeExpense'] = $idExpenseTypeCommon->id;
                } else if ($receiptDetail['typeItem'] == "2") {
                    $saveReceiptDetail['idTypeExpense'] = $idExpenseTypeNoCommon->id;
                } else if ($receiptDetail['typeItem'] == "3") {
                    $saveReceiptDetail['idTypeExpense'] = $idExpenseTypeByApartment->id;
                } else {
                    return $this->sendResponse('warning', 'Tipo de item no válido', 200, $saveReceiptDetail);
                }

                $saveReceiptDetail['item'] = $receiptDetail['item'];
                $saveReceiptDetail['price'] = $receiptDetail['bs'];
                $saveReceiptDetail['priceUsd'] = $receiptDetail['usd'];
                $saveReceiptDetail['favorite'] = true;
                $receiptDetailRest = ReceiptDetail::create($saveReceiptDetail);
                $receiptDetail['idReceiptDetail'] =  $receiptDetailRest->id;

                $saveExpenseByApartment = [];
                if ($receiptDetail['typeItem'] == "3") {

                    $saveExpenseByApartment['idReceiptDetail'] = $receiptDetailRest->id;
                    $saveExpenseByApartment['idApartment'] = $receiptDetail['idApartment'];
                    $expenseByApartment = ExpenseByApartment::create($saveExpenseByApartment);
                }


                array_push($successReceiptDetail, $receiptDetailRest);
            }


            /*-----------------------------Voucher-----------------------------------*/
            $saveVoucher = [];

            $idAcreditorType =  EntityClass::where('description', '=', 'Tipo de Acreedor')->first();
            $idAcreditorTypeEmployed =  EntitySubClass::where('idEntityClass', '=', $idAcreditorType->id)->where('description', '=', 'Empleado')->first();

            $idPhoneType =  EntityClass::where('description', '=', 'Tipo de Teléfono')->first();
            $idPhoneTypeOffice =  EntitySubClass::where('idEntityClass', '=', $idPhoneType->id)->where('description', '=', 'Oficina')->first();


            $arrayVoucher = json_decode($input['vouchers'], true);
            foreach ($arrayVoucher as $vouchers) {
                $requestItem = new Request($vouchers);

                $voucherItem = $vouchers['item'];
                $arrRespReceiptDetail = Arr::first($successReceiptDetail, function ($value, $key) use ($voucherItem) {
                    return $value['item'] == $voucherItem;
                });

                $vouchers['idReceiptDetail']  = $arrRespReceiptDetail['id'];
                $vouchers['idResidential'] = $input['idResidential'];
                $requestVouchers = new Request($vouchers);

                //Validamos los campos requeridos
                $validator3 = Validator::make($requestVouchers->all(), [
                    'idReceiptDetail' => 'required',
                    'idResidential' => 'required',
                    'nameEnterprise' => 'required',
                    'idAreaCode' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'idTypeRif' => 'required',
                    'rif' => 'required',
                    'referenceNumber' => 'required',
                    'dateVoucher' => 'required',
                    'idChargesMethods' => 'required',
                    'item' => 'required',
                    'price' => 'required',
                    'priceUsd' => 'required',
                ]);
                if ($validator3->fails()) {
                    return $this->sendResponse('warning', 'Error de validación', 200, $validator3->errors());
                }
                //Guardamos en la tabla creditor
                $dataCreditor = [];
                $dataCreditor['idTypeCreditor'] = $idAcreditorTypeEmployed->id;
                $dataCreditor['name'] = $vouchers['nameEnterprise'];
                $creditor = Creditor::create($dataCreditor);


                //-------------------------------Creditor------------------------
                //Guardamos en la tabla address
                $addressCreditor = [];
                $addressCreditor['idTypeEntity'] = $idTypeEntityResidence->id;
                $addressCreditor['idEntity'] = $creditor->id;
                $addressCreditor['description'] = $vouchers['address'];
                Address::create($addressCreditor);

                //Guardamos o actualizamos en la tabla Identity
                $dataIdentity = Identity::where('number', '=', $vouchers['rif'])->first();

                if ($dataIdentity) {
                    $dataIdentity->idTypeDocument = $vouchers['idTypeRif'];
                    $dataIdentity->number = $vouchers['rif'];
                    $dataIdentity->save();
                } else {
                    $dataIdentity = [];
                    $dataIdentity['idTypeEntity'] = $idTypeEntityResidence->id;
                    $dataIdentity['idEntity'] = $creditor->id;
                    $dataIdentity['idTypeIdentity'] = $idTypeIdentityRif->id;
                    $dataIdentity['idTypeDocument'] = $vouchers['idTypeRif'];
                    $dataIdentity['number'] = $vouchers['rif'];
                    Identity::create($dataIdentity);
                }

                //Guardamos en la tabla Phone
                $dataPhone = [];
                $dataPhone['idTypeEntity'] = $idTypeEntityResidence->id;
                $dataPhone['idEntity'] = $creditor->id;
                $dataPhone['idTypePhone'] = $idPhoneTypeOffice->id; //Tipo Oficina
                $dataPhone['idAreaCode'] = $vouchers['idAreaCode'];
                $dataPhone['number'] = $vouchers['phone'];
                Phone::create($dataPhone);

                //---------------------------Voucher------------------------------------------
                //Guardamos en la tabla Voucher
                $dataVoucher = [];
                $dataVoucher['idCreditor'] = $creditor->id;
                $dataVoucher['idReceiptDetail'] = $vouchers['idReceiptDetail'];
                $dataVoucher['idTypePayment'] = $vouchers['idChargesMethods'];
                $dataVoucher['reference'] = $vouchers['referenceNumber'];
                $dataVoucher['date'] = $vouchers['dateVoucher'];
                $dataVoucher['description'] = $vouchers['description'];
                $dataVoucher['favorite'] = $vouchers['favorite'];

                $successVoucher = Voucher::create($dataVoucher);
                $vouchers['idVoucher'] =  $successVoucher->id;
                array_push($saveVoucher, $vouchers);
            }

            $respReceipt->voucher = $saveVoucher;

            /*-----------------------------billDivision-----------------------------------*/
            if ($request['billDivision']) {
                $saveBillDivision = [];
                $arrayBillDivision = json_decode($input['billDivision'], true);

                foreach ($arrayBillDivision as $billDivision) {

                    $billDivisionItem = $billDivision->item;
                    $arrRespReceiptDetail = Arr::first($successReceiptDetail, function ($value, $key) use ($billDivisionItem) {
                        return $value['item'] == $billDivisionItem;
                    });

                    $billDivision['idReceiptDetail']  = $arrRespReceiptDetail['id'];
                    $requestBillDivision = new Request($billDivision);
                    //Validamos los campos requeridos
                    $validator4 = Validator::make($requestBillDivision->all(), [
                        'idReceiptDetail' => 'required',
                        // 'installmentPaid' => 'required',
                        'installmentFraction' => 'required',
                        'startDate' => 'required',
                        'endDate' => 'required',
                        'description' => 'required',
                        'amountInstallmentBs' => 'required',
                        'amountInstallmentUsd' => 'required',
                    ]);
                    if ($validator4->fails()) {
                        return $this->sendResponse('warning', 'Error de validación', 200, $validator4->errors());
                    }
                    //---------------------------BillDivision------------------------------------------
                    //Guardamos en la tabla BillDivision
                    $dataBillDivision = [];
                    $dataBillDivision['idReceiptDetail'] = $billDivision['idReceiptDetail'];
                    $dataBillDivision['installmentPaid'] = 1;
                    $dataBillDivision['installmentFraction'] = $billDivision['installmentFraction'];
                    $dataBillDivision['startDate'] = $billDivision['startDate'];
                    $dataBillDivision['endDate'] = $billDivision['endDate'];
                    $dataBillDivision['description'] = $billDivision['description'];
                    $dataBillDivision['amountInstallmentBs'] = $billDivision['amountInstallmentBs'];
                    $dataBillDivision['amountInstallmentUsd'] = $billDivision['amountInstallmentUsd'];
                    $success = BillDivision::create($dataBillDivision);
                    array_push($saveVoucher, $billDivision);
                }
            }

            DB::commit();
            return $this->sendResponse('positive', 'Recibo guardado correctamente', 100, $respReceipt);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    public function saveImageVoucher(Request $request)
    {
        DB::beginTransaction();
        try {

            $input = $request->all();

            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'idVoucher' => 'required',
                'fileImage' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }

            $searchVoucher = Voucher::where('id', '=', $input['idVoucher'])->first();
            $file = $request->file('fileImage');

            $file_name = time() . '_' . $file->getClientOriginalName();
            $file_path = $request->file('fileImage')->storeAs('uploads/voucher', $file_name, 'public');
            $searchVoucher->image  = `/storage/` . $file_path;
            $searchVoucher->save();

            DB::commit();
            return $this->sendResponse('positive', 'Recibo guardado correctamente', 100, $searchVoucher);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve el numero de recibo mas alto
    public function getNumberReceipt()
    {
        try {

            $numberReceipt = DB::table('receipt')->select('number')
                ->orderByDesc('number')->first();


            return $this->sendResponse('positive', 'Datos conseguidos', 100, $numberReceipt);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los datos de los recibos segun residencias
    public function getReceiptByIdResidential(int $idResidential)
    {
        try {

            $receipt = DB::table('receipt')
                ->join('entitySubClass', 'receipt.status', '=', 'entitySubClass.id')
                ->where('idResidential', $idResidential)
                ->select(
                    'receipt.id',
                    'receipt.number',
                    'receipt.date',
                    'receipt.price',
                    'receipt.priceUsd',
                    'entitySubClass.description as status'
                )
                ->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $receipt);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los datos de los recibos a pagar de los clientes
    public function getReceiptByIdUser(int $idUser)
    {
        try {

            $receipt = DB::table('apartment')
                ->join('paymentRecord', 'apartment.id', '=', 'paymentRecord.idApartment')
                ->join('receipt', 'paymentRecord.idReceipt', '=', 'receipt.id')
                ->join('entitySubClass', 'paymentRecord.status', '=', 'entitySubClass.id')
                ->select(
                    'paymentRecord.id',
                    'paymentRecord.amountPaymentBs',
                    'paymentRecord.amountPaymentUsd',
                    'receipt.number',
                    'receipt.date',
                    'entitySubClass.description as status'
                )
                ->where('apartment.idUser', $idUser)
                ->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $receipt);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los datos los deudores
    public function getDefaultersByIdResidential(int $idResidential)
    {
        try {

            $receipt = DB::table('receipt')
                ->join('paymentRecord', 'receipt.id', '=', 'paymentRecord.idReceipt')
                ->join('apartment', 'paymentRecord.idApartment', '=', 'apartment.id')
                ->join('entitySubClass', 'paymentRecord.status', '=', 'entitySubClass.id')
                ->leftJoin('defaulter', 'receipt.idResidential', '=', 'defaulter.idResidential')
                ->select(
                    'paymentRecord.id',
                    'paymentRecord.amountPaymentBs',
                    'paymentRecord.amountPaymentUsd',
                    'apartment.id as idApartment',
                    'apartment.name as apartment',
                    'receipt.number',
                    'receipt.date',
                    'entitySubClass.description as status',
                    'defaulter.penaltyPercent'
                )
                ->where('receipt.idResidential', $idResidential)
                ->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $receipt);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los proovedores favoritos
    public function getFavoriteProvider(int $idResidential)
    {
        try {

            $receipt = DB::table('receipt')
                ->join('paymentRecord', 'receipt.id', '=', 'paymentRecord.idReceipt')
                ->join('apartment', 'paymentRecord.idApartment', '=', 'apartment.id')
                ->join('entitySubClass', 'paymentRecord.status', '=', 'entitySubClass.id')
                ->select(
                    'paymentRecord.id',
                    'paymentRecord.amountPaymentBs',
                    'paymentRecord.amountPaymentUsd',
                    'apartment.name',
                    'receipt.number',
                    'receipt.date',
                    'entitySubClass.description as status'
                )
                ->where('receipt.idResidental', $idResidential)
                ->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $receipt);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Guarda los pagos registrados por el cliente (co-propietarios)
    public function savePayment(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();

            //Validamos los campos requeridos
            $validator = Validator::make($request->all(), [
                'idPaymentRecord' => 'required',
                'idPaymentMethod' => 'required',
                'idBank' => 'required',
                'paymentInstrument' => 'required',
                'titular' => 'required',
                'ci' => 'required',
                'nReference' => 'required',
                'paidDay' => 'required',
                'amountPaidBs' => 'required',
                'amountPaidUsd' => 'required',


            ]);
            if ($validator->fails()) {
                return $this->sendResponse('warning', 'Error de validación', 200, $validator->errors());
            }
            //Actualizamos payment Record
            $paymentRecord = PaymentRecord::where('id', '=', $input['idPaymentRecord'])->first();

            $idStatusPay =  EntityClass::where('description', '=', 'Estado de Recibo')->first();
            $idStatusPayPendingApproval =  EntitySubClass::where('idEntityClass', '=', $idStatusPay->id)->where('description', '=', 'Pendiente por Aprobar')->first();

            if ($paymentRecord) {
                $paymentRecord->amountPaidUserBs = $input['amountPaidBs'];
                $paymentRecord->amountPaidUserUsd = $input['amountPaidUsd'];
                $paymentRecord->datePaid = $input['paidDay'];
                if ($paymentRecord->amountPaymentBs ==  $input['amountPaidBs']) {
                    $paymentRecord->status = $idStatusPayPendingApproval->id;
                }
                $paymentRecord->save();
            }

            //Guardamos en la tabla Payment
            $payment = [];
            $payment['idPaymentRecord'] = $input['idPaymentRecord'];
            $payment['idPaymentMethod'] = $input['idPaymentMethod'];
            $payment['idBank'] = $input['idBank'];
            $payment['paymentInstrument'] = $input['paymentInstrument'];
            $payment['name'] = $input['titular'];
            $payment['ci'] = $input['ci'];
            $payment['referenceNumber'] = $input['nReference'];
            $payment['paidDay'] = $input['paidDay'];
            $payment['amountPaidBs'] = $input['amountPaidBs'];
            $payment['amountPaidUsd'] = $input['amountPaidUsd'];
            $respPayment = Payment::create($payment);

            DB::commit();
            return $this->sendResponse('positive', 'Pago guardado correctamente', 100, $respPayment);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }

    //Devuelve los datos de los recibos a pagar de los clientes
    public function getPaymentByIdApartment(int $idResidential)
    {
        try {

            $dataPayment = DB::table('apartment')
                ->join('paymentRecord', 'apartment.id', '=', 'paymentRecord.idApartment')
                ->join('payment', 'paymentRecord.id', '=', 'payment.idPaymentRecord')
                ->join('entitySubClass', 'paymentRecord.status', '=', 'entitySubClass.id')
                ->join('entitySubClass as entitySubClass2', 'payment.idPaymentMethod', '=', 'entitySubClass2.id')
                ->select(
                    'payment.id',
                    'paymentRecord.amountPaymentBs',
                    'paymentRecord.amountPaymentUsd',
                    'payment.amountPaidBs',
                    'payment.amountPaidUsd',
                    'payment.name',
                    'payment.referenceNumber',
                    'payment.paidDay',
                    'entitySubClass.description as status',
                    'entitySubClass2.description as paymentMethod'
                )
                ->where('apartment.idResidential', $idResidential)
                ->get();

            return $this->sendResponse('positive', 'Datos conseguidos', 100, $dataPayment);
        } catch (\Throwable $th) {
            return $this->sendResponse('negative', 'Error', 401, $th->getMessage());
        }
    }
}