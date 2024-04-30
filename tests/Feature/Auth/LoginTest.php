<?php

use App\Livewire\Auth;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => 'password',
    ]);
});

it('should be able to render a login page', function () {

    Livewire::test(Auth\Login::class)
        ->assertOk();

});

it('should be able to login in to the system', function () {

    Livewire::test(Auth\Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($this->user->id);
});
