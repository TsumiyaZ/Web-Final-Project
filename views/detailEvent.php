<?php include 'header.php'; ?>

<style>
    body {
        background: #2e2335 !important;
        font-family: 'Kanit', sans-serif;
        /* แนะนำให้ใช้ font นี้เพื่อให้เหมือนแบบ */
    }

    .glass-container {
        background-color: rgba(139, 106, 150, 0.2);
        backdrop-filter: blur(15px);
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    /* ส่วนของรูปภาพฝั่งซ้าย */
    .event-image-container {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 1.5rem;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .event-image-main {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-dots {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 15px;
    }

    .dot {
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
    }

    .dot.active {
        background: #ffffff;
    }

    /* ข้อความหลัก */
    .event-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #ffffff;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .event-meta {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .participant-badge {
        background: #ffffff;
        color: #2e2335;
        padding: 5px 20px;
        border-radius: 20px;
        display: inline-block;
        font-weight: 600;
        margin-top: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* รายละเอียดด้านล่าง */
    .description-label {
        color: #ffffff;
        font-size: 1.2rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        display: block;
    }

    .description-box {
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
        word-break: break-all;
        font-weight: 300;
    }

    /* ปุ่มเข้าร่วมสีขาวตามแบบ */
    .btn-join-main {
        background: #fdf6e3;
        color: #2e2335;
        padding: 10px 40px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s;
        float: right;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-join-main:hover {
        transform: translateY(-2px);
        background: #ffffff;
    }

    .btn-cancel-main {
        background: #dc2626;
        color: white;
        padding: 10px 40px;
        border-radius: 15px;
        float: right;
    }
</style>

<main class="max-w-7xl mx-auto p-4 md:p-10">
    <?php
    $event = $data['event'] ?? [];
    $allImg = getImgByEventId($event['event_id']);
    ?>

    <?php if ($event): ?>
        <div class="glass-container p-8 md:p-12 shadow-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <div>
                    <div class="event-image-container">
                        <?php if (!empty($allImg)): ?>
                            <?php $firstImg = true; ?>
                            <?php foreach($allImg as $img) { ?>
                                <?php if ($firstImg == true) { ?>
                                    <img src="<?= htmlspecialchars($img['img_path']) ?>" id="event-image-1" class="w-full ">
                                    <?php $firstImg = false; ?>
                                <?php } else { ?>
                                    <img src="<?= htmlspecialchars($img['img_path']) ?>" id="event-image-1" class="w-full hidden">
                                <?php } ?>
                            <?php } ?>
                        <?php else: ?>
                            <i class="fa-regular fa-image text-6xl text-white/20"></i>
                        <?php endif; ?>
                    </div>
                    <div class="image-dots">
                        <div class="dot active"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>

                <div class="flex flex-col justify-center">
                    <h1 class="event-title"><?= htmlspecialchars($event['event_name'] ?? 'NAME EVENT') ?></h1>

                    <div class="event-meta">
                        <i class="fa-regular fa-calendar-days mr-2"></i>
                        <?= htmlspecialchars($event['start_date']) ?> - <?= htmlspecialchars($event['stop_date']) ?>
                    </div>

                    <div class="text-white/80 mb-4">
                        ชื่อผู้จัด: <span class="font-light"><?= htmlspecialchars($event['creator_name'] ?? 'ไม่ระบุ') ?></span>
                    </div>

                    <div>
                        <div class="participant-badge">
                            จำนวน <?= countApprovedMember($event['event_id']) ?> / <?= htmlspecialchars($event['amount']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <label class="description-label">รายละเอียด</label>
                <div class="description-box">
                    <?= nl2br(htmlspecialchars($event['description'] ?? 'ไม่มีรายละเอียด')) ?>
                </div>
            </div>

            <div class="mt-12 overflow-hidden">
                <form action="/joinEvent" method="post">
                    <input type="hidden" name="event_id" value="<?php echo $event['event_id'] ?? '' ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['user_id'] ?? '' ?>">
                    <?php if (countApprovedMember($event['event_id']) < $event['amount']) { ?>
                        <?php if (isApproved($_SESSION['user']['user_id'] ?? 0, $event['event_id']) == 'pending') { ?>
                            <button disabled type="submit" class="bg-yellow-700 text-white px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                <i class="fa-solid fa-clock-rotate-left mr-2"></i>ขอลงทะเบียนเเล้ว
                            </button>
                        <?php } else if (isApproved($_SESSION['user']['user_id'], $event['event_id']) == 'approved') { ?>
                            <button type="submit" disabled class="bg-blue-600 text-white px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                <i class="fa-solid fa-circle-check mr-2"></i>เข้าร่วมกิจกรรมเเล้ว
                            </button>
                        <?php } else if (isApproved($_SESSION['user']['user_id'], $event['event_id']) == 'rejected') { ?>
                            <button type="submit" class="bg-red-700 text-white px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                <i class="fa-solid fa-circle-xmark mr-2"></i>ถูกปฏิเสธ
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                <i class="fa-solid fa-user-plus mr-2"></i>ลงทะเบียน
                            </button>
                        <?php } ?>
                    <?php } else { ?>
                        <button type="submit" disabled class="bg-red-800 text-white px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                            <i class="fa-solid fa-envelope mr-2"></i>ผู้เข้าร่วมเต็ม
                        </button>
                    <?php } ?>
                </form>
            </div>
        </div>

    <?php else: ?>
        <div class="text-center py-20 glass-container">
            <i class="fa-solid fa-circle-exclamation text-6xl text-white/20 mb-4"></i>
            <h3 class="text-white text-xl">ไม่พบข้อมูลกิจกรรม</h3>
            <a href="/home" class="text-white/50 underline mt-4 block">กลับหน้าหลัก</a>
        </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>