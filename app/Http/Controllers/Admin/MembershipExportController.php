<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MembershipsExcelExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Exporter;

class MembershipExportController extends Controller
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
        return $this->excel->download(new MembershipsExcelExport, 'memberships.xlsx');
    }
}
