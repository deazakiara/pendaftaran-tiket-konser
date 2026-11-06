<?php

// =============================================================
// Semua info konser ada di file ini.
// Mau ganti nama acara, tanggal, atau harga? Cukup edit di sini.
// =============================================================

return [
    'name' => 'Gema Senja Fest 2026',
    'tagline' => 'Dari matahari terbenam sampai lampu panggung terakhir padam.',
    'date' => 'Sabtu, 12 Desember 2026',
    'gate' => '15.00 WIB',
    'venue' => 'Amfiteater Terbuka, Taman Kota',

    'instructors' => [
        'Elizabeth Nathania' => 'elizabeth.nathania@ciputra.ac.id',
        'Haning Kumbara' => 'haning.kumbara@ciputra.ac.id',
    ],

    // Awalan kode tiket, hasilnya misal: GSF-7KQ2XM
    'code_prefix' => 'GSF',

    // Maksimal tiket dalam satu kali daftar
    'max_per_order' => 4,

    // Kategori tiket: 'kunci' => [nama, harga dalam rupiah, keterangan singkat]
    'tickets' => [
        'festival' => ['label' => 'Festival', 'price' => 350000, 'note' => 'Berdiri, paling dekat panggung'],
        'tribune' => ['label' => 'Tribune',  'price' => 500000, 'note' => 'Kursi bernomor di sisi tribun'],
        'vip' => ['label' => 'VIP',      'price' => 950000, 'note' => 'Lounge, jalur masuk khusus, merchandise'],
    ],
];
