<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Download PDF</title>
    <script>
        window.onload = function() {
            const link = document.createElement('a');
            link.href = "{{ asset('storage/' . $filename) }}";
            link.download = "{{ $filename }}";
            link.click();

            // Redirect setelah 5 detik
            setTimeout(() => {
                window.location.href = "{{ route('laporan') }}";
            }, 5000);
        };
    </script>
</head>
<body>
    <p style="text-align:center; margin-top: 20px;">Sedang menyiapkan unduhan... Anda akan diarahkan kembali ke laporan.</p>
</body>
</html>
