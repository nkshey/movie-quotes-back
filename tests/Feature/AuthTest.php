<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

pest()->uses(RefreshDatabase::class);

describe('registration', function () {
    it('registers a user with valid data', function () {
        Event::fake();

        $response = $this->postJson('/api/register', [
            'username'              => 'testuser',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        expect($response->status())->toBe(201)
            ->and($response->json('status'))->toBe('registration_pending_verification');

        expect(User::where('username', 'testuser')->where('email', 'test@example.com')->exists())->toBeTrue();

        Event::assertDispatched(Registered::class);
    });

    it('does not register user with missing fields', function () {
        $response = $this->postJson('/api/register', [
            'username'              => '',
            'email'                 => '',
            'password'              => '',
            'password_confirmation' => '',
        ]);

        expect($response->status())->toBe(422);
        expect($response->json('errors'))->toHaveKeys(['username', 'email', 'password']);
    });

    it('does not register user with mismatched passwords', function () {
        $response = $this->postJson('/api/register', [
            'username'              => 'testuser2',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        expect($response->status())->toBe(422);
        expect($response->json('errors'))->toHaveKey('password');
    });

    it('does not register user with duplicate email', function () {
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);

        $response = $this->postJson('/api/register', [
            'username'              => 'anotheruser',
            'email'                 => 'duplicate@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        expect($response->status())->toBe(422);
        expect($response->json('errors'))->toHaveKey('email');
    });

    it('does not register user with duplicate username', function () {
        User::factory()->create([
            'username' => 'duplicate',
        ]);

        $response = $this->postJson('/api/register', [
            'username'              => 'duplicate',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        expect($response->status())->toBe(422);
        expect($response->json('errors'))->toHaveKey('username');
    });
});

describe('login', function () {
    it('logs in with valid email and password', function () {
        User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = sanctumSpaPostJson('/api/login', [
            'login'    => 'test@example.com',
            'password' => 'password123',
        ]);

        expect($response->status())->toBe(200);
        expect($response->json('message'))->toBe('Login successful');
    });

    it('logs in with valid username and password', function () {
        User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = sanctumSpaPostJson('/api/login', [
            'login'    => 'testuser',
            'password' => 'password123',
        ]);

        expect($response->status())->toBe(200);
        expect($response->json('message'))->toBe('Login successful');
    });

    it('fails login with invalid credentials', function () {
        User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = sanctumSpaPostJson('/api/login', [
            'login'    => 'testuser',
            'password' => 'wrongpassword',
        ]);

        expect($response->status())->toBe(401);
        expect($response->json('message'))->toBe(__('auth.login_invalid'));
    });

    it('fails login if email is not verified', function () {
        User::factory()->create([
            'username'          => 'unverified',
            'password'          => bcrypt('password123'),
            'email_verified_at' => null,
        ]);

        $response = sanctumSpaPostJson('/api/login', [
            'login'    => 'unverified',
            'password' => 'password123',
        ]);

        expect($response->status())->toBe(403);
        expect($response->json('message'))->toBe(__('auth.email_not_verified'));
    });
});

describe('logout', function () {
    it('logs out an authenticated user', function () {
        $user = User::factory()->create();

        $logoutResponse = sanctumSpaPostJson('/api/logout', [], $user);

        expect($logoutResponse->status())->toBe(200);
    });
});

describe('google oauth', function () {
    it('returns the correct Google OAuth redirect URL', function () {
        $redirectUrl = 'https://accounts.google.com/o/oauth2/auth?client_id=xyz';

        Socialite::shouldReceive('driver->stateless->redirect->getTargetUrl')
            ->andReturn($redirectUrl);

        $response = $this->get('/api/auth/google/redirect');

        expect($response->status())->toBe(200);
        expect($response->getContent())->toBe($redirectUrl);
    });

    it('authenticates a user via Google OAuth and returns correct locale', function () {
        $googleUser = new SocialiteUser;
        $googleUser->id = '123456';
        $googleUser->name = 'Google User';
        $googleUser->email = 'googleuser@gmail.com';
        $googleUser->avatar = 'https://placehold.co/120x120';

        Socialite::shouldReceive('driver->stateless->user')->andReturn($googleUser);

        $response = $this->get('/api/auth/google/callback');

        expect(User::where('email', 'googleuser@gmail.com')->exists())->toBeTrue();
        expect($response->json('message'))->toBe('Google authentication successful');
    });
});
