<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConcertRegistration extends Model
{
    protected $fillable = [
        'booking_code',
        'name',
        'email',
        'phone',
        'ticket_type_id',
        'quantity',
        'total_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'total_price' => 'integer',
        ];
    }

    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(ConcertTicketType::class, 'ticket_type_id');
    }
}
