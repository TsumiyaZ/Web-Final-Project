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

<main class="max-w-6xl mx-auto glass-container p-4 md:p-6 lg:p-10 shadow-2xl mt-6 mb-12">

    <div class="mb-6 md:mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <button onclick="window.location.href='/myCreateEvent'" class="bg-white text-gray-800 px-4 md:px-5 py-1.5 rounded-full flex items-center gap-2 text-sm font-medium hover:bg-gray-100 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i> กลับไปยังกิจกรรม
        </button>
        <h2 class="text-lg md:text-xl font-medium tracking-wide">รายละเอียดการแก้ไข</h2>
    </div>

    <form action="/updateEvent" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
        <input type="hidden" name="event_id" value="<?= htmlspecialchars($data['event']['event_id'] ?? '') ?>">
        <input type="hidden" name="deleteImages" id="deleteImages" value="">

        <div class="space-y-2">
            <label class="block text-sm md:text-base font-light ml-2 text-gray-300">ชื่อกิจกรรม</label>
            <input type="text" name="eventName"
                value="<?= htmlspecialchars($data['event']['event_name'] ?? 'freefire') ?>"
                class="w-full px-4 md:px-6 py-3 md:py-4 custom-field text-base md:text-lg" required>
        </div>

        <div class="space-y-2">
            <label class="block text-sm md:text-base font-light ml-2 text-gray-300">รายละเอียด</label>
            <textarea name="description" rows="3 md:rows-4"
                class="w-full px-4 md:px-6 py-3 md:py-4 custom-field resize-none text-base md:text-lg" required><?= htmlspecialchars($data['event']['description'] ?? 'ฟีฟาย โดดร่มอย่างตึง') ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div class="space-y-2">
                <label class="block text-sm md:text-base font-light ml-2 text-gray-300">วันที่จัดกิจกรรม</label>
                <input type="datetime-local" id="startDate" name="startDate"
                    value="<?= htmlspecialchars($data['event']['start_date'] ?? '') ?>"
                    class="w-full px-4 md:px-6 py-3 md:py-4 custom-field text-base md:text-lg">
            </div>
            <div class="space-y-2">
                <label class="block text-sm md:text-base font-light ml-2 text-gray-300">วันที่สิ้นสุดกิจกรรม</label>
                <input type="datetime-local" id="stopDate" name="stopDate"
                    value="<?= htmlspecialchars($data['event']['stop_date'] ?? '') ?>"
                    class="w-full px-4 md:px-6 py-3 md:py-4 custom-field text-base md:text-lg">
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-sm md:text-base font-light ml-2 text-gray-300">รับจำนวน (คน)</label>
            <input type="number" name="amount"
                value="<?= htmlspecialchars($data['event']['amount'] ?? '1') ?>"
                class="w-full px-4 md:px-6 py-3 md:py-4 custom-field text-base md:text-lg">
        </div>

        <div class="">
            <div class="flex flex-col gap-2 m-2">
                <label class="label-text text-sm md:text-base">รูปภาพกิจกรรม (เลือกได้หลายรูป)</label>
                <input type="file" name="picture[]" accept="image/*" multiple
                    class="custom-field custom-file-input text-sm md:text-base py-3 md:py-4">
            </div>
            <div class="flex gap-2 ">
                <?php foreach (getImgByEventId($data['event']['event_id']) as $img) { ?>
                    <div class="flex flex-col">
                        <img src="<?= htmlspecialchars($img['img_path']) ?>" alt="Event Image" class="w-20 h-20 object-cover mb-2">
                        <button type="button" id="deleteImg_<?= $img['img_id'] ?>" class="btn-danger bg-green-600 rounded-xl w-full " onclick="selectImg(<?= $img['img_id'] ?>)">ลบ</button>
                        <button type="button" id="cancelImg_<?= $img['img_id'] ?>" class="btn-danger bg-red-600 rounded-xl w-full hidden" onclick="selectImg(<?= $img['img_id'] ?>)">ยกเลิก</button>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-end gap-3 md:gap-4 pt-6 md:pt-10">
            <button type="button" onclick="window.location.href='/myCreateEvent'" class="btn-cancel w-full md:w-auto px-6 md:px-12 py-2.5 rounded-full font-medium shadow-md hover:brightness-105 transition-all text-base md:text-lg">
                ยกเลิก
            </button>
            <button type="submit" id="btn-save" class="btn-save w-full md:w-auto px-6 md:px-12 py-2.5 rounded-full font-medium shadow-md hover:brightness-105 transition-all text-base md:text-lg">
                บันทึก
            </button>
        </div>
    </form>
</main>
<script>
    let selectDelData = []

    function selectImg(img_id) {
        const deleteBtn = document.getElementById('deleteImg_' + img_id);
        const cancelBtn = document.getElementById('cancelImg_' + img_id);

        if (selectDelData.includes(img_id)) {
            selectDelData.splice(selectDelData.indexOf(img_id), 1);
            deleteBtn.classList.remove('hidden');
            cancelBtn.classList.add('hidden');
        } else {
            selectDelData.push(img_id);
            deleteBtn.classList.add('hidden');
            cancelBtn.classList.remove('hidden');
        }
    }


    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('deleteImages').value = selectDelData.join(',');
    });
</script>

<?php include 'footer.php'; ?>