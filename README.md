# The Eras Night

A fan-made Laravel demo for concert ticket registration. This is a fictional simulation and is not an official Taylor Swift website or a valid concert ticket.

## Requirements

- PHP 8.3 or newer with `mbstring` and `pdo_sqlite`
- Composer

## Run locally

From this directory, run:

```powershell
Copy-Item .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan migrate
php artisan serve
```

Open the URL shown by `php artisan serve`. The app uses SQLite by default. Ticket categories and their initial quotas are created by the concert ticket migration.

If Artisan reports a missing PHP extension, enable `extension=mbstring` and `extension=pdo_sqlite` in the `php.ini` shown by `php --ini`, then restart the PHP server.

## Registration flow

Visitors choose a ticket category, quantity, and provide their contact details. Successful registrations are stored in `concert_registrations` with a booking code; category inventory is updated in the same database transaction. No payment is collected—the flow is a demo only.

Run the feature tests with:

```powershell
php artisan test --filter=ConcertRegistrationTest
```
