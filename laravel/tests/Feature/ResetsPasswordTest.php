<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetsPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Sends the password reset email when the user exists.
     *
     * @test
     * @return void
     */
    public function it_sends_a_password_reset_email()
    {
        Notification::fake();
        $user = factory(User::class)->create();

        $response = $this->postJson('api/password/email', ['email' => $user->email]);

        $response->assertStatus(200);
        $token = \DB::table('password_resets')->where('email', $user->email)->value('token');
        Notification::assertSentTo($user, ResetPasswordNotification::class, function($notification) use ($token) {
            return \Hash::check($notification->token, $token);
        });
    }
    /**
     * Does not send a password reset email when the user does not exist.
     *
     * @test
     * @return void
     */
    public function it_ignores_invalid_password_reset_requests()
    {
        Notification::fake();

        $response = $this->postJson('api/password/email', ['email' => 'invalid@email.com']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        Notification::assertNothingSent();
    }

    /**
     * Allows a user to reset their password.
     *
     * @test
     * @return void
     */
    public function it_changes_a_users_password()
    {
        $user = factory(User::class)->create();
        $token = Password::createToken($user);

        $response = $this->post('api/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(200);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    /**
     * Allows a user to reset their password.
     *
     * @test
     * @return void
     */
    public function it_does_not_change_a_password_when_given_an_invalid_reset_token()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->post('api/password/reset', [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $this->assertFalse(Hash::check('password', $user->fresh()->password));
    }
}
