<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model = "jembatan" antara kode PHP dan tabel registrations di database.
class Registration extends Model
{
    // Kolom yang boleh diisi lewat Registration::create([...])
    protected $fillable = [
        'ticket_code',
        'name',
        'email',
        'phone',
        'ticket_type',
        'quantity',
        'total_price',
        'email_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'email_sent_at' => 'datetime',
        ];
    }

    // URL tiket pakai kode tiket, bukan id. Hasilnya: /tiket/GSF-7KQ2XM
    public function getRouteKeyName(): string
    {
        return 'ticket_code';
    }

    // Nama kategori, misal "VIP"
    public function ticketLabel(): string
    {
        return config("konser.tickets.{$this->ticket_type}.label", $this->ticket_type);
    }

    // Total dalam format rupiah, misal "Rp 950.000"
    public function totalRupiah(): string
    {
        return 'Rp '.number_format($this->total_price, 0, ',', '.');
    }
}
