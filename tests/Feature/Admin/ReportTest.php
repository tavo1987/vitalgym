<?php

namespace Tests\Feature\Admin;

use App\VitalGym\Entities\User;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_the_page_of_reports()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->get(route('admin.reports.index'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.reports.index');
    }

    /**
     * @test
     */
    /*public function user_can_download_memberships_export()
    {
        $this->withoutExceptionHandling();
        Excel::fake();

        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->get(route('admin.memberships-export.excel'));

        $response->assertSuccessful();

        Excel::assertDownloaded('memberships.xlsx', function(MembershipsPerMonthExport $export) {
            return $export->collection()->contains('#2018-01');
        });
    }*/
}
