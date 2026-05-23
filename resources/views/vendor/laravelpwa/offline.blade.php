<!DOCTYPE html>
<html lang="id" data-theme="retro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi Terputus | SDC Dental Clinic</title>
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #eae3cd;
            color: #333333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        .container {
            width: 100%;
            max-width: 480px;
            text-align: center;
            padding: 40px 30px;
            border-radius: 24px;
            background-color: #eae3cd;
            border: 2px solid #aa8f55;
            box-shadow: 0 20px 40px rgba(170, 143, 85, 0.15);
            position: relative;
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-wrapper {
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }

        .logo-img {
            width: 140px;
            height: auto;
            object-contain: contain;
            filter: drop-shadow(0 8px 16px rgba(170, 143, 85, 0.2));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            border: 2px dashed rgba(170, 143, 85, 0.3);
            border-radius: 50%;
            animation: spin 20s linear infinite;
            z-index: -1;
        }

        @keyframes spin {
            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            color: #aa8f55;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        p {
            font-size: 15px;
            line-height: 1.6;
            color: #555555;
            margin-bottom: 30px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            animation: pulse-dot 1.5s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.2);
                opacity: 1;
            }
        }

        .btn-retry {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px 28px;
            background-color: #aa8f55;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 12px rgba(170, 143, 85, 0.3);
            text-decoration: none;
        }

        .btn-retry:hover {
            background-color: #9a7e44;
            transform: scale(1.02);
            box-shadow: 0 6px 16px rgba(170, 143, 85, 0.4);
        }

        .btn-retry:active {
            transform: scale(0.98);
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888888;
            letter-spacing: 0.5px;
        }

        .offline-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            vertical-align: middle;
            margin-right: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-wrapper">
            <div class="pulse-ring"></div>
            <img src="/image/logo.png" alt="SDC Clinic Logo" class="logo-img" onerror="this.src='/images/icons/icon-192x192.png'">
        </div>

        <div class="status-badge">
            <span class="status-dot"></span>
            <span>Anda Sedang Offline</span>
        </div>

        <h1>Koneksi Terputus</h1>
        <p>Aplikasi gagal terhubung ke server. Periksa koneksi internet Anda atau coba muat kembali halaman saat perangkat Anda kembali online.</p>

        <button onclick="retryConnection()" class="btn-retry">
            <svg class="offline-icon" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/>
            </svg>
            Coba Lagi
        </button>

        <div class="footer">
            &copy; 2026 SDC DENTAL CLINIC. All rights reserved.
        </div>
    </div>

    <script>
        function retryConnection() {
            const btn = document.querySelector('.btn-retry');
            btn.innerHTML = 'Menghubungkan...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
            
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        // Listener otomatis bila internet menyala kembali
        window.addEventListener('online', function() {
            window.location.reload();
        });
    </script>
</body>
</html>