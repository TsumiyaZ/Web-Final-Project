<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Login UI - Unique Style</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&family=Oswald:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #2e2335;
            --accent-pink: #f472b6;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Kanit', sans-serif;
            margin: 0;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- 1. Animated Mesh Gradient (พื้นหลังฟุ้งๆ ขยับได้) --- */
        .mesh-gradient {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -2;
            background: 
                radial-gradient(at 0% 0%, rgba(91, 55, 101, 0.5) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(244, 114, 182, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(91, 55, 101, 0.5) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(244, 114, 182, 0.15) 0px, transparent 50%);
            animation: meshMove 20s ease-in-out infinite alternate;
        }

        @keyframes meshMove {
            0% { transform: scale(1); }
            100% { transform: scale(1.1) rotate(2deg); }
        }

        /* --- 2. Cyberpunk Grid (เส้นตารางล้ำๆ) --- */
        .grid-overlay {
            position: fixed;
            inset: 0;
            z-index: -1;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(circle at center, black, transparent 90%);
        }

        /* แสงวิ่งผ่านตาราง (Scanline) */
        .scanline {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(244, 114, 182, 0.3), transparent);
            top: -10%;
            animation: scanMove 8s linear infinite;
        }

        @keyframes scanMove {
            0% { top: -10%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 110%; opacity: 0; }
        }

        /* --- 3. Glass Container (ธีมเดิมของคุณ) --- */
        .glass-container {
            background-color: rgba(139, 106, 150, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .custom-input {
            background-color: rgba(163, 140, 175, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-radius: 1.25rem;
            transition: all 0.3s ease;
            padding: 14px 18px;
            width: 100%;
        }

        .custom-input:focus {
            outline: none;
            background-color: rgba(163, 140, 175, 0.5);
            border-color: var(--accent-pink);
            box-shadow: 0 0 15px rgba(244, 114, 182, 0.2);
        }

        .btn-primary {
            background: #f5f5f7;
            color: #2e2335;
            border: none;
            border-radius: 1.25rem;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-primary:hover {
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Toast notification styles */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: #ff4d4d;
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            animation: slide 0.3s ease-out;
        }

        @keyframes slide {
            from {
                right: -100px;
                opacity: 0;
            }
            to {
                right: 20px;
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    <div class="mesh-gradient"></div>
    <div class="grid-overlay">
        <div class="scanline"></div>
    </div>

    <main class="w-full max-w-md px-4">
        <div class="glass-container p-8 md:p-10">
            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-oswald font-bold text-white tracking-widest uppercase italic">
                    Login
                </h1>
                <div class="h-1 w-12 bg-pink-500 mx-auto mt-2 rounded-full"></div>
            </div>

            <form action="/login" method="post" class="space-y-4">
                <div class="space-y-2">
                    <label class="text-xs font-semibold text-gray-300 uppercase tracking-widest ml-1">Email</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" placeholder="Email Address" class="custom-input pl-12" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-gray-300 uppercase tracking-widest ml-1">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" placeholder="Password" class="custom-input pl-12" required>
                    </div>
                </div>

                <div class="flex justify-between items-center px-1">
                    <a href="/register" class="text-xs text-pink-300 hover:text-white transition-colors underline decoration-pink-500/30">ยังไม่มีบัญชี?</a>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full btn-primary font-oswald text-lg py-4 uppercase tracking-widest">
                        เข้าสู่ระบบ
                    </button>
                </div>
            </form>

            <div class="text-center mt-10">
                <a href="/home" class="text-gray-500 hover:text-white text-sm transition-all duration-300 group">
                    <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> 
                    กลับไปหน้าหลัก
                </a>
            </div>
        </div>
    </main>

</body>
</html>

<?php include "footer.php" ?>