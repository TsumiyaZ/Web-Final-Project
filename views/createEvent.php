<?php include 'header.php'; ?>

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

<main class="max-w-4xl mx-auto px-6 py-10">
    
    <div class="mb-8 flex items-center gap-4">
        <a href="javascript:history.back()" class="bg-white/20 hover:bg-white/40 w-10 h-10 flex items-center justify-center rounded-full transition-all">
            <i class="fa-solid fa-chevron-left text-white"></i>
        </a>
        <h1 class="text-3xl font-medium text-white tracking-wide">สร้างกิจกรรมใหม่</h1>
    </div>

    <div class="glass-container p-8 md:p-12 shadow-2xl">
        <form action="/createEvent" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <div>
                <label class="label-text">ชื่อกิจกรรม</label>
                <input type="text" name="nameEvent" placeholder="ระบุชื่อกิจกรรมของคุณ" 
                       class="custom-field text-lg" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label-text">วันที่เริ่มกิจกรรม</label>
                    <input type="date" name="startDate" class="custom-field" required>
                </div>
                <div>
                    <label class="label-text">วันที่สิ้นสุดกิจกรรม</label>
                    <input type="date" name="stopDate" class="custom-field" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label-text">รับจำนวน (คน)</label>
                    <input type="number" name="amount" placeholder="เช่น 100" 
                           class="custom-field" required>
                </div>
                <div>
                    <label class="label-text">รูปภาพกิจกรรม (เลือกได้หลายรูป)</label>
                    <input type="file" name="picture[]" accept="image/*" multiple 
                           class="custom-field custom-file-input text-sm" required>
                </div>
            </div>

            <div>
                <label class="label-text">รายละเอียดกิจกรรม</label>
                <textarea name="description" rows="5" placeholder="อธิบายกิจกรรมของคุณที่นี่..." 
                          class="custom-field resize-none"></textarea>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn-create w-full py-4 rounded-2xl font-semibold text-lg shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest">
                    ยืนยันการสร้างกิจกรรม
                </button>
            </div>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>