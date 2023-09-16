<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EntitySubClassSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1 Bancos
        //2 Modalidad de pago
        //3 Categorias (Se agregaran manual)
        //4 Presentación
        //5 Moneda
        //6 Iva
        //7 Descuentos
        DB::table('entitySubClass')->insert([

            //Bancos
            //1
            [
                'idEntityClass' => 1,
                'code' => '0156',
                'description' => "100%BANCO",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //2
            [
                'idEntityClass' => 1,
                'code' => '0196',
                'description' => "ABN AMRO BANK",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //3
            [
                'idEntityClass' => 1,
                'code' => '0172',
                'description' => "BANCAMIGA BANCO MICROFINANCIERO, C.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //4
            [
                'idEntityClass' => 1,
                'code' => '0171',
                'description' => "BANCO ACTIVO BANCO COMERCIAL, C.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //5
            [
                'idEntityClass' => 1,
                'code' => '0166',
                'description' => "BANCO AGRICOLA",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //6
            [
                'idEntityClass' => 1,
                'code' => '0175',
                'description' => "BANCO BICENTENARIO",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //7
            [
                'idEntityClass' => 1,
                'code' => '0128',
                'description' => "BANCO CARONI, C.A. BANCO UNIVERSAL",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //8
            [
                'idEntityClass' => 1,
                'code' => '0164',
                'description' => "BANCO DE DESARROLLO DEL MICROEMPRESARIO",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //9
            [
                'idEntityClass' => 1,
                'code' => '0102',
                'description' => "BANCO DE VENEZUELA",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //10
            [
                'idEntityClass' => 1,
                'code' => '0114',
                'description' => "BANCO DEL CARIBE C.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //11
            [
                'idEntityClass' => 1,
                'code' => '0149',
                'description' => "BANCO DEL PUEBLO SOBERANO C.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //12
            [
                'idEntityClass' => 1,
                'code' => '0163',
                'description' => "BANCO DEL TESORO",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //13
            [
                'idEntityClass' => 1,
                'code' => '0176',
                'description' => "BANCO ESPIRITO SANTO, S.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //14
            [
                'idEntityClass' => 1,
                'code' => '0115',
                'description' => "BANCO EXTERIOR C.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //15
            [
                'idEntityClass' => 1,
                'code' => '0003',
                'description' => "BANCO INDUSTRIAL DE VENEZUELA.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //16
            [
                'idEntityClass' => 1,
                'code' => '0173',
                'description' => "BANCO INTERNACIONAL DE DESARROLLO, C.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //17
            [
                'idEntityClass' => 1,
                'code' => '0105',
                'description' => "BANCO MERCANTIL C.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //18
            [
                'idEntityClass' => 1,
                'code' => '0191',
                'description' => "BANCO NACIONAL DE CREDITO",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //19
            [
                'idEntityClass' => 1,
                'code' => '0116',
                'description' => "BANCO OCCIDENTAL DE DESCUENTO.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //20
            [
                'idEntityClass' => 1,
                'code' => '0138',
                'description' => "BANCO PLAZA",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //21
            [
                'idEntityClass' => 1,
                'code' => '0108',
                'description' => "BANCO PROVINCIAL BBVA",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //22
            [
                'idEntityClass' => 1,
                'code' => '0104',
                'description' => "BANCO VENEZOLANO DE CREDITO S.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //23
            [
                'idEntityClass' => 1,
                'code' => '0168',
                'description' => "BANCRECER S.A. BANCO DE DESARROLLO",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //24
            [
                'idEntityClass' => 1,
                'code' => '0134',
                'description' => "BANESCO BANCO UNIVERSAL",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //25
            [
                'idEntityClass' => 1,
                'code' => '0177',
                'description' => "BANFANB",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //26
            [
                'idEntityClass' => 1,
                'code' => '0146',
                'description' => "BANGENTE",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //27
            [
                'idEntityClass' => 1,
                'code' => '0174',
                'description' => "BANPLUS BANCO COMERCIAL C.A",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //28
            [
                'idEntityClass' => 1,
                'code' => '0190',
                'description' => "CITIBANK.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //29
            [
                'idEntityClass' => 1,
                'code' => '0121',
                'description' => "CORP BANCA.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //30
            [
                'idEntityClass' => 1,
                'code' => '0157',
                'description' => "DELSUR BANCO UNIVERSAL",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //31
            [
                'idEntityClass' => 1,
                'code' => '0151',
                'description' => "FONDO COMUN",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //32
            [
                'idEntityClass' => 1,
                'code' => '0601',
                'description' => "INSTITUTO MUNICIPAL DE CRÉDITO POPULAR",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //33
            [
                'idEntityClass' => 1,
                'code' => '0169',
                'description' => "MIBANCO BANCO DE DESARROLLO, C.A.",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //34
            [
                'idEntityClass' => 1,
                'code' => '0137',
                'description' => "SOFITASA",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            //Modalidad de pago
            //35
            [
                'idEntityClass' => 2,
                'code' => '01',
                'description' => "Pago móvil",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //36
            [
                'idEntityClass' => 2,
                'code' => '02',
                'description' => "Transferencia",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // [
            //     'idEntityClass' => 2,
            //     'code' => '03',
            //     'description' => "Transferencia (Nacional)",
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s')
            // ],
            // [
            //     'idEntityClass' => 2,
            //     'code' => '04',
            //     'description' => "Transferencia (Internacional)",
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s')
            // ],
            //37
            [
                'idEntityClass' => 2,
                'code' => '03',
                'description' => "Comprobante en efectivo",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //38
            [
                'idEntityClass' => 2,
                'code' => '04',
                'description' => "Zelle",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //39
            [
                'idEntityClass' => 2,
                'code' => '05',
                'description' => "Tarjeta debito/credito",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //40
            [
                'idEntityClass' => 2,
                'code' => '06',
                'description' => "Otro",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            //Presentacion
            //41
            [
                'idEntityClass' => 4,
                'code' => '01',
                'description' => "Unidad",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //42
            [
                'idEntityClass' => 4,
                'code' => '02',
                'description' => "Blister (06 Unidades)",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //43
            [
                'idEntityClass' => 4,
                'code' => '03',
                'description' => "Blister (12 Unidades)",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Moneda
            //44
            [
                'idEntityClass' => 5,
                'code' => '01',
                'description' => "Bolivar Soberano (Bs. S)",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //45
            [
                'idEntityClass' => 5,
                'code' => '02',
                'description' => "Dolar",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //46
            [
                'idEntityClass' => 5,
                'code' => '03',
                'description' => "Euro",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Iva
            //47
            [
                'idEntityClass' => 6,
                'code' => '01',
                'description' => "16%",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Descuento
            //48
            [
                'idEntityClass' => 7,
                'code' => '01',
                'description' => "5%",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //49
            [
                'idEntityClass' => 7,
                'code' => '02',
                'description' => "10%",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //50
            [
                'idEntityClass' => 7,
                'code' => '03',
                'description' => "15%",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //51
            [
                'idEntityClass' => 7,
                'code' => '04',
                'description' => "20%",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //52
            [
                'idEntityClass' => 7,
                'code' => '05',
                'description' => "25%",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Estatus
            //53
            [
                'idEntityClass' => 8,
                'code' => '01',
                'description' => "Activo",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //54
            [
                'idEntityClass' => 8,
                'code' => '02',
                'description' => "Inactivo",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //55
            [
                'idEntityClass' => 8,
                'code' => '11',
                'description' => "Pendiente",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //56
            [
                'idEntityClass' => 8,
                'code' => '12',
                'description' => "Verificado ",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //57
            [
                'idEntityClass' => 8,
                'code' => '13',
                'description' => "Entregable ",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //58
            [
                'idEntityClass' => 8,
                'code' => '14',
                'description' => "Entregado ",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //59
            [
                'idEntityClass' => 8,
                'code' => '21',
                'description' => "Pendiente",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //60
            [
                'idEntityClass' => 8,
                'code' => '22',
                'description' => "Aprobado",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipos de admin
            //61
            [
                'idEntityClass' => 11,
                'code' => '21',
                'description' => "Interno",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //62
            [
                'idEntityClass' => 11,
                'code' => '22',
                'description' => "Externo",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipos de documentos
            //63
            [
                'idEntityClass' => 12,
                'code' => '120',
                'description' => "V",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //64
            [
                'idEntityClass' => 12,
                'code' => '121',
                'description' => "E",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //65
            [
                'idEntityClass' => 12,
                'code' => '122',
                'description' => "P",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //66
            [
                'idEntityClass' => 12,
                'code' => '123',
                'description' => "M",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //67
            [
                'idEntityClass' => 12,
                'code' => '124',
                'description' => "J",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //68
            [
                'idEntityClass' => 12,
                'code' => '125',
                'description' => "G",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //69
            [
                'idEntityClass' => 12,
                'code' => '126',
                'description' => "C",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tiempo de Suscripción
            //70
            [
                'idEntityClass' => 13,
                'code' => '1',
                'description' => "Trimestral",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //71
            [
                'idEntityClass' => 13,
                'code' => '1.75',
                'description' => "Semestral",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //72
            [
                'idEntityClass' => 13,
                'code' => '3.25',
                'description' => "Anual",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipo de telefono
            //73
            [
                'idEntityClass' => 14,
                'code' => 'H',
                'description' => "Hogar",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //74
            [
                'idEntityClass' => 14,
                'code' => 'C',
                'description' => "Celular",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //75
            [
                'idEntityClass' => 14,
                'code' => 'O',
                'description' => "Oficina",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipo de Cuenta bancaria
            //76
            [
                'idEntityClass' => 15,
                'code' => 'A',
                'description' => "Ahorro",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //77
            [
                'idEntityClass' => 15,
                'code' => 'C',
                'description' => "Corriente",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipo de Identificacion
            //78
            [
                'idEntityClass' => 16,
                'code' => 'C.I',
                'description' => "Cédula",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //79
            [
                'idEntityClass' => 16,
                'code' => 'Rif',
                'description' => "Rif",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            //Tipo de Cedula
            //80
            [
                'idEntityClass' => 17,
                'code' => 'V',
                'description' => "Venezonalo",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //81
            [
                'idEntityClass' => 17,
                'code' => 'E',
                'description' => "Extranjero",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //82
            [
                'idEntityClass' => 17,
                'code' => 'P',
                'description' => "Pasaporte",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipo de Rif
            //83
            [
                'idEntityClass' => 18,
                'code' => 'V',
                'description' => "Venezonalo",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //84
            [
                'idEntityClass' => 18,
                'code' => 'J',
                'description' => "Jurídico",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //85
            [
                'idEntityClass' => 18,
                'code' => 'E',
                'description' => "Extranjero con residencia en Venezuela",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //86
            [
                'idEntityClass' => 18,
                'code' => 'P    ',
                'description' => "Agente registrado con Pasaporte",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //87
            [
                'idEntityClass' => 18,
                'code' => 'G',
                'description' => "Ente Gubernamental",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Codigo de area de telefonos y celulares
            //88
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0212",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //89
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0234",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //90
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0235",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //91
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0237",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //92
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0239",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //93
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0240",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //94
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0241",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //95
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0242",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //96
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0243",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //97
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0244",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //98
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0245",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //99
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0246",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //100
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0247",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //101
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0248",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //102
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0249",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //103
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0251",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //104
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0255",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //105
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0258",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //106
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0259",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //107
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0261",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //108
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0271",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //109
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0272",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //110
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0273",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //111
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0276",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //112
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0278",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //113
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0281",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //114
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0282",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //115
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0283",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //116
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0284",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //117
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0285",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //118
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0286",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //119
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0287",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //120
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0288",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //121
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0289",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //122
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0293",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //123
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0294",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //124
            [
                'idEntityClass' => 19,
                'code' =>  "1",
                'description' =>  "0295",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Codigo de Área de telefonos locales y celulares
            //125
            [
                'idEntityClass' => 19,
                'code' =>  "2",
                'description' =>  "0412",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // [
            //     'idEntityClass' => 19,
            //     'code' =>  "2",
            //     'description' =>  "0422",
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s')
            // ],
            //126
            [
                'idEntityClass' => 19,
                'code' =>  "2",
                'description' =>  "0414",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //127
            [
                'idEntityClass' => 19,
                'code' =>  "2",
                'description' =>  "0424",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //128
            [
                'idEntityClass' => 19,
                'code' =>  "2",
                'description' =>  "0416",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //129
            [
                'idEntityClass' => 19,
                'code' =>  "2",
                'description' =>  "0426",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipo de Entidades
            //130
            [
                'idEntityClass' => 20,
                'code' =>  "01",
                'description' =>  "Usuario",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //131
            [
                'idEntityClass' => 20,
                'code' =>  "02",
                'description' =>  "Residencia",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //132
            [
                'idEntityClass' => 20,
                'code' =>  "03",
                'description' =>  "Acreedor",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipo de Acreedor
            //133
            [
                'idEntityClass' => 21,
                'code' =>  "01",
                'description' =>  "Empleado",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //134
            [
                'idEntityClass' => 21,
                'code' =>  "02",
                'description' =>  "Proveedor",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Método de Cobro
            //135
            [
                'idEntityClass' => 22,
                'code' =>  "01",
                'description' =>  "Efectivo",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //136
            [
                'idEntityClass' => 22,
                'code' =>  "02",
                'description' =>  "Transferencia",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // //137
            // [
            //     'idEntityClass' => 22,
            //     'code' =>  "03",
            //     'description' =>  "Domiciliación Bancaria",
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s')
            // ],
            //137
            [
                'idEntityClass' => 22,
                'code' =>  "04",
                'description' =>  "A crédito",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Tipo de gastos
            //138
            [
                'idEntityClass' => 23,
                'code' =>  "01",
                'description' =>  "Gasto común",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //139
            [
                'idEntityClass' => 23,
                'code' =>  "02",
                'description' =>  "Gasto no común",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'idEntityClass' => 23,
                'code' =>  "02",
                'description' =>  "Gasto por apartamento",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Estatus de Recibos
            //140
            [
                'idEntityClass' => 9,
                'code' =>  "01",
                'description' =>  "Borrador",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //141
            [
                'idEntityClass' => 9,
                'code' =>  "02",
                'description' =>  "Pendiente por cobrar",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //142
            [
                'idEntityClass' => 9,
                'code' =>  "03",
                'description' =>  "Saldo a favor",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //143
            [
                'idEntityClass' => 9,
                'code' =>  "04",
                'description' =>  "Cobrado",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //144
            [
                'idEntityClass' => 9,
                'code' =>  "05",
                'description' =>  "Anulado",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Estatus de Recibo (Lado del cliente)
            //145
            [
                'idEntityClass' => 24,
                'code' =>  "01",
                'description' =>  "Pendiente por pagar",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //146
            [
                'idEntityClass' => 24,
                'code' =>  "01",
                'description' =>  "Pendiente por Aprobar",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //147
            [
                'idEntityClass' => 24,
                'code' =>  "02",
                'description' =>  "Pagado",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //148
            [
                'idEntityClass' => 24,
                'code' =>  "03",
                'description' =>  "Saldo a favor",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //149
            [
                'idEntityClass' => 24,
                'code' =>  "04",
                'description' =>  "Rechazado",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //150
            [
                'idEntityClass' => 24,
                'code' =>  "04",
                'description' =>  "Anulado",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //Método de Pago
            //151
            [
                'idEntityClass' => 25,
                'code' =>  "01",
                'description' =>  "Transferencia",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //152
            [
                'idEntityClass' => 25,
                'code' =>  "02",
                'description' =>  "Pago movil",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //153
            [
                'idEntityClass' => 25,
                'code' =>  "03",
                'description' =>  "Zelle",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            //154
            [
                'idEntityClass' => 25,
                'code' =>  "04",
                'description' =>  "Comprobante de Efectivo",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

        ]);
    }
}
