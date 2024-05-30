<?php

use App\Enums\AccountRole;
use App\Filament\Resources\UserResource;
use App\Models\User;

it('can render page when admin is viewing', function () {
    $this->get(UserResource::getUrl('index'))->assertSuccessful();
});

it('can render create page when admin is viewing', function () {
    $this->get(UserResource::getUrl('create'))->assertSuccessful();
});


it('should not show index page when actor is not admin', function () {
    $nonAdmin = User::factory()->create(['role' => AccountRole::User->value]);
    $response = $this->actingAs($nonAdmin)->get(UserResource::getUrl('index'));

    $response->assertStatus(403);
});

it('should not show create page when actor is not admin', function () {
    $nonAdmin = User::factory()->create(['role' => AccountRole::User->value]);
    $response = $this->actingAs($nonAdmin)->get(UserResource::getUrl('create'));

    $response->assertStatus(403);
});
