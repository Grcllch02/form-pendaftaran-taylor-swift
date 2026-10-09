<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConcertTicketType extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'description',
        'price',
        'quota',
        'sold',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'quota' => 'integer',
            'sold' => 'integer',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(ConcertRegistration::class, 'ticket_type_id');
    }
}
