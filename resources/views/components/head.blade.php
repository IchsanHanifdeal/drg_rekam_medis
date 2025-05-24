<head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags for SDC Dental Clinic --}}
    <title>{{ $title ?? 'Beranda' }} | SDC Dental Clinic</title>
    <meta name="description" content="SDC Dental Clinic Batusangkar menyediakan layanan gigi profesional dan komprehensif, mulai dari pemeriksaan rutin hingga perawatan estetika dan implan gigi. Kunjungi kami untuk senyum sehat Anda!">
    <meta name="keywords" content="SDC Dental Clinic, dokter gigi Batusangkar, klinik gigi Batusangkar, perawatan gigi, pembersihan karang gigi, tambal gigi, cabut gigi, behel gigi, veneer gigi, implan gigi, kesehatan gigi Batusangkar">

    {{-- Open Graph / Social Media Meta Tags --}}
    <meta property="og:url" content="{{ url('/') }}"> {{-- Use url('/') for the base URL --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="SDC Dental Clinic - Perawatan Gigi Profesional di Batusangkar">
    <meta property="og:description" content="Klinik gigi terpercaya di Batusangkar. SDC Dental Clinic menawarkan layanan lengkap untuk kesehatan dan estetika gigi Anda. Jadwalkan kunjungan Anda sekarang!">
    <meta property="og:image" content="{{ asset('image/social-share-image.jpg') }}"> {{-- Add a dedicated image for social sharing --}}
    <meta property="og:image:width" content="1200"> {{-- Recommended width for social media images --}}
    <meta property="og:image:height" content="630"> {{-- Recommended height for social media images --}}

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="{{ request()->getHost() }}">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="SDC Dental Clinic - Dokter Gigi Terbaik di Batusangkar">
    <meta name="twitter:description" content="Dapatkan perawatan gigi terbaik di SDC Dental Clinic Batusangkar. Ahli dalam scaling, filling, braces, dan banyak lagi. Senyum sehat dimulai di sini!">
    <meta name="twitter:image" content="{{ asset('image/social-share-image.jpg') }}"> {{-- Use the same social share image --}}

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="/manifest.json"> {{-- Ensure this path is correct if you have a PWA manifest --}}

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    {{-- CSS Libraries --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    {{-- Custom CSS (Vite) --}}
    @vite('resources/css/app.css')

    {{-- JavaScript Libraries (prefer moving non-critical ones to before </body> for faster FCP) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- Document/File Processing Libraries (consider if needed on every page, otherwise load on demand) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.50.0/docxtemplater.js"></script>
    <script crossorigin src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
    <script src="https://volodymyrbaydalka.github.io/docxjs/dist/docx-preview.min.js"></script>
    <script src="https://unpkg.com/pizzip@3.1.7/dist/pizzip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://unpkg.com/pizzip@3.1.7/dist/pizzip-utils.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.8.0/mammoth.browser.min.js"
        integrity="sha512-wuWo/cLB9W5BsZeyTYLuiTwr+FDlvjQC7C6atr+To7Jk92XHWI7WsImJZiruw7C9bnc8Zg7N0ncQI2Q/B4PQYw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>


    {{-- Custom JavaScript (Vite) --}}
    @vite('resources/js/app.js')
</head>
