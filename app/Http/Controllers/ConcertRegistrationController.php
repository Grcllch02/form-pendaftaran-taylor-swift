<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationEmail;
use App\Models\ConcertRegistration;
use App\Models\ConcertTicketType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConcertRegistrationController extends Controller
{
    public function index(): View
    {
        return view('concert.index', [
            'ticketTypes' => ConcertTicketType::query()->orderBy('price')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9\s().-]{8,20}$/'],
            'ticket_type' => ['required', 'string', 'exists:concert_ticket_types,slug'],
            'quantity' => ['required', 'integer', 'between:1,4'],
            'terms' => ['accepted'],
        ], [
            'phone.regex' => 'Masukkan nomor telepon yang valid.',
            'quantity.between' => 'Jumlah tiket yang dapat dipesan adalah 1–4 tiket.',
            'terms.accepted' => 'Persetujuan syarat pendaftaran wajib dicentang.',
        ]);

        $booking = DB::transaction(function () use ($validated): array {
            $ticketType = ConcertTicketType::query()
                ->where('slug', $validated['ticket_type'])
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];
            $reserved = ConcertTicketType::query()
                ->whereKey($ticketType->id)
                ->whereRaw('quota - sold >= ?', [$quantity])
                ->increment('sold', $quantity);

            if ($reserved === 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'Maaf, tiket kategori ini sudah habis atau kuotanya tidak mencukupi.',
                ]);
            }

            $registration = ConcertRegistration::query()->create([
                'booking_code' => Str::upper(Str::random(12)),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'ticket_type_id' => $ticketType->id,
                'quantity' => $quantity,
                'total_price' => $ticketType->price * $quantity,
            ]);

            return [
                'code' => $registration->booking_code,
                'name' => $registration->name,
                'ticket' => $ticketType->name,
                'quantity' => $quantity,
                'total' => $registration->total_price,
            ];
        });

        Mail::to($validated['email'])->send(new RegistrationEmail(
            userName: $booking['name'],
            ticketName: $booking['ticket'],
            ticketQuantity: $booking['quantity'],
            totalPrice: $booking['total'],
            bookingCode: $booking['code'],
        ));

        return to_route('concert.index')->with('booking', $booking);
    }
}
