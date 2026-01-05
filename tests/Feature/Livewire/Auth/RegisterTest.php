<?php

use App\Livewire\Auth\Register;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

it('renders successfully', function () {
    Livewire::test(Register::class)
        ->assertStatus(200);
});

it('should be able to register a new user in the system', function () {

    Livewire::test(Register::class)
        ->set('name', 'Samuel')
        ->set('email', 'samuel@gmail.com')
        ->set('email_confirmation', 'samuel@gmail.com')
        ->set('password', 'password')
        ->call('submit')
        ->assertHasNoErrors();

    assertDatabaseHas('users', ['name' => 'Samuel', 'email' => 'samuel@gmail.com']);

    assertDatabaseCount('users', 1);

});
