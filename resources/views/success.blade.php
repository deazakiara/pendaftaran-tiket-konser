@extends('layouts.konser')

@section('title', 'E-tiket ' . $registration->ticket_code . ' | ' . config('konser.name'))

@section('content')
    <div class="ticket">
        <div class="ticket-main">
            <h2>Kamu terdaftar</h2>
            <p class="lead">Tunjukkan kode ini di pintu masuk bersama kartu identitas.</p>

            <p class="code">{{ $registration->ticket_code }}</p>
            <p class="code-note">Berlaku untuk {{ $registration->quantity }} orang</p>

            <dl class="details">
                <dt>Nama</dt>     <dd>{{ $registration->name }}</dd>
                <dt>Kategori</dt> <dd>{{ $registration->ticketLabel() }}</dd>
                <dt>Jumlah</dt>   <dd>{{ $registration->quantity }} tiket</dd>
                <dt>Total</dt>    <dd>{{ $registration->totalRupiah() }}</dd>
            </dl>
        </div>

        <div class="ticket-stub">
            @if ($registration->email_sent_at)
                <p class="notice">
                    E-tiket sudah dikirim ke <strong>{{ $registration->email }}</strong>.
                    Kalau belum masuk dalam beberapa menit, cek folder spam.
                </p>
            @else
                <p class="notice notice-error">
                    Pendaftaran tersimpan, tapi e-tiket belum terkirim ke <strong>{{ $registration->email }}</strong>.
                    Simpan kode di atas sebagai bukti.
                    {{-- Detail error hanya muncul saat APP_DEBUG=true (mode development) --}}
                    @if (session('mail_error') && config('app.debug'))
                        <code>{{ session('mail_error') }}</code>
                    @endif
                </p>
            @endif

            <a class="btn btn-quiet" href="{{ route('register.create') }}">Daftar tiket lain</a>
        </div>
    </div>
@endsection
