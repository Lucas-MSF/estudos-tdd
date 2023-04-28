<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Mail\Invitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_it_should_be_able_to_register_as_a_new_user(): void
    {
        $return = $this->post(route('register'), [
            'name' => 'Lucas Macena',
            'email' => 'lucas@email.com',
            'email_confirmation' => 'lucas@email.com',
            'password' => 'senhaqualquer',
        ]);

        $return->assertSuccessful();
 
        $this->assertDatabaseHas('users', [
            'name' => 'Lucas Macena',
            'email' => 'lucas@email.com',
        ]);

        /** @var User $user */
        $user = User::whereEmail('lucas@email.com')->firstOrFail();

        $this->assertTrue(
            Hash::check('senhaqualquer', $user->password),
            'Checking if password was saved and it is encrypted.'
        );
    }
}
