<?php
// tests/Unit/RequestModelTest.php
namespace Tests\Unit;

use App\Models\RequestModel;
use Tests\TestCase;

class RequestModelTest extends TestCase
{
    /** @test */
    public function it_has_correct_table_name()
    {
        $request = new RequestModel();
        $this->assertEquals('requests', $request->getTable());
    }

    /** @test */
    public function it_uses_requestID_as_primary_key()
    {
        $request = new RequestModel();
        $this->assertEquals('requestID', $request->getKeyName());
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $request = new RequestModel();
        
        $this->assertEquals([
            'userID',
            'providerID',
            'status',
            'requestType',
            'priority',
            'description',
            'created_at',
            'updated_at',
        ], $request->getFillable());
    }

    /** @test */
    public function it_can_have_different_priority_levels()
    {
        $request = new RequestModel(['priority' => 'high']);
        $this->assertEquals('high', $request->priority);
    }
}