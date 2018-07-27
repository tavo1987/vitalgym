<?php

namespace App\Exports;

use App\VitalGym\Entities\Membership;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class MembershipsExcelExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Membership::query();
    }
}