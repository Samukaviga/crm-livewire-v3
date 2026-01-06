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

test('validate fields', function ($data) {

    Livewire::test(Register::class, [$data->field => $data->value])
        ->call('submit')
        ->assertHasErrors([$data->field => $data->rule]);

})->with([
    'name::required' => (object) ['field' => 'name', 'value' => '', 'rule' => 'required'],
    'name::max:255' => (object) ['field' => 'name', 'value' => str_repeat('*', 256), 'rule' => 'max'],

    'password::required' => (object) ['field' => 'password', 'value' => '', 'rule' => 'required'],
    'password::max:255' => (object) ['field' => 'password', 'value' => str_repeat('*', 256), 'rule' => 'max'],

    'email::required' => (object) ['field' => 'email', 'value' => '', 'rule' => 'required'],
    'email::max:255' => (object) ['field' => 'email', 'value' => str_repeat('*'.'@doe.com', 256), 'rule' => 'max'],
    'email::email' => (object) ['field' => 'email', 'value' => 'its_not_email', 'rule' => 'email'],
    'email::confirmed' => (object) ['field' => 'email', 'value' => 'test@gmail.com', 'rule' => 'confirmed'],

]);

/*
test('required field', function ($fields) {

    Livewire::test(Register::class, [$fields => ''])
        ->call('submit')
        ->assertHasErrors([$fields => 'required']);

})->with(['name', 'email', 'password'])->todo();


test('max character', function ($fields) {

    Livewire::test(Register::class, [$fields => str_repeat('*', 256) ])
        ->call('submit')
        ->assertHasErrors([$fields => 'max']);

})->with(['name', 'email', 'password'])->todo(); */
