<?php

use App\Livewire\Auth;
use Livewire\Livewire;

it('should be able to render a login page', function () {

    Livewire::test(Auth\Login::class)
        ->assertOk();

});
//
//it('should be able to login in to the system', function () {
//
//});
