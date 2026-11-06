@extends('layouts.konser')

@section('title', 'Pesan tiket | ' . config('konser.name'))

@section('content')
    @php
        // Nilai awal (atau nilai sebelumnya kalau form gagal validasi)
        $selectedType = old('ticket_type', 'festival');
        $selectedQty  = (int) old('quantity', 1);
        $initialTotal = ($tickets[$selectedType]['price'] ?? 0) * $selectedQty;
    @endphp

    <form id="ticket-form" class="ticket" method="POST" action="{{ route('register.store') }}">
        @csrf  {{-- token keamanan wajib di setiap form POST Laravel --}}

        <div class="ticket-main">
            <h2>Pesan tiket</h2>
            <p class="lead">Isi data di bawah. Kode tiket langsung dikirim ke email kamu setelah pendaftaran selesai.</p>

            {{-- Nama --}}
            <div class="field">
                <label for="name">Nama lengkap</label>
                <input id="name" name="name" type="text" list="name-suggestions" autocomplete="name" required
                       value="{{ old('name') }}"
                       @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                <datalist id="name-suggestions">
                    @foreach ($instructors as $instructorName => $instructorEmail)
                        <option value="{{ $instructorName }}" label="{{ $instructorEmail }}"></option>
                    @endforeach
                </datalist>
                @error('name') <p class="error" id="name-error">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" autocomplete="email" required
                       value="{{ old('email') }}"
                       aria-describedby="email-hint @error('email') email-error @enderror"
                       @error('email') aria-invalid="true" @enderror>
                <p class="hint" id="email-hint">E-tiket dikirim ke alamat ini, pastikan tidak salah ketik.</p>
                @error('email') <p class="error" id="email-error">{{ $message }}</p> @enderror
            </div>

            {{-- Nomor HP --}}
            <div class="field">
                <label for="phone">Nomor HP</label>
                <input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" required
                       placeholder="08xxxxxxxxxx"
                       value="{{ old('phone') }}"
                       @error('phone') aria-invalid="true" aria-describedby="phone-error" @enderror>
                @error('phone') <p class="error" id="phone-error">{{ $message }}</p> @enderror
            </div>

            {{-- Kategori tiket --}}
            <fieldset class="field">
                <legend>Kategori tiket</legend>
                <div class="option-list">
                    @foreach ($tickets as $key => $ticket)
                        <label class="option">
                            <input type="radio" name="ticket_type" value="{{ $key }}" required
                                   data-price="{{ $ticket['price'] }}"
                                   @checked($selectedType === $key)>
                            <span>
                                <span class="option-name">{{ $ticket['label'] }}</span>
                                <span class="option-note">{{ $ticket['note'] }}</span>
                            </span>
                            <span class="option-price">Rp {{ number_format($ticket['price'], 0, ',', '.') }}</span>
                        </label>
                    @endforeach
                </div>
                @error('ticket_type') <p class="error">{{ $message }}</p> @enderror
            </fieldset>

            {{-- Jumlah tiket --}}
            <div class="field">
                <label for="quantity">Jumlah tiket</label>
                <select id="quantity" name="quantity" required aria-describedby="quantity-hint">
                    @for ($i = 1; $i <= $maxPerOrder; $i++)
                        <option value="{{ $i }}" @selected($selectedQty === $i)>{{ $i }} tiket</option>
                    @endfor
                </select>
                <p class="hint" id="quantity-hint">Maksimal {{ $maxPerOrder }} tiket per pendaftaran.</p>
                @error('quantity') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="ticket-stub">
            <div class="total">
                <span>Total</span>
                <output id="total" for="quantity" aria-live="polite">Rp {{ number_format($initialTotal, 0, ',', '.') }}</output>
            </div>
            <button type="submit" class="btn">Daftar dan kirim e-tiket</button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    const form    = document.getElementById('ticket-form');
    const totalEl = document.getElementById('total');
    const qty     = document.getElementById('quantity');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const nameSuggestions = document.getElementById('name-suggestions');
    const button  = form.querySelector('button[type="submit"]');
    const label   = button.textContent;
    let autoFilledEmail = null;

    // Hitung ulang total setiap kategori atau jumlah tiket diganti
    function updateTotal() {
        const picked = form.querySelector('input[name="ticket_type"]:checked');
        const price  = picked ? Number(picked.dataset.price) : 0;
        totalEl.textContent = 'Rp ' + (price * Number(qty.value)).toLocaleString('id-ID');
    }

    function updateSuggestedEmail() {
        const suggestion = Array.from(nameSuggestions.options)
            .find((option) => option.value === nameInput.value);

        if (suggestion) {
            emailInput.value = suggestion.label;
            autoFilledEmail = suggestion.label;
        } else if (autoFilledEmail && emailInput.value === autoFilledEmail) {
            emailInput.value = '';
            autoFilledEmail = null;
        }
    }

    form.addEventListener('change', updateTotal);
    nameInput.addEventListener('input', updateSuggestedEmail);

    // Kunci tombol setelah diklik, supaya email tidak terkirim dua kali
    form.addEventListener('submit', () => {
        button.disabled = true;
        button.textContent = 'Mengirim e-tiket…';
    });

    // Kalau pengguna menekan tombol Back, aktifkan lagi tombolnya
    window.addEventListener('pageshow', () => {
        button.disabled = false;
        button.textContent = label;
    });
</script>
@endpush
