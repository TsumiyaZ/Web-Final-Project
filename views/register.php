<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Unique Style</title>
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
            /* ปรับให้เลื่อนได้เฉพาะแนวตั้งหากเนื้อหายาวกว่าจอ (สำหรับมือถือ) */
            overflow-x: hidden;
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        /* --- 1. Background Layers --- */
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

        /* --- 2. Container & Inputs --- */
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
            padding: 12px 18px;
            width: 100%;
        }

        .custom-input:focus {
            outline: none;
            background-color: rgba(163, 140, 175, 0.5);
            border-color: var(--accent-pink);
            box-shadow: 0 0 15px rgba(244, 114, 182, 0.2);
        }

        /* สำหรับ Select ปรับลูกศร */
        select.custom-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.2rem;
        }

        .btn-primary {
            background: #f5f5f7;
            color: #2e2335;
            border: none;
            border-radius: 1.25rem;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-primary:hover:not(:disabled) {
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

    <div class="mesh-gradient"></div>
    <div class="grid-overlay">
        <div class="scanline"></div>
    </div>

    <main class="w-full max-w-lg px-4 my-8">
        <div class="glass-container p-8 md:p-10">
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-oswald font-bold text-white tracking-widest uppercase italic">
                    สมัครสมาชิก   
                </h1>
                <p class="text-xs md:text-sm text-gray-400 mt-2">
                    มีบัญชีเเล้ว? <a href="/login" class="text-pink-400 hover:text-white font-medium">Log in</a>
                </p>
                <div class="h-1 w-12 bg-pink-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <form action="/register" method="post" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-300 uppercase tracking-widest ml-1">Username</label>
                        <input type="text" name="username" placeholder="User123" class="custom-input" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-300 uppercase tracking-widest ml-1">Email</label>
                        <input type="email" name="email" placeholder="example@mail.com" class="custom-input" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-300 uppercase tracking-widest ml-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="custom-input" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-300 uppercase tracking-widest ml-1">Confirm</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="••••••••" class="custom-input" required>
                    </div>
                </div>
                <p id="password-error" class="text-xs text-red-400 mt-1 hidden text-center">รหัสผ่านไม่ตรงกัน</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-300 uppercase tracking-widest ml-1">Birthday</label>
                        <input type="text" name="birthday" placeholder="yy/mm/dd" class="custom-input" onfocus="(this.type='date')">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-300 uppercase tracking-widest ml-1">Gender</label>
                        <select name="gender" class="custom-input text-gray-400 focus:text-white cursor-pointer">
                            <option value="" disabled selected>เลือกรายการ</option>
                            <option value="male" class="text-black">Male</option>
                            <option value="female" class="text-black">Female</option>
                            <option value="other" class="text-black">Other</option>
                        </select>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" id="sign-up" class="w-full btn-primary font-oswald text-lg py-4 uppercase tracking-widest shadow-lg">
                        สมัครสมาชิก
                    </button>
                </div>
            </form>

            <div class="text-center mt-8">
                <a href="/login" class="text-gray-500 hover:text-white text-sm transition-all duration-300 group">
                    <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> 
                    กลับไปหน้าเข้าสู่ระบบ
                </a>
            </div>
        </div>
    </main>

    <script>
        const password = document.getElementById('password');
        const conPassword = document.getElementById('confirm-password');
        const errorText = document.getElementById('password-error');
        const signUp = document.getElementById('sign-up');

        function checkConfirmPassword() {
            if (conPassword.value === '') {
                errorText.classList.add('hidden');
                signUp.disabled = false;
                return;
            }

            if (conPassword.value !== password.value) {
                errorText.classList.remove('hidden');
                signUp.disabled = true;
            } else {
                errorText.classList.add('hidden');
                signUp.disabled = false;
            }
        }

        password.addEventListener('input', checkConfirmPassword);
        conPassword.addEventListener('input', checkConfirmPassword);
    </script>

</body>
</html>