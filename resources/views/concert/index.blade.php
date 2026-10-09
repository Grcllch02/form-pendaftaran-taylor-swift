<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#241746">
    <meta name="description" content="Pendaftaran tiket konser Taylor Swift — halaman simulasi penggemar.">
    <title>The Eras Night — Pendaftaran Tiket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/concert.css') }}">
</head>
<body>
    <div class="announcement">
        <span class="announcement-dot"></span>
        SIMULASI FAN-MADE · BUKAN SITUS RESMI TAYLOR SWIFT
    </div>

    <header class="site-header">
        <a class="brand" href="{{ route('concert.index') }}" aria-label="The Eras Night beranda">
            <span class="brand-star">✳</span>
            <span>the eras <em>night</em></span>
        </a>
        <a class="header-link" href="#daftar">Daftar tiket <span aria-hidden="true">↗</span></a>
    </header>

    <main>
        <section class="hero" aria-labelledby="hero-title">
            <div class="hero-glow hero-glow-one"></div>
            <div class="hero-glow hero-glow-two"></div>
            <div class="hero-content">
                <p class="eyebrow"><span></span> Satu malam. Semua era.</p>
                <h1 id="hero-title">A night to<br><em>remember.</em></h1>
                <p class="hero-copy">Rayakan lagu-lagu yang jadi soundtrack hidupmu dalam malam penuh cahaya, cerita, dan friendship bracelets.</p>
                <div class="event-details">
                    <div class="event-detail">
                        <span class="detail-icon">✦</span>
                        <span><strong>Jakarta, Indonesia</strong><small>Lokasi simulasi</small></span>
                    </div>
                    <span class="detail-divider"></span>
                    <div class="event-detail">
                        <span class="detail-icon">♡</span>
                        <span><strong>Sabtu, 13 Desember 2026</strong><small>18.30 WIB · Pintu buka 16.00</small></span>
                    </div>
                </div>
                <a class="button button-light" href="#daftar">Pilih tiket <span aria-hidden="true">↓</span></a>
            </div>
            <div class="hero-art" aria-hidden="true">
                <div class="orbit orbit-one"></div>
                <div class="orbit orbit-two"></div>
                <div class="moon"></div>
                <div class="sparkle sparkle-one">✦</div>
                <div class="sparkle sparkle-two">✧</div>
                <div class="sparkle sparkle-three">✦</div>
                <div class="art-caption">IN MY<br>CONCERT ERA</div>
                <div class="art-note">13 · 12 · 26</div>
            </div>
            <div class="hero-bottom"><span>GLOWING SINCE THE VERY FIRST SONG</span><span>JAKARTA · 2026</span></div>
        </section>

        <section class="ticket-section" id="daftar">
            @php($availableTicketType = $ticketTypes->first(fn ($ticketType) => $ticketType->sold < $ticketType->quota))
            @php($selectedTicketType = $ticketTypes->first(fn ($ticketType) => $ticketType->slug === old('ticket_type') && $ticketType->sold < $ticketType->quota) ?? $availableTicketType)
            <div class="section-heading">
                <div>
                    <p class="eyebrow eyebrow-dark"><span></span> Your night starts here</p>
                    <h2>Pilih pengalamanmu<span>.</span></h2>
                    <p class="section-copy">Pilih kategori dan amankan tempatmu. Maksimal 4 tiket per pendaftaran.</p>
                </div>
                <div class="limited-note"><span>✧</span> Kuota terbatas</div>
            </div>

            @if (session('booking'))
                <section class="success-card" role="status" aria-live="polite">
                    <div class="success-icon">✓</div>
                    <div>
                        <p class="success-eyebrow">Pendaftaran berhasil</p>
                        <h3>Sampai jumpa di sana, {{ session('booking.name') }}!</h3>
                        <p>{{ session('booking.quantity') }} tiket {{ session('booking.ticket') }} · Total <strong>Rp {{ number_format(session('booking.total'), 0, ',', '.') }}</strong></p>
                        <p class="booking-code">Kode booking <strong>{{ session('booking.code') }}</strong></p>
                        <small>Simpan kode ini sebagai referensi. Ini adalah konfirmasi simulasi, bukan tiket masuk.</small>
                    </div>
                </section>
            @endif

            <form action="{{ route('concert.register') }}" method="POST" id="registration-form">
                @csrf
                <div class="ticket-grid">
                    @foreach ($ticketTypes as $ticketType)
                        @php($remaining = max(0, $ticketType->quota - $ticketType->sold))
                        <label class="ticket-card {{ $selectedTicketType?->slug === $ticketType->slug ? 'is-selected' : '' }} {{ $remaining === 0 ? 'is-sold-out' : '' }}">
                            <input
                                type="radio"
                                name="ticket_type"
                                value="{{ $ticketType->slug }}"
                                data-price="{{ $ticketType->price }}"
                                data-name="{{ $ticketType->name }}"
                                data-remaining="{{ $remaining }}"
                                @checked($selectedTicketType?->slug === $ticketType->slug)
                                @disabled($remaining === 0)
                            >
                            <span class="ticket-card-top">
                                <span class="ticket-icon">{{ ['✦', '✧', '♡', '☆'][$loop->index] }}</span>
                                <span class="ticket-check" aria-hidden="true">✓</span>
                            </span>
                            <span class="ticket-name">{{ $ticketType->name }}</span>
                            <span class="ticket-description">{{ $ticketType->description }}</span>
                            <span class="ticket-price">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</span>
                            <span class="ticket-availability">
                                @if ($remaining === 0)
                                    Habis terjual
                                @else
                                    {{ number_format($remaining, 0, ',', '.') }} tiket tersedia
                                @endif
                            </span>
                        </label>
                    @endforeach
                </div>

                <div class="form-layout">
                    <div class="form-panel">
                        <div class="form-heading">
                            <span class="form-step">01</span>
                            <div><h3>Detail pendaftaran</h3><p>Isi data sesuai identitas untuk konfirmasi.</p></div>
                        </div>

                        <div class="field-grid">
                            <div class="field">
                                <label for="name">Nama lengkap</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Nama sesuai identitas" autocomplete="name" required maxlength="100">
                                @error('name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="email">Alamat email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" required maxlength="255">
                                @error('email')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="phone">Nomor telepon</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="+62 812 3456 7890" autocomplete="tel" required>
                                @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="quantity">Jumlah tiket</label>
                                <select id="quantity" name="quantity" required>
                                    @for ($quantity = 1; $quantity <= 4; $quantity++)
                                        <option value="{{ $quantity }}" @selected(old('quantity', 1) == $quantity)>{{ $quantity }} tiket</option>
                                    @endfor
                                </select>
                                @error('quantity')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <label class="terms">
                            <input type="checkbox" name="terms" value="1" @checked(old('terms')) required>
                            <span>Saya menyetujui syarat pendaftaran dan memahami bahwa ini adalah <strong>simulasi fan-made</strong>, bukan situs resmi atau tiket konser sungguhan.</span>
                        </label>
                        @error('terms')<span class="field-error terms-error">{{ $message }}</span>@enderror
                    </div>

                    <aside class="order-panel" aria-label="Ringkasan pesanan">
                        <div class="order-heading"><span>✧</span> Ringkasan</div>
                        <div class="order-item"><span>Kategori</span><strong id="summary-ticket">{{ $selectedTicketType?->name ?? 'Tiket habis' }}</strong></div>
                        <div class="order-item"><span>Jumlah</span><strong id="summary-quantity">{{ old('quantity', 1) }} tiket</strong></div>
                        <div class="order-divider"></div>
                        <div class="order-total"><span>Total</span><strong id="summary-total">Rp {{ number_format(($selectedTicketType?->price ?? 0) * old('quantity', 1), 0, ',', '.') }}</strong></div>
                        <button class="button button-submit" type="submit" @disabled($availableTicketType === null)>Daftar sekarang <span aria-hidden="true">→</span></button>
                        <p class="secure-note"><span>♡</span> Gratis biaya pendaftaran · Simulasi</p>
                    </aside>
                </div>
            </form>
        </section>

        <section class="reminder">
            <span class="reminder-star">✳</span>
            <div><strong>Come on, let’s sing it together.</strong><p>Siapkan friendship bracelets-mu dan ajak teman satu eras-mu.</p></div>
            <span class="reminder-heart">♡</span>
        </section>
    </main>

    <footer class="site-footer">
        <a class="brand footer-brand" href="{{ route('concert.index') }}"><span class="brand-star">✳</span><span>the eras <em>night</em></span></a>
        <p>Proyek demo fan-made · Tidak berafiliasi dengan Taylor Swift atau pemegang hak terkait.</p>
        <span>MADE WITH <span class="footer-heart">♡</span> FOR THE MUSIC</span>
    </footer>

    <script>
        const ticketInputs = document.querySelectorAll('input[name="ticket_type"]');
        const quantityInput = document.querySelector('#quantity');
        const summaryTicket = document.querySelector('#summary-ticket');
        const summaryQuantity = document.querySelector('#summary-quantity');
        const summaryTotal = document.querySelector('#summary-total');
        const rupiah = new Intl.NumberFormat('id-ID');

        function updateSummary() {
            const selected = document.querySelector('input[name="ticket_type"]:checked');
            if (!selected) return;

            const quantity = Number(quantityInput.value);
            summaryTicket.textContent = selected.dataset.name;
            summaryQuantity.textContent = `${quantity} tiket`;
            summaryTotal.textContent = `Rp ${rupiah.format(Number(selected.dataset.price) * quantity)}`;

            document.querySelectorAll('.ticket-card').forEach((card) => card.classList.remove('is-selected'));
            selected.closest('.ticket-card').classList.add('is-selected');
        }

        ticketInputs.forEach((input) => input.addEventListener('change', updateSummary));
        quantityInput.addEventListener('change', updateSummary);
        updateSummary();

        @if ($errors->any())
            document.querySelector('#daftar').scrollIntoView({ behavior: 'smooth' });
        @endif
    </script>
</body>
</html>
