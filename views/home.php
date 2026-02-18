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
            <div class="mb-6">
                <span class="bg-[#4d4d4d] px-4 py-1 rounded-full text-sm text-gray-300">กิจกรรมทั้งหมด</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#352b3d] p-4 rounded-xl shadow-lg border border-[#453a4d] opacity-80">
                    <div class="h-32 bg-[#453a4d] rounded-lg mb-4 w-full"></div>
                    <div class="space-y-2">
                        <div class="h-3 bg-[#453a4d] rounded w-full"></div>
                        <div class="h-3 bg-[#453a4d] rounded w-3/4"></div>
                    </div>
                </div>
                <div class="bg-[#352b3d] p-4 rounded-xl shadow-lg border border-[#453a4d] opacity-80">
                    <div class="h-32 bg-[#453a4d] rounded-lg mb-4 w-full"></div>
                    <div class="space-y-2">
                        <div class="h-3 bg-[#453a4d] rounded w-full"></div>
                        <div class="h-3 bg-[#453a4d] rounded w-3/4"></div>
                    </div>
                </div>
                <div class="bg-[#352b3d] p-4 rounded-xl shadow-lg border border-[#453a4d] opacity-80">
                    <div class="h-32 bg-[#453a4d] rounded-lg mb-4 w-full"></div>
                    <div class="space-y-2">
                        <div class="h-3 bg-[#453a4d] rounded w-full"></div>
                        <div class="h-3 bg-[#453a4d] rounded w-3/4"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-overlay" class="fixed inset-0 z-50 flex items-center justify-center p-4">

        <div class="relative w-full max-w-md modal-gradient rounded-xl p-8 pt-10 shadow-2xl">

            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-300 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="text-center mb-8">
                <h1 class="text-5xl font-oswald font-bold text-white tracking-wide mb-2 uppercase">Log In</h1>
                <p class="text-sm text-gray-300">
                    Don't have an account? <a onclick="switchToSignup()" class="text-[#fff9c4] hover:text-white font-medium">Sign up</a>
                </p>
            </div>

            <form action="/login" method="post" class="space-y-5">
                <div class="space-y-1">
                    <label for="email" class="text-sm font-medium text-gray-200 block ml-1">Email</label>
                    <input type="email" name="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg custom-input text-white" required>
                </div>

                <div class="space-y-1">
                    <label for="password" class="text-sm font-medium text-gray-200 block ml-1">Password</label>
                    <input type="password" name="password" placeholder="Password" class="w-full px-4 py-3 rounded-lg custom-input text-white" required>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#fffdd0] hover:bg-[#fff9c4] text-[#2e2335] font-oswald font-bold text-xl py-3 rounded-full shadow-lg transform active:scale-95 transition-all duration-200 uppercase tracking-wider">
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="signup-modal-overlay" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="transition: opacity 0.3s ease; pointer-events: none; opacity: 0;">
        <div class="relative w-full max-w-md modal-gradient rounded-xl p-8 pt-10 shadow-2xl">
            <button onclick="closeSignup()" class="absolute top-4 right-4 text-gray-300 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <div class="text-center mb-6">
                <h1 class="text-5xl font-oswald font-bold text-white tracking-wide mb-2 uppercase">Sign Up</h1>
                <p class="text-sm text-gray-300">
                    Already have an account? <a onclick="switchToLogin()" class="text-[#fff9c4] hover:text-white font-medium">Log in</a>
                </p>
            </div>

            <form action="/register" method="post" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-200 block ml-1">Username</label>
                    <input type="text" name="username" placeholder="Username" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" required>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-200 block ml-1">Email</label>
                    <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" required>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-200 block ml-1">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" required>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-200 block ml-1">Confirm-Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm-Password" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" required>
                    <p id="password-error" class="text-xs text-red-400 mt-1 hidden">รหัสผ่านไม่ตรงกัน</p>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-200 block ml-1">Date of birth</label>
                    <input type="text" name="birthday" placeholder="yy/mm/dd" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" onfocus="(this.type='date')">
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-200 block ml-1">Gender</label>
                    <select name="gender" class="w-full px-4 py-2.5 rounded-lg custom-input text-gray-400 focus:text-white appearance-none cursor-pointer">
                        <option class="text-black" value="" disabled selected>เลือกรายการ</option>
                        <option class="text-black" value="male">Male</option>
                        <option class="text-black" value="female">Female</option>
                        <option class="text-black" value="other">Other</option>
                    </select>
                </div>

                <div class="pt-4">
                    <button type="submit" id="sign-up" class="w-full bg-[#fffdd0] hover:bg-[#fff9c4] text-[#2e2335] font-oswald font-bold text-xl py-3 rounded-full shadow-lg transform active:scale-95 transition-all duration-200 uppercase tracking-wider">
                        Sign Up
                    </button>
                </div>
            </form>
        </div>
    </div>



    <script>
        const modalOverlay = document.getElementById('modal-overlay');
        const mainContent = document.getElementById('main-content');

        const password = document.getElementById('password');
        const conPassword = document.getElementById('confirm-password');
        const errorText = document.getElementById('password-error');
        const signUp = document.getElementById('sign-up');

        function openLogin() {
            modalOverlay.style.opacity = '1';
            modalOverlay.style.pointerEvents = 'auto';
            mainContent.classList.add('background-blur');
        }

        function closeModal() {
            modalOverlay.style.opacity = '0';
            modalOverlay.style.pointerEvents = 'none';
            mainContent.classList.remove('background-blur');
        }

        function notify(msg, type = 'error') {
            if (!msg) return;
            const div = document.createElement('div');

            if (type == 'success') {
                div.style.background = '#2ecc71';
            } else {
                div.style.background = '#ff4d4d';
            }

            div.className = 'toast';
            div.innerHTML = `<i class="fa-solid fa-circle-exclamation mr-2"></i> ${msg}`;
            document.body.appendChild(div);

            setTimeout(() => div.remove(), 3000);
        }


        const signupOverlay = document.getElementById('signup-modal-overlay');

        function openSignup() {
            signupOverlay.style.opacity = '1';
            signupOverlay.style.pointerEvents = 'auto';
            mainContent.classList.add('background-blur');
        }

        function closeSignup() {
            signupOverlay.style.opacity = '0';
            signupOverlay.style.pointerEvents = 'none';
            mainContent.classList.remove('background-blur');
        }

        function switchToSignup() {
            closeModal(); 
            setTimeout(openSignup, 100);
        }

        function switchToLogin() {
            closeSignup();
            setTimeout(openLogin, 100);
        }

        function checkConfirmPassword() {
            if (conPassword.value === '') {
                errorText.classList.add('hidden');
                signUp.disabled = false;

                signUp.style.opacity = '1';
                signUp.style.cursor = 'pointer'; 
                return;
            }

            if (conPassword.value !== password.value) {
                errorText.classList.remove('hidden');
                signUp.disabled = true;
                signUp.style.opacity = '0.5';
                signUp.style.cursor = 'not-allowed'; 
            } else {
                errorText.classList.add('hidden');
                signUp.disabled = false;
                signUp.style.opacity = '1';
                signUp.style.cursor = 'pointer'; 
            }
        }

        password.addEventListener('input', checkConfirmPassword);
        conPassword.addEventListener('input', checkConfirmPassword);
    </script>

    <?php if (!empty($_SESSION['error'])): ?>
        <script>
            notify("<?php echo $_SESSION['error']; ?>", 'error');
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <script>
            notify("<?php echo $_SESSION['success']; ?>", 'success');
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
</body>

</html>