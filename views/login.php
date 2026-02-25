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
</style>

<main class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md glass-container p-8 shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-oswald font-bold text-white tracking-wide mb-2 uppercase">Log In</h1>
            <p class="text-sm text-gray-300">
                Don't have an account? <a href="/register" class="text-[#fff9c4] hover:text-white font-medium">Sign up</a>
            </p>
        </div>

        <form action="/login" method="post" class="space-y-5">
            <div class="space-y-1">
                <label for="email" class="text-sm font-medium text-gray-200 block ml-1">Email</label>
                <input type="email" name="email" placeholder="Email" class="custom-input" required>
            </div>

            <div class="space-y-1">
                <label for="password" class="text-sm font-medium text-gray-200 block ml-1">Password</label>
                <input type="password" name="password" placeholder="Password" class="custom-input" required>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full btn-primary font-oswald font-bold text-xl py-3 rounded-full shadow-lg transform active:scale-95 transition-all duration-200 uppercase tracking-wider">
                    Log In
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

<?php include 'footer.php'; ?>
