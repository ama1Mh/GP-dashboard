<?php
// tests/Unit/ServiceProviderModelTest.php
namespace Tests\Unit;

use App\Models\ServiceProvider;
use Tests\TestCase;

class ServiceProviderModelTest extends TestCase
{
    /** @test */
    public function it_has_correct_table_name()
    {
        $provider = new ServiceProvider();
        $this->assertEquals('service_providers', $provider->getTable());
    }

    /** @test */
    public function it_uses_providerID_as_primary_key()
    {
        $provider = new ServiceProvider();
        $this->assertEquals('providerID', $provider->getKeyName());
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $provider = new ServiceProvider();
        
        $this->assertEquals([
            'name',
            'service_type',
            'contact_info',
        ], $provider->getFillable());
    }

    /** @test */
    public function contact_info_can_be_null()
    {
        $provider = new ServiceProvider(['name' => 'Test Provider']);
        $this->assertNull($provider->contact_info);
    }
}