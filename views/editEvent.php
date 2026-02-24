<?php 
// สมมติว่าไฟล์ header อยู่ในโฟลเดอร์เดียวกัน
include 'header.php'; 
?>

<style>
    body { 
        background: #2e2335 !important;
    }
    
    .glass-container {
        background-color: rgba(139, 106, 150, 0.3);
        backdrop-filter: blur(10px);
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .custom-field {
        background-color: rgba(163, 140, 175, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
        border-radius: 1.25rem;
        transition: all 0.2s;
    }

    .custom-field:focus {
        outline: none;
        background-color: rgba(163, 140, 175, 0.5);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
    }

    .btn-save { 
        background-color: #f5f5f7; 
        color: #5b3765;
        border: none;
    }
    
    .btn-save:hover {
        background-color: #ffffff;
        transform: scale(1.02);
    }
    
    .btn-cancel { 
        background-color: #f9d3cf; 
        color: #4a334b;
        border: none;
    }
    
    .btn-cancel:hover {
        transform: scale(1.02);
    }
</style>

<main class="max-w-6xl mx-auto glass-container p-6 md:p-10 shadow-2xl mt-6 mb-12">
    
    <div class="mb-8 flex items-center justify-between">
        <button onclick="window.location.href='/myCreateEvent'" class="bg-white text-gray-800 px-5 py-1.5 rounded-full flex items-center gap-2 text-sm font-medium hover:bg-gray-100 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i> กลับไปยังกิจกรรม
        </button>
        <h2 class="text-xl font-medium tracking-wide">รายละเอียดการแก้ไข</h2>
    </div>

    <form action="/updateEvent" method="POST" class="space-y-6">
        <input type="hidden" name="event_id" value="<?= htmlspecialchars($data['event']['event_id'] ?? '') ?>">

        <div class="space-y-2">
            <label class="block text-sm font-light ml-2">ชื่อกิจกรรม</label>
            <input type="text" name="eventName" 
                   value="<?= htmlspecialchars($data['event']['event_name'] ?? 'freefire') ?>" 
                   class="w-full px-6 py-3 custom-field" required>
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-light ml-2">รายละเอียด</label>
            <textarea name="description" rows="4" 
                      class="w-full px-6 py-4 custom-field resize-none" required><?= htmlspecialchars($data['event']['description'] ?? 'ฟีฟาย โดดร่มอย่างตึง') ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-light ml-2">วันที่จัดกิจกรรม</label>
                <input type="datetime-local" id="startDate" name="startDate" 
                       value="<?= htmlspecialchars($data['event']['start_date'] ?? '') ?>" 
                       class="w-full px-6 py-3 custom-field">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-light ml-2">วันที่สิ้นสุดกิจกรรม</label>
                <input type="datetime-local" id="stopDate" name="stopDate" 
                       value="<?= htmlspecialchars($data['event']['stop_date'] ?? '') ?>" 
                       class="w-full px-6 py-3 custom-field">
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-light ml-2">รับจำนวน (คน)</label>
            <input type="number" name="amount" 
                   value="<?= htmlspecialchars($data['event']['amount'] ?? '1') ?>" 
                   class="w-full px-6 py-3 custom-field">
        </div>

        <div class="flex justify-end gap-4 pt-10">
            <button type="submit" id="btn-save" class="btn-save px-12 py-2.5 rounded-full font-medium shadow-md hover:brightness-105 transition-all">
                บันทึก
            </button>
            <button type="button" onclick="window.location.href='/myCreateEvent'" class="btn-cancel px-12 py-2.5 rounded-full font-medium shadow-md hover:brightness-105 transition-all">
                ยกเลิก
            </button>
        </div>
    </form>
</main>

<?php include 'footer.php'; ?>