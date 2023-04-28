<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Mail\Invitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_be_able_to_invite_someone_to_the_platform()
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->post('invite', ['email' => 'novo@email.com']);

        Mail::assertSent(Invitation::class, function ($mail) {
            return $mail->hasTo('novo@email.com');
        });

        $this->assertDatabaseHas('invites', ['email' => 'novo@email.com']);
    }
}
