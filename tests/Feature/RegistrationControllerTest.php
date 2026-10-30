<?php

use App\Mail\TicketConfirmation;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('allows visitors to type their name and email in the registration form', function () {
    $response = $this->get(route('register.create'));

    $response->assertOk()
        ->assertSee('id="name" name="name" type="text" list="name-suggestions"', false)
        ->assertSee('<datalist id="name-suggestions">', false)
        ->assertSee('value="Elizabeth Nathania" label="elizabeth.nathania@ciputra.ac.id"', false)
        ->assertSee('value="Haning Kumbara" label="haning.kumbara@ciputra.ac.id"', false)
        ->assertSee('id="email" name="email" type="email"', false)
        ->assertDontSee('readonly', false);
});

it('sends the ticket to the email address submitted in the public form', function () {
    Mail::fake();

    $response = $this->post(route('register.store'), [
        'name' => 'Test Student',
        'email' => 'student@example.com',
        'phone' => '081234567890',
        'ticket_type' => 'festival',
        'quantity' => 1,
    ]);

    $registration = Registration::query()->sole();

    $response->assertRedirect(route('register.success', $registration))
        ->assertSessionHasNoErrors();
    $this->assertDatabaseHas('registrations', [
        'ticket_code' => $registration->ticket_code,
        'name' => 'Test Student',
        'email' => 'student@example.com',
    ]);
    Mail::assertSentTimes(TicketConfirmation::class, 1);
    Mail::assertSent(TicketConfirmation::class, fn (TicketConfirmation $mail): bool => $mail->hasTo('student@example.com'));
});
