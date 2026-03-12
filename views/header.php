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

        /* Active page navigation styling */
        .nav-active {
            background: #7c5176 !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(124, 81, 118, 0.3);
            transform: translateY(-1px);
            transition: all 0.3s ease;
        }

        .nav-active:hover {
            background: #8b6285 !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(124, 81, 118, 0.4);
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Page transition animation */
        .page-transition {
            animation: pageLoad 0.5s ease-out;
        }

        @keyframes pageLoad {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#2e2335] text-white h-screen relative page-transition">

    <div id="main-content" class="w-full h-20 p-6 transition-all duration-300">

        <header class="flex justify-between items-center mb-10">
            <div class="bg-[#453a4d] px-4 py-2 rounded text-gray-300 font-bold tracking-widest text-sm">LOGO</div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex flex-1">
                <div class="flex gap-3 px-8 items-center">
                    <div>
                        <a href="/home" class="bg-[#4d4d4d] px-4 py-2 rounded-full text-sm text-gray-300 <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' || $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/home' ? 'nav-active' : ''; ?>">กิจกรรมทั้งหมด</a>
                    </div>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <div>
                            <a href="/myJoinEvent" class="bg-[#4d4d4d] px-4 py-2 rounded-full text-sm text-gray-300 <?php echo strpos($_SERVER['REQUEST_URI'], '/myJoinEvent') !== false ? 'nav-active' : ''; ?>">กิจกรรมที่เข้าร่วม</a>
                        </div>
                        <div>
                            <a href="/myCreateEvent" class="bg-[#4d4d4d] px-4 py-2 rounded-full text-sm text-gray-300 <?php echo strpos($_SERVER['REQUEST_URI'], '/myCreateEvent') !== false ? 'nav-active' : ''; ?>">กิจกรรมที่สร้าง</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="bg-[#4d4d4d] p-2 rounded-lg text-gray-300">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
            
            <div class="hidden md:flex items-center gap-4">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-[#6b5b7a] rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-300 text-xs"></i>
                        </div>
                        <span class="text-gray-300 text-sm">สวัสดี, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                        <button onclick="window.location.href='/logout'" class="bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-1.5 rounded-full text-sm transition-colors">ออกจากระบบ</button>
                    </div>
                <?php else: ?>
                    <button onclick="window.location.href='/login'" class="bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-1.5 rounded-full text-sm transition-colors">เข้าสู่ระบบ</button>
                <?php endif; ?>
            </div>
        </header>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="fixed inset-0 bg-black/50 z-50 hidden">
            <div class="bg-[#2e2335] h-full w-80 max-w-[80vw] overflow-y-auto">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-6">
                        <div class="bg-[#453a4d] px-4 py-2 rounded text-gray-300 font-bold tracking-widest text-sm">LOGO</div>
                        <button onclick="toggleMobileMenu()" class="bg-[#4d4d4d] p-2 rounded-lg text-gray-300">
                            <i class="fa-solid fa-times text-lg"></i>
                        </button>
                    </div>
                    
                    <nav class="space-y-3">
                        <div>
                            <a href="/home" onclick="toggleMobileMenu()" class="block bg-[#4d4d4d] px-4 py-3 rounded-lg text-sm text-gray-300 hover:bg-[#5d5d5d] transition-colors <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' || $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/home' ? 'nav-active' : ''; ?>">
                                <i class="fa-solid fa-calendar mr-3"></i>กิจกรรมทั้งหมด
                            </a>
                        </div>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <div>
                                <a href="/myJoinEvent" onclick="toggleMobileMenu()" class="block bg-[#4d4d4d] px-4 py-3 rounded-lg text-sm text-gray-300 hover:bg-[#5d5d5d] transition-colors <?php echo strpos($_SERVER['REQUEST_URI'], '/myJoinEvent') !== false ? 'nav-active' : ''; ?>">
                                    <i class="fa-solid fa-user-check mr-3"></i>กิจกรรมที่เข้าร่วม
                                </a>
                            </div>
                            <div>
                                <a href="/myCreateEvent" onclick="toggleMobileMenu()" class="block bg-[#4d4d4d] px-4 py-3 rounded-lg text-sm text-gray-300 hover:bg-[#5d5d5d] transition-colors <?php echo strpos($_SERVER['REQUEST_URI'], '/myCreateEvent') !== false ? 'nav-active' : ''; ?>">
                                    <i class="fa-solid fa-plus-circle mr-3"></i>กิจกรรมที่สร้าง
                                </a>
                            </div>
                        <?php } ?>
                    </nav>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="mt-8 pt-8 border-t border-gray-600">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-[#6b5b7a] rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-user text-gray-300 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-gray-300 text-sm font-medium">สวัสดี</p>
                                    <p class="text-gray-400 text-xs"><?php echo htmlspecialchars($_SESSION['user']['name']); ?></p>
                                </div>
                            </div>
                            <button onclick="window.location.href='/logout'" class="w-full bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-3 rounded-lg text-sm transition-colors">
                                <i class="fa-solid fa-sign-out-alt mr-2"></i>ออกจากระบบ
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="mt-8 pt-8 border-t border-gray-600">
                            <button onclick="window.location.href='/login'" class="w-full bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-3 rounded-lg text-sm transition-colors">
                                <i class="fa-solid fa-sign-in-alt mr-2"></i>เข้าสู่ระบบ
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
            function toggleMobileMenu() {
                document.getElementById('mobileMenu').classList.toggle('hidden');
            }
        </script>
    </div>
</body>
</html>