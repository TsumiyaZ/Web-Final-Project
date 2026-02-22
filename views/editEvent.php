<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&family=Oswald:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', sans-serif; }
        .font-oswald { font-family: 'Oswald', sans-serif; }
        
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
    </style>
</head>

<body class="bg-[#2e2335] text-white min-h-screen relative">

    <div id="main-content" class="w-full min-h-screen p-6 transition-all duration-300">

        <header class="flex justify-between items-center mb-10">
            <div class="bg-[#453a4d] px-4 py-1 rounded text-gray-300 font-bold tracking-widest text-sm">LOGO</div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="ค้นหากิจกรรม" class="bg-[#4d4d4d] text-gray-300 pl-4 pr-10 py-1.5 rounded-full text-sm focus:outline-none w-64">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="text-gray-300 text-sm">สวัสดี, <?= htmlspecialchars($_SESSION['user']['name']); ?></span>
                    <button onclick="window.location.href='/logout'" class="bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-1.5 rounded-full text-sm transition-colors">ออกจากระบบ</button>
                <?php else: ?>
                    <button onclick="openLogin()" class="bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-1.5 rounded-full text-sm transition-colors">เข้าสู่ระบบ</button>
                <?php endif; ?>
            </div>
        </header>

        <main class="relative">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"></div>

            <div id="edit-event" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md modal-gradient rounded-2xl p-8 shadow-2xl border border-white/10">
                    
                    <div class="absolute -top-12 left-0">
                        <a href="/createEvent" class="flex items-center gap-2 text-gray-300 hover:text-white transition-colors group">
                            <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                            <span class="font-medium">ย้อนกลับ</span>
                        </a>
                    </div>
 
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-oswald font-bold text-white tracking-wide uppercase">Edit Event</h1>
                        <p class="text-gray-400 text-sm mt-1">แก้ไขข้อมูลกิจกรรมของคุณ</p>
                    </div>

                    <form action="/updateEvent" method="POST" class="space-y-4">
                        <!-- เอาไอดีของ event มาใส่ใน input type hidden เพื่อส่งไปกับ form ด้วย -->
                        <input type="hidden" name="event_id" value="<?= htmlspecialchars($data['event']['event_id']) ?>">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-300 uppercase tracking-wider ml-1">ชื่ออีเว้นท์</label>
                            <input type="text" name="eventName" 
                                   value="<?= htmlspecialchars($data['event']['event_name']) ?>" 
                                   class="w-full px-4 py-2.5 rounded-xl custom-input text-white focus:ring-2 focus:ring-[#fff9c4]/20" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-300 uppercase tracking-wider ml-1">วันที่เริ่มงาน</label>
                                <input type="date" name="startDate" value="<?= htmlspecialchars($data['event']['start_date']) ?>" 
                                       class="w-full px-4 py-2.5 rounded-xl custom-input text-white" required>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-300 uppercase tracking-wider ml-1">วันที่เริ่มงาน</label>
                                <input type="date" name="stopDate" value="<?= htmlspecialchars($data['event']['stop_date']) ?>" 
                                       class="w-full px-4 py-2.5 rounded-xl custom-input text-white" required>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-300 uppercase tracking-wider ml-1">Description</label>
                            <textarea name="description" class="w-full px-4 py-4 rounded-xl custom-input text-white" required><?= htmlspecialchars($data['event']['description']) ?></textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-300 uppercase tracking-wider ml-1">จํากัดจํานวนคนเข้าร่วม</label>
                            <input type="number" name="amount" 
                                   value="<?= htmlspecialchars($data['event']['amount']) ?>" 
                                   class="w-full px-4 py-2.5 rounded-xl custom-input text-white focus:ring-2 focus:ring-[#fff9c4]/20" required>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-[#fffdd0] hover:bg-white text-[#2e2335] font-oswald font-bold text-lg py-3 rounded-xl shadow-xl transform active:scale-95 transition-all duration-200 uppercase tracking-widest">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div> <?php include 'footer.php'; ?>
</body>
</html>