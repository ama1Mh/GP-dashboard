<?php
// tests/Unit/UserReportModelTest.php

namespace Tests\Unit;

use App\Models\UserReport;
use Tests\TestCase;

class UserReportModelTest extends TestCase
{
    /** @test */
    public function it_has_correct_table_name()
    {
        $report = new UserReport();
        $this->assertEquals('user_reports', $report->getTable());
    }

    /** @test */
    public function it_uses_reportID_as_primary_key()
    {
        $report = new UserReport();
        $this->assertEquals('reportID', $report->getKeyName());
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $report = new UserReport();
        
        $this->assertEquals([
            'userID',
            'description',
            'status',
        ], $report->getFillable());
    }

    /** @test */
    public function status_defaults_to_pending_when_not_provided()
    {
        $report = new UserReport(['description' => 'Test report']);
        $this->assertEquals('pending', $report->status);
    }

    /** @test */
    public function it_can_have_different_status_values()
    {
        $report = new UserReport(['status' => 'reviewed']);
        $this->assertEquals('reviewed', $report->status);
    }
}