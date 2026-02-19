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
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Do another thing')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some example title',
        'status' => 'completed',
        'description' => 'An example description',
        'links' => ['https://laracasts.com/series/laravel-from-scratch-2026', 'https://laracasts.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);
});

it('edits an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Some example title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://laracasts.com/series/laravel-from-scratch-2026')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://laracasts.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Do another thing')
        ->click('@submit-new-step-button')
        ->click('Update')
        ->assertRoute('idea.show', [$idea]);

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some example title',
        'status' => 'completed',
        'description' => 'An example description',
        'links' => ['https://laracasts.com/series/laravel-from-scratch-2026', 'https://laracasts.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);
});
