<?php include 'header.php'; ?>

<style>
    body {
        background: #2e2335 !important;
        font-family: 'Kanit', sans-serif;
    }

    .glass-container {
        background-color: rgba(139, 106, 150, 0.3);
        backdrop-filter: blur(10px);
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .custom-input {
        background-color: rgba(163, 140, 175, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
        border-radius: 1.25rem;
        transition: all 0.2s;
        padding: 12px 16px;
        width: 100%;
    }

    .custom-input:focus {
        outline: none;
        background-color: rgba(163, 140, 175, 0.5);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
    }

    .btn-primary {
        background-color: #f5f5f7;
        color: #5b3765;
        border: none;
        border-radius: 1rem;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background-color: #ffffff;
        transform: scale(1.02);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
</style>

<main class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md glass-container p-8 shadow-2xl">
        <div class="text-center mb-6">
            <h1 class="text-4xl font-oswald font-bold text-white tracking-wide mb-2 uppercase">Sign Up</h1>
            <p class="text-sm text-gray-300">
                Already have an account? <a href="/login" class="text-[#fff9c4] hover:text-white font-medium">Log in</a>
            </p>
        </div>

        <form action="/register" method="post" class="space-y-4">
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-200 block ml-1">Username</label>
                <input type="text" name="username" placeholder="Username" class="custom-input" required>
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-200 block ml-1">Email</label>
                <input type="email" name="email" placeholder="Email" class="custom-input" required>
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-200 block ml-1">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" class="custom-input" required>
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-200 block ml-1">Confirm Password</label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" class="custom-input" required>
                <p id="password-error" class="text-xs text-red-400 mt-1 hidden">รหัสผ่านไม่ตรงกัน</p>
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-200 block ml-1">Date of birth</label>
                <input type="text" name="birthday" placeholder="yy/mm/dd" class="custom-input" onfocus="(this.type='date')">
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-200 block ml-1">Gender</label>
                <select name="gender" class="custom-input text-gray-400 focus:text-white appearance-none cursor-pointer">
                    <option class="text-black" value="" disabled selected>เลือกรายการ</option>
                    <option class="text-black" value="male">Male</option>
                    <option class="text-black" value="female">Female</option>
                    <option class="text-black" value="other">Other</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit" id="sign-up" class="w-full btn-primary font-oswald font-bold text-xl py-3 rounded-full shadow-lg transform active:scale-95 transition-all duration-200 uppercase tracking-wider">
                    Sign Up
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="/home" class="text-gray-400 hover:text-white text-sm">
                <i class="fa-solid fa-arrow-left mr-1"></i> กลับไปหน้าหลัก
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

<?php include 'footer.php'; ?>
