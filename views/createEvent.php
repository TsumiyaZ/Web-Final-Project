<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างกิจกรรมใหม่</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&family=Oswald:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            background: #2e2335 !important;
            min-height: 100vh;
            font-family: 'Kanit', sans-serif;
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
<body class="page-transition">

<style>
    body { 
        background: #2e2335 !important;
        min-height: 100vh;
    }
    
    .glass-container {
        background-color: rgba(139, 106, 150, 0.3);
        backdrop-filter: blur(10px);
        border-radius: 2.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .custom-field {
        background-color: rgba(163, 140, 175, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
        border-radius: 1.25rem;
        transition: all 0.2s;
        width: 100%;
        padding: 0.75rem 1.5rem;
    }

    .custom-field:focus {
        outline: none;
        background-color: rgba(163, 140, 175, 0.5);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
    }

    .custom-field::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    /* สไตล์สำหรับ input file */
    .custom-file-input::-webkit-file-upload-button {
        background: #453a4d;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        margin-right: 1rem;
        cursor: pointer;
    }

    .btn-create { 
        background-color: #f5f5f7; 
        color: #5b3765;
        border: none;
    }
    
    .btn-create:hover {
        background-color: #ffffff;
        transform: scale(1.02);
    }
    
    .label-text {
        color: #f3eff3;
        margin-left: 0.5rem;
        margin-bottom: 0.4rem;
        display: block;
        font-weight: 300;
        font-size: 0.9rem;
    }
</style>

<main class="max-w-4xl mx-auto px-4 md:px-6 py-6 md:py-10">
    
    <div class="mb-6 md:mb-8 flex flex-col md:flex-row items-start md:items-center gap-4">
        <a href="javascript:history.back()" class="bg-white/20 hover:bg-white/40 w-10 h-10 flex items-center justify-center rounded-full transition-all">
            <i class="fa-solid fa-chevron-left text-white"></i>
        </a>
        <h1 class="text-2xl md:text-3xl font-medium text-white tracking-wide">สร้างกิจกรรมใหม่</h1>
    </div>

    <div class="glass-container p-6 md:p-8 lg:p-12 shadow-2xl">
        <form action="/createEvent" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
            <div>
                <label class="label-text text-sm md:text-base">ชื่อกิจกรรม</label>
                <input type="text" name="nameEvent" placeholder="ระบุชื่อกิจกรรมของคุณ" 
                       class="custom-field text-base md:text-lg py-3 md:py-4" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                    <label class="label-text text-sm md:text-base">วันที่เริ่มกิจกรรม</label>
                    <input type="datetime-local" name="startDate" id="startDate" class="custom-field py-3 md:py-4" required>
                </div>
                <div>
                    <label class="label-text text-sm md:text-base">วันที่สิ้นสุดกิจกรรม</label>
                    <input type="datetime-local" name="stopDate" id="stopDate" class="custom-field py-3 md:py-4" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                    <label class="label-text text-sm md:text-base">รับจำนวน (คน)</label>
                    <input type="number" name="amount" min="1" max="9999999" placeholder="เช่น 100" 
                           class="custom-field py-3 md:py-4" required>
                </div>
                <div >
                    <label class="label-text text-sm md:text-base w-auto">รูปภาพกิจกรรม (เลือกได้หลายรูป png, jpg, jpeg) ไม่เกิน 2MB</label>
                    <input type="file" name="picture[]" accept="image/*" multiple 
                           class="custom-field custom-file-input text-sm md:text-base py-3 md:py-4" required>
                </div>
            </div>

            <div>
                <label class="label-text text-sm md:text-base">รายละเอียดกิจกรรม</label>
                <textarea name="description" rows="4" placeholder="อธิบายกิจกรรมของคุณที่นี่..." 
                          class="custom-field resize-none py-3 md:py-4" required></textarea>
            </div>

            <div class="pt-4 md:pt-6">
                <button type="submit" id="btn-create" class="btn-create w-full py-3 md:py-4 rounded-2xl font-semibold text-base md:text-lg shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest">
                    ยืนยันการสร้างกิจกรรม
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDate = document.getElementById('startDate');
        const stopDate = document.getElementById('stopDate');
        const submitBtn = document.getElementById('btn-create');

        function validateDates() {
            const start = new Date(startDate.value);
            const stop = new Date(stopDate.value);
            
            if (startDate.value && stopDate.value) {
                if (start >= stop) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'วันเริ่มต้องน้อยกว่าวันสิ้นสุด';
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'ยืนยันการสร้างกิจกรรม';
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        startDate.addEventListener('change', validateDates);
        stopDate.addEventListener('change', validateDates);
    });
</script>

<?php include 'footer.php'; ?>