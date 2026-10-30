<?php

namespace Tests\Feature;

use App\Mail\RegistrationEmail;
use App\Models\ConcertRegistration;
use App\Models\ConcertTicketType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ConcertRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_displays_ticket_categories_and_simulation_notice(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('BUKAN SITUS RESMI TAYLOR SWIFT')
            ->assertSee('Front Row')
            ->assertSee('Rp 4.500.000');
    }

    public function test_guest_can_register_for_tickets_and_receives_a_booking_code(): void
    {
        Mail::fake();

        $ticketType = ConcertTicketType::query()->where('slug', 'cat-1')->firstOrFail();

        $response = $this->post(route('concert.register'), [
            'name' => 'Taylor Fan',
            'email' => 'fan@example.com',
            'phone' => '+62 812 3456 7890',
            'ticket_type' => $ticketType->slug,
            'quantity' => 2,
            'terms' => '1',
        ]);

        $response->assertRedirect(route('concert.index'))
            ->assertSessionHas('booking', function (array $booking): bool {
                return $booking['name'] === 'Taylor Fan'
                    && $booking['ticket'] === 'CAT 1'
                    && $booking['quantity'] === 2
                    && $booking['total'] === 6400000
                    && strlen($booking['code']) === 12;
            });

        Mail::assertSent(RegistrationEmail::class, function (RegistrationEmail $mail): bool {
            return $mail->hasTo('fan@example.com');
        });

        $this->assertDatabaseHas('concert_registrations', [
            'name' => 'Taylor Fan',
            'email' => 'fan@example.com',
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
            'total_price' => 6400000,
        ]);
        $this->assertSame(2, $ticketType->fresh()->sold);
    }

    public function test_registration_rejects_missing_consent_and_invalid_ticket_quantity(): void
    {
        $response = $this->from('/')
            ->post(route('concert.register'), [
                'name' => 'Taylor Fan',
                'email' => 'fan@example.com',
                'phone' => '+62 812 3456 7890',
                'ticket_type' => 'cat-1',
                'quantity' => 5,
            ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors(['quantity', 'terms']);
        $this->assertSame(0, ConcertRegistration::query()->count());
    }

    public function test_registration_cannot_exceed_remaining_ticket_quota(): void
    {
        $ticketType = ConcertTicketType::query()->where('slug', 'front-row')->firstOrFail();
        $ticketType->update(['sold' => $ticketType->quota - 1]);

        $response = $this->from('/')
            ->post(route('concert.register'), [
                'name' => 'Taylor Fan',
                'email' => 'fan@example.com',
                'phone' => '+62 812 3456 7890',
                'ticket_type' => $ticketType->slug,
                'quantity' => 2,
                'terms' => '1',
            ]);

        $response->assertRedirect('/')
            ->assertSessionHasErrors('quantity');
        $this->assertSame(0, ConcertRegistration::query()->count());
        $this->assertSame($ticketType->quota - 1, $ticketType->fresh()->sold);
    }
}
