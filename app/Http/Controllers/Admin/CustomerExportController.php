<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomersExcelExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Exporter;

class CustomerExportController extends Controller
{
    /**
     * @var Excel
     */
    private $excel;

    public function __construct(Exporter $excel)
    {
        $this->excel = $excel;
    }

    public function excel()
    {
        return $this->excel->download(new CustomersExcelExport, 'customers.xlsx');
    }
}
