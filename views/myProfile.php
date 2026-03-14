<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ของฉัน</title>
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

        .toast.success {
            background: #4caf50;
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

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="page-transition">
    <div class="space-y-4 p-4 md:p-10 rounded-2xl bg-[#2e2335] h-[calc(100vh-120px)] md:h-[800px] overflow-y-auto custom-scrollbar">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">โปรไฟล์ของฉัน</h1>
        </div>

        <!-- Profile Card -->
        <div class="bg-white/5 backdrop-blur-md rounded-2xl border border-white/20 p-6 md:p-8 shadow-2xl">
            <div class="flex flex-col sm:flex-row gap-4 justify-start mb-8">
                <button type="button" onclick="window.location.href='/home'" class="bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 border border-white/20">
                    <i class="fa-solid fa-arrow-left mr-2"></i>กลับหน้าหลัก
                </button>
            </div>
            <!-- Profile Header -->
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-8">
                <div class="w-24 h-24 md:w-32 md:h-32 bg-gradient-to-br from-purple-600/50 to-pink-600/50 backdrop-blur-sm rounded-full flex items-center justify-center shadow-xl border border-white/20">
                    <i class="fa-solid fa-user text-4xl md:text-5xl text-white"></i>
                </div>
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">
                        <?php echo htmlspecialchars($data['user']['name'] ?? 'ผู้ใช้'); ?>
                    </h2>
                    <p class="text-gray-300 mb-2">
                        <i class="fa-solid fa-envelope mr-2"></i>
                        <?php echo htmlspecialchars($data['user']['email'] ?? 'email@example.com'); ?>
                    </p>
                    <p class="text-gray-300 mb-2">
                        <i class="fa-solid fa-birthday-cake mr-2"></i>
                        <?php 
                        $birthday = $data['user']['birthday'] ?? '';
                        if ($birthday && $birthday != '0000-00-00') {
                            echo date('d M Y', strtotime($birthday)) . ' (อายุ ' . getAge($birthday) . ' ปี)';
                        } else {
                            echo 'ไม่ระบุวันเกิด';
                        }
                        ?>
                    </p>
                    <p class="text-gray-300 mb-4">
                        <i class="fa-solid fa-venus-mars mr-2"></i>
                        <?php 
                        $gender = $data['user']['gender'] ?? '';
                        if ($gender == 'male') {
                            echo 'ชาย';
                        } elseif ($gender == 'female') {
                            echo 'หญิง';
                        } else {
                            echo 'ไม่ระบุเพศ';
                        }
                        ?>
                    </p>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="bg-purple-500/30 backdrop-blur-sm text-purple-300 px-3 py-1 rounded-full text-sm border border-purple-500/40">
                            <i class="fa-solid fa-star mr-1"></i>สมาชิก
                        </span>
                        <span class="bg-blue-500/30 backdrop-blur-sm text-blue-300 px-3 py-1 rounded-full text-sm border border-blue-500/40">
                            <i class="fa-solid fa-calendar mr-1"></i>เข้าร่วม: <?php echo date('d M Y', strtotime($data['user']['created_at'] ?? 'now')); ?>
                        </span>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white/5 backdrop-blur-sm rounded-xl border border-white/20 p-6 text-center">
                <div class="w-12 h-12 bg-blue-500/30 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-3 border border-blue-500/40">
                    <i class="fa-solid fa-calendar-check text-blue-400 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-1"><?php echo getAllUserJoinedEvent($_SESSION['user']['user_id']); ?></h3>
                <p class="text-gray-300 text-sm">กิจกรรมที่ได้เข้าร่วมเเล้ว</p>
            </div>
            <div class="bg-white/5 backdrop-blur-sm rounded-xl border border-white/20 p-6 text-center">
                <div class="w-12 h-12 bg-green-500/30 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-3 border border-green-500/40">
                    <i class="fa-solid fa-trophy text-green-400 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-1"><?php echo getMyAllCreateEvent($_SESSION['user']['user_id']); ?></h3>
                <p class="text-gray-300 text-sm">กิจกรรมที่สร้าง</p>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>