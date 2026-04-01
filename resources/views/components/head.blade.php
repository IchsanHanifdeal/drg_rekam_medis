<head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags for {{ $web_config->nama_klinik ?? 'SDC Dental Clinic' }} --}}
    <title>{{ $title ?? 'Beranda' }} | {{ $web_config->nama_klinik ?? 'SDC Dental Clinic' }}</title>
    <meta name="description" content="{{ $web_config->nama_klinik ?? 'SDC Dental Clinic' }} menyediakan layanan gigi profesional dan komprehensif, mulai dari pemeriksaan rutin hingga perawatan estetika dan implan gigi. Kunjungi kami untuk senyum sehat Anda!">
    <meta name="keywords" content="{{ $web_config->nama_klinik ?? 'SDC Dental Clinic' }}, dokter gigi, klinik gigi, perawatan gigi, pembersihan karang gigi, tambal gigi, cabut gigi, behel gigi, veneer gigi, implan gigi, kesehatan gigi">

    {{-- Open Graph / Social Media Meta Tags --}}
    <meta property="og:url" content="{{ url('/') }}"> {{-- Use url('/') for the base URL --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $web_config->nama_klinik ?? 'SDC Dental Clinic' }} - Perawatan Profesional">
    <meta property="og:description" content="Klinik terpercaya. {{ $web_config->nama_klinik ?? 'SDC Dental Clinic' }} memprioritaskan kesehatan dan perawatan Anda. Jadwalkan kunjungan Anda sekarang!">
    <meta property="og:image" content="{{ asset('image/social-share-image.jpg') }}"> {{-- Add a dedicated image for social sharing --}}
    <meta property="og:image:width" content="1200"> {{-- Recommended width for social media images --}}
    <meta property="og:image:height" content="630"> {{-- Recommended height for social media images --}}

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="{{ request()->getHost() }}">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="{{ $web_config->nama_klinik ?? 'SDC Dental Clinic' }} - Terbaik">
    <meta name="twitter:description" content="Dapatkan perawatan terbaik di {{ $web_config->nama_klinik ?? 'SDC Dental Clinic' }}. Senyum sehat dimulai di sini!">
    <meta name="twitter:image" content="{{ asset('image/social-share-image.jpg') }}"> {{-- Use the same social share image --}}

    {{-- Favicon --}}
    @php
        $rawFavicon = $web_config->favicon ?? 'favicon.ico';
        $faviconUrl = Str::startsWith($rawFavicon, 'images/settings') ? Storage::url($rawFavicon) : asset($rawFavicon);
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    
    {{-- Alpine.js for Odontogram interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
