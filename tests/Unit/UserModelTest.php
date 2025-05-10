namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $user = new User();
        
        $this->assertEquals([
            'name',
            'email',
            'password',
        ], $user->getFillable());
    }

    /** @test */
    public function it_has_hidden_attributes()
    {
        $user = new User();
        
        $this->assertEquals([
            'password',
            'remember_token',
        ], $user->getHidden());
    }

    /** @test */
    public function it_has_correct_cast_attributes()
    {
        $user = new User();
        $casts = $user->getCasts();
        
        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        
        // If you're using incrementing IDs as integers
        $this->assertArrayHasKey('id', $casts);
        $this->assertEquals('int', $casts['id']);
    }

    /** @test */
    public function it_can_set_and_get_name_attribute()
    {
        $user = new User();
        $user->name = 'John Doe';
        
        $this->assertEquals('John Doe', $user->name);
    }
}