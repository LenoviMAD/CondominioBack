<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Arr;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\RelationUserPlan;
use App\Models\User;
use App\Models\PlanInvoice;
use App\Models\Person;
use App\Models\Phone;
use App\Models\Identity;
use App\Models\AuthGenerate;

class PlanInvoiceController extends BaseController
{
    public function store(Request $request)
    {
    }
}
