<?php 
// สมมติว่าไฟล์ header อยู่ในโฟลเดอร์เดียวกัน
include 'header.php'; 
?>

<style>
    /* เขียน Style ทับหรือเพิ่มเติมเพื่อให้ตรงกับภาพต้นฉบับ */
    body { 
        background: linear-gradient(to bottom right, #8e6b91, #c4a1c0) !important;
    }
    
    .glass-container {
        background-color: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .custom-field {
        background-color: #513952;
        border: none;
        color: #b5a4b7;
        border-radius: 1.25rem;
        transition: all 0.2s;
    }

    .custom-field:focus {
        outline: none;
        background-color: #5d425e;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
    }

    .btn-save { background-color: #fcf6d5; color: #4a334b; }
    .btn-cancel { background-color: #f9d3cf; color: #4a334b; }
</style>

<main class="max-w-6xl mx-auto glass-container p-6 md:p-10 shadow-2xl mt-6 mb-12">
    
    <div class="mb-8 flex items-center justify-between">
        <button onclick="history.back()" class="bg-white text-gray-800 px-5 py-1.5 rounded-full flex items-center gap-2 text-sm font-medium hover:bg-gray-100 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i> แก้ไขกิจกรรม
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
                <input type="date" name="startDate" 
                       value="<?= htmlspecialchars($data['event']['start_date'] ?? '') ?>" 
                       class="w-full px-6 py-3 custom-field">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-light ml-2">วันที่สิ้นสุดกิจกรรม</label>
                <input type="date" name="stopDate" 
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
            <button type="submit" class="btn-save px-12 py-2.5 rounded-full font-medium shadow-md hover:brightness-105 transition-all">
                บันทึก
            </button>
            <button type="button" onclick="history.back()" class="btn-cancel px-12 py-2.5 rounded-full font-medium shadow-md hover:brightness-105 transition-all">
                ยกเลิก
            </button>
        </div>
    </form>
</main>

<?php include 'footer.php'; ?>