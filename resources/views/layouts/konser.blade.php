<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('konser.name'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;900&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ---------- Warna & font (ganti di sini kalau mau ubah tema) ---------- */
        :root {
            --night: #191C3D;
            --ember: #FF7A33;
            --ember-hover: #FF8F52;
            --paper: #FBF9FF;
            --ink: #1C1A2E;
            --muted: #625C78;
            --line: #DCD5EA;
            --tint: #F3EEFB;
            --error: #B4233F;
            --ground: #15122A;
            --display: 'Big Shoulders Display', Impact, 'Arial Narrow', sans-serif;
            --body: 'Onest', system-ui, -apple-system, 'Segoe UI', sans-serif;
        }

        * { box-sizing: border-box; }
        html, body { margin: 0; }

        body {
            min-height: 100vh;
            font-family: var(--body);
            font-size: 16px;
            line-height: 1.5;
            color: var(--paper);
            background-color: var(--night);
            /* langit senja */
            background-image: linear-gradient(180deg, #191C3D 0%, #2B2453 34%, #5E3160 62%, #C8503F 86%, #FF8A3D 100%);
        }

        /* ---------- Tata letak: poster kiri, tiket kanan ---------- */
        .page {
            --ground-h: 18vh;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 460px);
            gap: clamp(32px, 6vw, 96px);
            padding: clamp(32px, 6vw, 88px) clamp(20px, 6vw, 96px);
        }

        /* matahari terbenam + tanah */
        .sun {
            position: absolute;
            z-index: 0;
            left: clamp(20px, 8vw, 140px);
            bottom: var(--ground-h);
            width: min(30vw, 380px);
            aspect-ratio: 1;
            border-radius: 50%;
            background: radial-gradient(circle at 50% 38%, #FFE7B0 0%, #FFC067 40%, #FF7A33 80%);
            box-shadow: 0 0 120px 30px rgba(255, 138, 61, .35);
            transform: translateY(58%);
            animation: sunset 2.8s cubic-bezier(.2, .7, .2, 1) both;
        }
        @keyframes sunset {
            from { transform: translateY(28%); }
            to   { transform: translateY(58%); }
        }
        .ground {
            position: absolute;
            z-index: 1;
            left: 0; right: 0; bottom: 0;
            height: var(--ground-h);
            background: var(--ground);
            box-shadow: 0 -1px 0 rgba(255, 170, 110, .35);
        }

        /* ---------- Poster acara ---------- */
        .poster {
            position: relative;
            z-index: 2;
            align-self: start;
            max-width: 640px;
            text-shadow: 0 1px 14px rgba(25, 28, 61, .45);
        }
        .event-name {
            margin: 0;
            font-family: var(--display);
            font-weight: 900;
            font-size: clamp(3.75rem, 9vw, 8.75rem);
            line-height: .86;
            text-wrap: balance;
        }
        .tagline {
            margin: 20px 0 0;
            max-width: 34ch;
            font-size: 1.125rem;
            line-height: 1.55;
            color: #E6DAF3;
        }
        .event-info {
            display: flex;
            flex-wrap: wrap;
            gap: 16px 40px;
            margin: 32px 0 0;
        }
        .event-info dt { font-size: .875rem; color: #C3B4DB; }
        .event-info dd { margin: 2px 0 0; font-size: 1.0625rem; font-weight: 500; }

        /* ---------- Tiket (form) ---------- */
        .ticket-wrap {
            position: relative;
            z-index: 3;
            align-self: center;
            width: 100%;
        }
        .ticket {
            --notch: 14px;
            display: block;
            margin: 0;
            filter: drop-shadow(0 28px 48px rgba(12, 8, 32, .5));
        }
        .ticket-main,
        .ticket-stub {
            background: var(--paper);
            color: var(--ink);
        }
        /* lubang setengah lingkaran di batas sobekan tiket */
        .ticket-main {
            padding: 32px 32px 28px;
            border-radius: 22px 22px 0 0;
            -webkit-mask:
                radial-gradient(circle var(--notch) at 0 100%, #0000 98%, #000) left / 51% 100% no-repeat,
                radial-gradient(circle var(--notch) at 100% 100%, #0000 98%, #000) right / 51% 100% no-repeat;
                    mask:
                radial-gradient(circle var(--notch) at 0 100%, #0000 98%, #000) left / 51% 100% no-repeat,
                radial-gradient(circle var(--notch) at 100% 100%, #0000 98%, #000) right / 51% 100% no-repeat;
        }
        .ticket-stub {
            position: relative;
            padding: 24px 32px 30px;
            border-radius: 0 0 22px 22px;
            -webkit-mask:
                radial-gradient(circle var(--notch) at 0 0, #0000 98%, #000) left / 51% 100% no-repeat,
                radial-gradient(circle var(--notch) at 100% 0, #0000 98%, #000) right / 51% 100% no-repeat;
                    mask:
                radial-gradient(circle var(--notch) at 0 0, #0000 98%, #000) left / 51% 100% no-repeat,
                radial-gradient(circle var(--notch) at 100% 0, #0000 98%, #000) right / 51% 100% no-repeat;
        }
        /* garis putus-putus sobekan */
        .ticket-stub::before {
            content: "";
            position: absolute;
            top: -1px;
            left: calc(var(--notch) + 8px);
            right: calc(var(--notch) + 8px);
            border-top: 2px dashed var(--line);
        }

        .ticket h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.25;
        }
        .lead {
            margin: 8px 0 0;
            color: var(--muted);
            max-width: 40ch;
        }

        /* ---------- Isian form ---------- */
        .field { margin-top: 20px; }
        .field > label,
        .field > legend {
            display: block;
            margin-bottom: 6px;
            padding: 0;
            font-size: .9375rem;
            font-weight: 600;
        }
        fieldset.field { border: 0; padding: 0; min-width: 0; margin-left: 0; margin-right: 0; }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 12px 14px;
            font: inherit;
            color: var(--ink);
            background: #fff;
            border: 1.5px solid var(--line);
            border-radius: 12px;
        }
        input:focus-visible,
        select:focus-visible {
            outline: 3px solid rgba(255, 122, 51, .45);
            outline-offset: 1px;
            border-color: #E8601A;
        }
        [aria-invalid="true"] { border-color: var(--error); }

        .hint  { margin: 6px 0 0; font-size: .875rem; color: var(--muted); }
        .error { margin: 6px 0 0; font-size: .875rem; color: var(--error); font-weight: 500; }

        /* pilihan kategori tiket */
        .option-list {
            border: 1.5px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }
        .option {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            cursor: pointer;
            border-top: 1px solid var(--line);
        }
        .option:first-child { border-top: 0; }
        .option:has(input:checked) { background: var(--tint); }
        .option input {
            width: 18px;
            height: 18px;
            margin: 0;
            accent-color: #E8601A;
        }
        .option-name { display: block; font-weight: 600; }
        .option-note { display: block; font-size: .875rem; color: var(--muted); }
        .option-price { font-weight: 600; font-variant-numeric: tabular-nums; white-space: nowrap; }

        /* ---------- Bagian bawah tiket ---------- */
        .total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 16px;
            margin-bottom: 16px;
        }
        .total span { color: var(--muted); }
        .total output {
            font-family: var(--display);
            font-weight: 700;
            font-size: 2.25rem;
            line-height: 1;
            font-variant-numeric: tabular-nums;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px 20px;
            font: inherit;
            font-size: 1.0625rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            color: var(--ink);
            background: var(--ember);
            border: 0;
            border-radius: 14px;
            cursor: pointer;
        }
        .btn:hover { background: var(--ember-hover); }
        .btn:focus-visible { outline: 3px solid var(--night); outline-offset: 3px; }
        .btn[disabled] { opacity: .7; cursor: progress; }
        .btn-quiet {
            background: transparent;
            border: 1.5px solid var(--line);
        }
        .btn-quiet:hover { background: var(--tint); }

        /* ---------- Halaman bukti registrasi ---------- */
        .code {
            margin: 24px 0 4px;
            font-family: var(--display);
            font-weight: 900;
            font-size: clamp(2.75rem, 9vw, 3.75rem);
            line-height: 1;
            letter-spacing: .04em;
            color: var(--night);
        }
        .code-note { margin: 0; font-size: .875rem; color: var(--muted); }
        .details {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 10px 24px;
            margin: 24px 0 0;
        }
        .details dt { color: var(--muted); }
        .details dd { margin: 0; font-weight: 500; text-align: right; overflow-wrap: anywhere; }
        .notice { margin: 0 0 16px; line-height: 1.55; }
        .notice-error { color: var(--error); }
        .notice code {
            display: block;
            margin-top: 8px;
            padding: 10px 12px;
            font-size: .8125rem;
            color: var(--ink);
            background: var(--tint);
            border-radius: 8px;
            overflow-wrap: anywhere;
        }

        /* ---------- Layar HP ---------- */
        @media (max-width: 860px) {
            .page {
                --ground-h: 110px;
                grid-template-columns: 1fr;
                gap: 32px;
                padding: 32px 20px 230px;
            }
            .poster { max-width: none; }
            .event-name { font-size: clamp(3.25rem, 16vw, 5.5rem); }
            .event-info { margin-top: 24px; gap: 12px 28px; }
            .sun { left: 50%; width: 240px; margin-left: -120px; }
            .ticket-main { padding: 26px 22px 24px; }
            .ticket-stub { padding: 22px 22px 26px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .sun { animation: none; }
        }
    </style>
</head>
<body>
    <main class="page">
        <div class="sun" aria-hidden="true"></div>
        <div class="ground" aria-hidden="true"></div>

        <section class="poster" aria-label="Info konser">
            <h1 class="event-name">{{ config('konser.name') }}</h1>
            <p class="tagline">{{ config('konser.tagline') }}</p>
            <dl class="event-info">
                <div><dt>Tanggal</dt><dd>{{ config('konser.date') }}</dd></div>
                <div><dt>Open gate</dt><dd>{{ config('konser.gate') }}</dd></div>
                <div><dt>Lokasi</dt><dd>{{ config('konser.venue') }}</dd></div>
            </dl>
        </section>

        <section class="ticket-wrap">
            @yield('content')
        </section>
    </main>

    @stack('scripts')
</body>
</html>
