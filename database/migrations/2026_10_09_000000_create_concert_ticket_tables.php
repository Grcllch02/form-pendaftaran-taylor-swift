<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('concert_ticket_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description');
            $table->unsignedInteger('price');
            $table->unsignedInteger('quota');
            $table->unsignedInteger('sold')->default(0);
            $table->timestamps();
        });

        Schema::create('concert_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 12)->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 24);
            $table->foreignId('ticket_type_id')->constrained('concert_ticket_types');
            $table->unsignedTinyInteger('quantity');
            $table->unsignedInteger('total_price');
            $table->timestamps();
        });

        $now = now();

        DB::table('concert_ticket_types')->insert([
            [
                'slug' => 'front-row',
                'name' => 'Front Row',
                'description' => 'Paling dekat dengan panggung',
                'price' => 4500000,
                'quota' => 100,
                'sold' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'cat-1',
                'name' => 'CAT 1',
                'description' => 'Area premium dengan pandangan penuh',
                'price' => 3200000,
                'quota' => 350,
                'sold' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'cat-2',
                'name' => 'CAT 2',
                'description' => 'Pengalaman konser yang tak terlupakan',
                'price' => 1900000,
                'quota' => 800,
                'sold' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'cat-3',
                'name' => 'CAT 3',
                'description' => 'Nikmati malam penuh lagu dan cerita',
                'price' => 950000,
                'quota' => 1500,
                'sold' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('concert_registrations');
        Schema::dropIfExists('concert_ticket_types');
    }
};
