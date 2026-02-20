<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Modal UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&family=Oswald:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        .font-oswald {
            font-family: 'Oswald', sans-serif;
        }

        /* เพิ่ม CSS สำหรับการเบลอพื้นหลัง */
        .background-blur {
            filter: blur(8px);
            pointer-events: none;
            /* ป้องกันการคลิกเนื้อหาข้างหลังตอนเปิด Modal */
        }

        .modal-gradient {
            background: linear-gradient(135deg, #7c5176 0%, #4a304d 100%);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .custom-input {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid #9d7aa5;
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            outline: none;
            border-color: #fff9c4;
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* ตั้งค่าเริ่มต้นให้ Modal ซ่อนอยู่ */
        #modal-overlay {
            transition: opacity 0.3s ease;
            pointer-events: none;
            opacity: 0;
        }

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

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #453a4d;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #5a4d63;
        }
    </style>
</head>

<body class="bg-[#2e2335] text-white h-screen overflow-hidden relative">

    <div id="main-content" class="w-full h-full p-6 transition-all duration-300">

        <header class="flex justify-between items-center mb-10">
            <div class="bg-[#453a4d] px-4 py-1 rounded text-gray-300 font-bold tracking-widest text-sm">LOGO</div>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="ค้นหากิจกรรม" class="bg-[#4d4d4d] text-gray-300 pl-4 pr-10 py-1.5 rounded-full text-sm focus:outline-none w-64">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="text-gray-300 text-sm">สวัสดี, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                    <button onclick="window.location.href='/logout'" class="bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-1.5 rounded-full text-sm transition-colors">ออกจากระบบ</button>
                <?php else: ?>
                    <button onclick="openLogin()" class="bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-1.5 rounded-full text-sm transition-colors">เข้าสู่ระบบ</button>
                <?php endif; ?>
            </div>
        </header>

        <main>
            <div class="flex gap-3">
                <div class="mb-6">
                    <a href="/home" class="bg-[#4d4d4d] px-4 py-1 rounded-full text-sm text-gray-300">กิจกรรมทั้งหมด</a>
                </div>
                <?php if (isset($_SESSION['user'])) { ?>
                    <div class="mb-6">
                        <a href="/" class="bg-[#4d4d4d] px-4 py-1 rounded-full text-sm text-gray-300">กิจกรรมของฉัน</a>
                    </div>
                    <div class="mb-6">
                        <a href="/" class="bg-[#4d4d4d] px-4 py-1 rounded-full text-sm text-gray-300">กิจกรรมที่ขอเข้าร่วม</a>
                    </div>
                    <div class="mb-6">
                        <a href="/createEvent" class="bg-[#4d4d4d] px-4 py-1 rounded-full text-sm text-gray-300">กิจกรรมที่สร้าง</a>
                    </div>
                <?php } ?>
            </div>