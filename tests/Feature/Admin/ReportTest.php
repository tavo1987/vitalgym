<?php

namespace Tests\Feature\Admin;

use App\VitalGym\Entities\User;
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
}
