<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&family=Oswald:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: #2e2335 !important;
            font-family: 'Kanit', sans-serif;
        }

        /* Toast notification styles */
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

        /* Page transition animation */
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

        .glass-container {
            background: linear-gradient(135deg, rgba(139, 106, 150, 0.25) 0%, rgba(124, 81, 118, 0.15) 100%);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 
                        0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            overflow: hidden;
        }

        .glass-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        /* ส่วนของรูปภาพฝั่งซ้าย */
        .event-image-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: 1.5rem;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .event-image-main {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .event-image-main:hover {
            transform: scale(1.05);
        }

        .image-dots {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 20px;
        }

        .dot {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .dot:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: scale(1.2);
        }

        .dot.active {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5),
                        0 2px 8px rgba(0, 0, 0, 0.3);
            transform: scale(1.3);
        }

        /* ข้อความหลัก */
        .event-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            letter-spacing: 2px;
            text-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
        }

        .event-meta {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .participant-badge {
            background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
            color: #2e2335;
            padding: 8px 24px;
            border-radius: 25px;
            display: inline-block;
            font-weight: 700;
            margin-top: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3),
                        0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .participant-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .participant-badge:hover::before {
            left: 100%;
        }

        .participant-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4),
                        0 0 0 1px rgba(255, 255, 255, 0.2) inset;
        }

        /* รายละเอียดด้านล่าง */
        .description-label {
            color: #ffffff;
            font-size: 1.3rem;
            margin-top: 2.5rem;
            margin-bottom: 1.5rem;
            display: block;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative;
            padding-bottom: 10px;
        }

        .description-label::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #7c5176, #ffffff);
            border-radius: 2px;
        }

        .description-box {
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.8;
            word-break: break-word;
            font-weight: 300;
            font-size: 1.05rem;
            background: rgba(255, 255, 255, 0.03);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
</style>
<main class="max-w-7xl mx-auto p-4 md:p-10">
    <?php
    $event = $data['event'] ?? [];
    $allImg = getImgByEventId($event['event_id']) ?? [];
    ?>
    <?php if ($event): ?>
        <div class="glass-container p-6 md:p-8 lg:p-12 shadow-2xl">
            <button onclick="window.location.href='/home'" class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 w-12 h-12 rounded-full transition-all duration-300 hover:scale-110 hover:shadow-lg mb-6 flex items-center justify-center">
                <i class="fa-solid fa-angle-left text-white text-lg group-hover:-translate-x-1 transition-transform"></i>
            </button>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-12">
                <div>
                    <div id="carousel-wrapper" class="event-image-container relative h-64 md:h-80 lg:h-96">
                        <?php if (!empty($allImg)): ?>
                            <?php foreach ($allImg as $index => $img): ?>
                                <img src="<?= htmlspecialchars($img['img_path']) ?>" 
                                     class="slide-img w-full event-image-main <?= $index > 0 ? 'hidden' : '' ?>">
                            <?php endforeach; ?>
                            
                            <?php if (count($allImg) > 1): ?>
                                <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all z-10">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                                <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all z-10">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            <?php endif; ?>
                        <?php else: ?>
                            <i class="fa-regular fa-image text-6xl text-white/20"></i>
                        <?php endif; ?>
                    </div>
                    <div class="image-dots">
                        <?php foreach ($allImg as $index => $img): ?>
                            <div class="dot slide-dot <?= $index == 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $index ?>)"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="flex flex-col">
                    <h1 class="event-title text-xl md:text-2xl lg:text-3xl"><?= htmlspecialchars($event['event_name'] ?? 'NAME EVENT') ?></h1>
                    <div class="event-meta text-sm md:text-base">
                        <i class="fa-regular fa-calendar-days mr-2"></i>
                        <?= date('d M Y H:i', strtotime($event['start_date'])) ?> - <?= date('d M Y H:i', strtotime($event['stop_date'])) ?>
                    </div>
                    <div class="text-white/80 mb-4">
                        ชื่อผู้จัด: <span class="font-light"><?= htmlspecialchars(getNameCreatorByEventId($event['event_id'])['name'] ?? 'Admin') ?></span>
                    </div>
                    <div>
                        <div class="participant-badge text-sm md:text-base">
                            จำนวน <?= countApprovedMember($event['event_id']) ?> / <?= htmlspecialchars($event['amount']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <label class="description-label text-lg md:text-xl">รายละเอียด</label>
                <div class="description-box text-sm md:text-base">
                    <?= nl2br(htmlspecialchars($event['description'] ?? 'ไม่มีรายละเอียด')) ?>
                </div>
            </div>

            <div class="mt-8 md:mt-12 overflow-hidden flex flex-col md:flex-row justify-between gap-4">
                <?php if (isset($_SESSION['user'])): ?>
                    <form action="/joinEvent" method="post">
                        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['event_id'] ?? '') ?>">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user']['user_id'] ?? '') ?>">
                        <?php if (countApprovedMember($event['event_id']) < $event['amount']) { ?>
                            <?php if (checkStatus($_SESSION['user']['user_id'] ?? 0, $event['event_id']) == 'pending') { ?>
                                <button disabled type="submit" class="w-full md:w-auto bg-yellow-700 text-white px-6 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                    <i class="fa-solid fa-clock-rotate-left mr-2"></i>ขอลงทะเบียนเเล้ว
                                </button>
                            <?php } else if (checkStatus($_SESSION['user']['user_id'], $event['event_id']) == 'approved') { ?>
                                <button type="submit" disabled class="w-full md:w-auto bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                    <i class="fa-solid fa-circle-check mr-2"></i>เข้าร่วมกิจกรรมเเล้ว
                                </button>
                            <?php } else if (checkStatus($_SESSION['user']['user_id'], $event['event_id']) == 'rejected') { ?>
                                <button type="submit" disabled class="w-full md:w-auto bg-red-700 text-white px-6 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                    <i class="fa-solid fa-circle-xmark mr-2"></i>ถูกปฏิเสธ
                                </button>
                            <?php } else { ?>
                                <button type="submit" class="w-full md:w-auto bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-6 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                    <i class="fa-solid fa-user-plus mr-2"></i>ลงทะเบียน
                                </button>
                            <?php } ?>
                        <?php } else { ?>
                            <button type="submit" disabled class="w-full md:w-auto bg-red-800 text-white px-6 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                <i class="fa-solid fa-envelope mr-2"></i>ผู้เข้าร่วมเต็ม
                            </button>
                        <?php } ?>
                    </form>
                    
                    <?php if (checkOwnerEventOnDetail($event['event_id'], $_SESSION['user']['user_id'])) { ?>
                        <form action="/manageEvent" method="POST" class="w-full md:w-auto">
                            <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['user_id']; ?>">
                            <button type="submit" class="w-full md:w-auto bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-6 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                <i class="fa-solid fa-list-check mr-2"></i>จัดการกิจกรรม
                            </button>
                        </form>
                    <?php } ?>
                <?php else: ?>
                    <form action="/login" method="GET">
                        <button type="submit" class="w-full md:w-auto bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-6 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                            <i class="fa-solid fa-user-plus mr-2"></i>ลงทะเบียน
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</main>

<script>
    // ใช้สคริปต์แบบระบุเป้าหมายโดยตรง (ไม่พึ่ง ID จาก PHP)
    let currentIdx = 0;
    const slides = document.querySelectorAll('.slide-img');
    const dots = document.querySelectorAll('.slide-dot');

    function updateCarousel(index) {
        if (slides.length === 0) return;

        // ตรวจสอบ Index ไม่ให้เกินขอบเขต
        if (index >= slides.length) currentIdx = 0;
        else if (index < 0) currentIdx = slides.length - 1;
        else currentIdx = index;

        // ซ่อนรูปทั้งหมดและเอา active ออกจากจุดทั้งหมด
        slides.forEach(img => img.classList.add('hidden'));
        dots.forEach(dot => dot.classList.remove('active'));

        // แสดงรูปที่เลือกและไฮไลท์จุด
        slides[currentIdx].classList.remove('hidden');
        dots[currentIdx].classList.add('active');
    }

    function nextSlide() {
        updateCarousel(currentIdx + 1);
    }

    function prevSlide() {
        updateCarousel(currentIdx - 1);
    }

    function goToSlide(idx) {
        updateCarousel(idx);
    }

    // Auto-play ทุก 5 วินาที
    document.addEventListener('DOMContentLoaded', () => {
        if (slides.length > 1) {
            setInterval(nextSlide, 5000);
        }
    });
</script>
<?php include 'footer.php'; ?>