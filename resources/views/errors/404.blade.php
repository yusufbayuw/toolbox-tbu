<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    
    <!-- Tailwind CSS for styling -->
    @vite('resources/css/app.css')
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Custom styles for the glitch effect */
        body {
            font-family: 'Poppins', sans-serif;
        }

        .glitch-text {
            position: relative;
            animation: glitch-skew 1s infinite linear alternate-reverse;
        }

        .glitch-text::before,
        .glitch-text::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #111827; /* Match the background color */
        }

        .glitch-text::before {
            left: 2px;
            text-shadow: -2px 0 #ef4444; /* Red shadow */
            clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
            animation: glitch-anim-1 1.5s infinite linear alternate-reverse;
        }

        .glitch-text::after {
            left: -2px;
            text-shadow: -2px 0 #3b82f6, 2px 2px #3b82f6; /* Blue shadow */
            clip-path: polygon(0 55%, 100% 55%, 100% 100%, 0 100%);
            animation: glitch-anim-2 1s infinite linear alternate-reverse;
        }

        /* Keyframe animations for the glitch effect */
        @keyframes glitch-anim-1 {
            0% { clip-path: polygon(0 2%, 100% 2%, 100% 33%, 0 33%); }
            25% { clip-path: polygon(0 40%, 100% 40%, 100% 45%, 0 45%); }
            50% { clip-path: polygon(0 60%, 100% 60%, 100% 80%, 0 80%); }
            75% { clip-path: polygon(0 15%, 100% 15%, 100% 25%, 0 25%); }
            100% { clip-path: polygon(0 50%, 100% 50%, 100% 55%, 0 55%); }
        }

        @keyframes glitch-anim-2 {
            0% { clip-path: polygon(0 67%, 100% 67%, 100% 80%, 0 80%); }
            25% { clip-path: polygon(0 25%, 100% 25%, 100% 40%, 0 40%); }
            50% { clip-path: polygon(0 80%, 100% 80%, 100% 95%, 0 95%); }
            75% { clip-path: polygon(0 45%, 100% 45%, 100% 60%, 0 60%); }
            100% { clip-path: polygon(0 10%, 100% 10%, 100% 30%, 0 30%); }
        }

        @keyframes glitch-skew {
            0% { transform: skew(0deg); }
            5% { transform: skew(1deg); }
            10% { transform: skew(-1deg); }
            15% { transform: skew(0deg); }
            /* Stay normal for the majority of the time */
            100% { transform: skew(0deg); }
        }
    </style>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen overflow-hidden">

    <div class="text-center p-8 w-full max-w-2xl">
        <!-- The main 404 text with the glitch effect -->
        <div 
            class="glitch-text text-8xl md:text-9xl font-black text-gray-100" 
            data-text="404">
            404
        </div>
        
        <!-- Subheading -->
        <h1 class="text-2xl md:text-4xl font-bold mt-8">Halaman Tidak Ditemukan</h1>
        
        <!-- Descriptive text -->
        <p class="text-gray-400 mt-4 text-base md:text-lg">
            Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin telah dipindahkan, dihapus, atau Anda salah mengetik alamat.
        </p>
        
        <!-- Call-to-action button -->
        <a href="/" 
           class="inline-block mt-10 px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 transition-transform transform hover:scale-105">
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>
