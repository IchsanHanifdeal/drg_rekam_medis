<head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta property="og:url" content="https://...">
    <meta property="og:type" content="website">
    <meta property="og:title" content="....">
    <meta property="og:description" content="....">
    <meta property="og:image:width" content="470">
    <meta property="og:image:height" content="470">

    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="...">
    <meta property="twitter:url" content="https://...">
    <meta name="twitter:title" content="....">
    <meta name="twitter:description" content="....">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <title>{{ $title ?? 'Login' }} | Sioner Dental Clinic</title>
    <meta name="description" content="....">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
