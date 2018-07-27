<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use App\Exports\MembershipsExcelExport;

class MembershipExportController extends Controller
{
    /**
     * @var Excel
     */
    private $excel;

    public function __construct(Excel  $excel)
    {
        $this->excel = $excel;
    }

    public function excel()
    {
        return $this->excel->download(new MembershipsExcelExport, 'memberships.xlsx');
    }
}
