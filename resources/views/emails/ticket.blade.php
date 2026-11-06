{{--
    Template email e-tiket.
    Email client (Gmail, Outlook) tidak mendukung CSS modern,
    jadi layout pakai <table> dan style ditulis langsung di tiap elemen.
--}}
@php
    $event = config('konser');
    $row   = 'padding:10px 0; border-bottom:1px solid #E6E0F0; font-size:14px;';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-tiket {{ $registration->ticket_code }}</title>
</head>
<body style="margin:0; padding:0; background:#ECE8F4;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#ECE8F4;">
    <tr>
        <td align="center" style="padding:32px 12px;">
            <table role="presentation" width="560" cellpadding="0" cellspacing="0"
                   style="width:100%; max-width:560px; background:#FBF9FF; border-radius:16px; overflow:hidden; font-family:Arial, Helvetica, sans-serif; color:#1C1A2E;">

                {{-- Header langit senja --}}
                <tr>
                    <td style="background:#2B2453; background-image:linear-gradient(180deg, #191C3D 0%, #4A2C5E 55%, #C8503F 100%); padding:32px 32px 28px;">
                        <p style="margin:0 0 8px; font-size:14px; color:#E6DAF3;">Bukti registrasi</p>
                        <h1 style="margin:0; font-family:'Big Shoulders Display', Impact, 'Arial Narrow', sans-serif; font-size:42px; line-height:1; color:#FBF9FF;">
                            {{ $event['name'] }}
                        </h1>
                        <p style="margin:12px 0 0; font-size:14px; line-height:1.5; color:#F3E6F7;">
                            {{ $event['date'] }}, open gate {{ $event['gate'] }}<br>
                            {{ $event['venue'] }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="height:6px; background:#FF7A33; font-size:0; line-height:0;">&nbsp;</td>
                </tr>

                {{-- Sapaan --}}
                <tr>
                    <td style="padding:28px 32px 4px;">
                        <p style="margin:0 0 10px; font-size:16px;">Halo {{ $registration->name }},</p>
                        <p style="margin:0; font-size:15px; line-height:1.6; color:#3D3852;">
                            Registrasi kamu berhasil. Tunjukkan kode di bawah ini di pintu masuk bersama kartu identitas.
                        </p>
                    </td>
                </tr>

                {{-- Kode tiket --}}
                <tr>
                    <td style="padding:20px 32px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                               style="border:2px dashed #CFC6E2; border-radius:12px;">
                            <tr>
                                <td align="center" style="padding:22px 16px;">
                                    <p style="margin:0 0 6px; font-size:13px; color:#625C78;">Kode tiket</p>
                                    <p style="margin:0; font-family:'Courier New', Courier, monospace; font-size:32px; font-weight:bold; letter-spacing:4px; color:#191C3D;">
                                        {{ $registration->ticket_code }}
                                    </p>
                                    <p style="margin:8px 0 0; font-size:13px; color:#625C78;">
                                        Berlaku untuk {{ $registration->quantity }} orang
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Rincian pesanan --}}
                <tr>
                    <td style="padding:0 32px 8px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="{{ $row }} color:#625C78;">Nama</td>
                                <td align="right" style="{{ $row }}">{{ $registration->name }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $row }} color:#625C78;">Email</td>
                                <td align="right" style="{{ $row }}">{{ $registration->email }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $row }} color:#625C78;">Nomor HP</td>
                                <td align="right" style="{{ $row }}">{{ $registration->phone }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $row }} color:#625C78;">Kategori</td>
                                <td align="right" style="{{ $row }}">{{ $registration->ticketLabel() }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $row }} color:#625C78;">Jumlah</td>
                                <td align="right" style="{{ $row }}">{{ $registration->quantity }} tiket</td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0; font-size:15px; font-weight:bold;">Total</td>
                                <td align="right" style="padding:12px 0; font-size:15px; font-weight:bold;">{{ $registration->totalRupiah() }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Info sebelum datang --}}
                <tr>
                    <td style="padding:12px 32px 30px;">
                        <p style="margin:0 0 6px; font-size:14px; font-weight:bold;">Sebelum datang</p>
                        <p style="margin:0; font-size:14px; line-height:1.6; color:#3D3852;">
                            Gate dibuka pukul {{ $event['gate'] }}. Satu kode berlaku untuk semua tiket dalam pendaftaran ini,
                            jadi masuk bersama rombonganmu. Kode hanya bisa dipindai satu kali.
                        </p>
                        <p style="margin:20px 0 0;">
                            <a href="{{ route('register.success', $registration) }}"
                               style="display:inline-block; padding:12px 20px; font-size:14px; font-weight:bold; color:#1C1A2E; background:#FF7A33; border-radius:10px; text-decoration:none;">
                                Lihat e-tiket online
                            </a>
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="padding:18px 32px; background:#F1EDF8; font-size:12px; line-height:1.55; color:#625C78;">
                        Email ini dikirim otomatis karena alamat {{ $registration->email }} dipakai untuk mendaftar
                        {{ $event['name'] }}. Kalau kamu tidak merasa mendaftar, abaikan email ini.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
