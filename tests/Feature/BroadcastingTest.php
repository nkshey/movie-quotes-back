<?php

use App\Events\NotificationEvent;
use App\Events\QuoteCommented;
use App\Events\QuoteLiked;
use App\Events\QuoteUnliked;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

test('authenticated user can join quote-like channel', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $response = $this->post('/api/broadcasting/auth', [
        'channel_name' => 'private-quote-like',
        'socket_id'    => '1234.5678',
    ]);

    $response->assertStatus(200);
});

test('authenticated user can join quote-comment channel', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $response = $this->post('/api/broadcasting/auth', [
        'channel_name' => 'private-quote-comment',
        'socket_id'    => '1234.5678',
    ]);

    $response->assertStatus(200);
});

test('authenticated user can join notifications channel', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');

    $response = $this->post('/api/broadcasting/auth', [
        'channel_name' => "private-notifications.{$user->id}",
        'socket_id'    => '1234.5678',
    ]);

    $response->assertStatus(200);
});

test('QuoteLiked event is dispatched when user likes a quote', function () {
    Event::fake([QuoteLiked::class]);

    $user = User::factory()->create();
    $quote = Quote::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('likes.store'), ['quote_id' => $quote->id])
        ->assertStatus(201);

    Event::assertDispatched(QuoteLiked::class);
});

test('QuoteUnliked event is dispatched when user unlikes a quote', function () {
    Event::fake([QuoteUnliked::class]);

    $user = User::factory()->create();
    $quote = Quote::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('likes.store'), ['quote_id' => $quote->id])
        ->assertStatus(201);

    $this->deleteJson(route('likes.destroy', ['quote_id' => $quote->id]))
        ->assertStatus(200);

    Event::assertDispatched(QuoteUnliked::class);
});

test('QuoteCommented event is dispatched when user comments on a quote', function () {
    Event::fake([QuoteCommented::class]);

    $user = User::factory()->create();
    $quote = Quote::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('comments.store'), [
            'quote_id' => $quote->id,
            'body'     => 'Nice quote!',
        ])
        ->assertStatus(201);

    Event::assertDispatched(QuoteCommented::class);
});

test('NotificationEvent is dispatched when user likes another user\'s quote', function () {
    Event::fake([NotificationEvent::class]);

    $owner = User::factory()->create();
    $liker = User::factory()->create();
    $quote = Quote::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($liker, 'sanctum')
        ->postJson(route('likes.store'), ['quote_id' => $quote->id])
        ->assertStatus(201);

    Event::assertDispatched(NotificationEvent::class, function ($event) use ($owner) {
        return $event->user_id === $owner->id;
    });
});

test('NotificationEvent is dispatched when user comments on another user\'s quote', function () {
    Event::fake([NotificationEvent::class]);

    $owner = User::factory()->create();
    $commenter = User::factory()->create();
    $quote = Quote::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($commenter, 'sanctum')
        ->postJson(route('comments.store'), [
            'quote_id' => $quote->id,
            'body'     => 'Nice quote!',
        ])
        ->assertStatus(201);

    Event::assertDispatched(NotificationEvent::class, function ($event) use ($owner) {
        return $event->user_id === $owner->id;
    });
});

test('NotificationEvent is NOT dispatched when user likes their own quote', function () {
    Event::fake([NotificationEvent::class]);

    $user = User::factory()->create();
    $quote = Quote::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user, 'sanctum')
        ->postJson(route('likes.store'), ['quote_id' => $quote->id])
        ->assertStatus(201);

    Event::assertNotDispatched(NotificationEvent::class);
});

test('NotificationEvent is NOT dispatched when user comments on their own quote', function () {
    Event::fake([NotificationEvent::class]);

    $user = User::factory()->create();
    $quote = Quote::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user, 'sanctum')
        ->postJson(route('comments.store'), [
            'quote_id' => $quote->id,
            'body'     => 'Nice quote!',
        ])
        ->assertStatus(201);

    Event::assertNotDispatched(NotificationEvent::class);
});
