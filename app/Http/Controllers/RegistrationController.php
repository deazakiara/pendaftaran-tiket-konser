<?php

namespace App\Http\Controllers;

use App\Mail\TicketConfirmation;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    // GET /  -> tampilkan halaman form
    public function create()
    {
        return view('register', [
            'tickets' => config('konser.tickets'),
            'maxPerOrder' => config('konser.max_per_order'),
            'instructors' => config('konser.instructors'),
        ]);
    }

    // POST /daftar  -> proses data yang dikirim dari form
    public function store(Request $request)
    {
        $tickets = config('konser.tickets');
        $max = config('konser.max_per_order');

        // 1. Cek isian form. Kalau ada yang salah, Laravel otomatis
        //    kembali ke form dan menampilkan pesan error di bawah kolomnya.
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'ticket_type' => ['required', Rule::in(array_keys($tickets))],
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$max],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email belum benar, contoh: nama@gmail.com',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.regex' => 'Nomor HP hanya boleh angka, spasi, + atau -, minimal 8 digit.',
            'ticket_type.required' => 'Pilih salah satu kategori tiket.',
            'ticket_type.in' => 'Kategori tiket tidak dikenal.',
            'quantity.required' => 'Pilih jumlah tiket.',
            'quantity.integer' => 'Jumlah tiket harus angka.',
            'quantity.min' => 'Minimal 1 tiket.',
            'quantity.max' => 'Maksimal '.$max.' tiket per pendaftaran.',
        ]);

        // 2. Hitung total harga dan buat kode tiket
        $data['total_price'] = $tickets[$data['ticket_type']]['price'] * $data['quantity'];
        $data['ticket_code'] = $this->generateTicketCode();

        // 3. Simpan ke database
        $registration = Registration::create($data);

        // 4. Kirim email konfirmasi ke alamat yang diisi di form
        try {
            Mail::to($registration->email)->send(new TicketConfirmation($registration));
            $registration->update(['email_sent_at' => now()]);
        } catch (\Throwable $e) {
            report($e); // detail error dicatat di storage/logs/laravel.log

            return redirect()
                ->route('register.success', $registration)
                ->with('mail_error', $e->getMessage());
        }

        // 5. Pindah ke halaman bukti registrasi
        return redirect()->route('register.success', $registration);
    }

    // GET /tiket/{kode}  -> halaman bukti registrasi
    public function success(Registration $registration)
    {
        return view('success', ['registration' => $registration]);
    }

    // Membuat kode unik seperti GSF-7KQ2XM.
    // Huruf/angka yang mirip (O dan 0, I dan 1) sengaja tidak dipakai
    // supaya kode gampang dibaca petugas di pintu masuk.
    private function generateTicketCode(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        do {
            $random = '';
            for ($i = 0; $i < 6; $i++) {
                $random .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $code = config('konser.code_prefix').'-'.$random;
        } while (Registration::where('ticket_code', $code)->exists());

        return $code;
    }
}
