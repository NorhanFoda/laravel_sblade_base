<?php

namespace App\Http\Controllers\Api\V1\Web;

use App\Http\Controllers\Controller;
use App\Traits\ExcelTrait;

class ReportExportController extends Controller
{
    use ExcelTrait;

    private String $path = '/storage/downloaded/excel/reports';

    public function __construct()
    {

    }

}
