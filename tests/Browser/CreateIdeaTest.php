<?php

use App\Models\Idea;
use App\Models\User;

it('creates a new idea', function () {
  $this->actingAs($user = User::factory()->create());

  visit('/ideas')
    ->click('@create-idea-button')
    ->fill('title', 'Some example title')
    ->click('@button-status-completed')
    ->fill('description', 'An example description')
    ->fill('@new-link', 'https://laracasts.com/series/laravel-from-scratch-2026')
    ->click('@submit-new-link-button')
    ->fill('@new-link', 'https://laracasts.com')
    ->click('@submit-new-link-button')
    ->click('Create')
    ->assertPathIs('/ideas');

  expect($user->ideas()->first())->toMatchArray([
    'title' => 'Some example title',
    'status' => 'completed',
    'description' => 'An example description',
    'links' => ['https://laracasts.com/series/laravel-from-scratch-2026', 'https://laracasts.com']
  ]);
});
