<?php
include 'header.php';

$event = $data['event'] ?? [];
$approvedMember = $data['approvedMember'] ?? [];
$rejectedMember = $data['rejectedMember'] ?? [];
$pendingMember = $data['pendingMember'] ?? [];
$allMember = $data['allMember'] ?? [];
$isUsed_1_Member = $data['isUsed_1_Member'] ?? [];
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
        padding: 12px 16px;
        width: 100%;
    }

    .custom-field:focus {
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

    .btn-danger {
        background-color: #dc2626;
        color: #ffffff;
        border: none;
        border-radius: 1rem;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        background-color: #b91c1c;
        transform: scale(1.02);
    }

    .btn-secondary {
        background-color: #6b7280;
        color: #ffffff;
        border: none;
        border-radius: 1rem;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
        transform: scale(1.02);
    }

    .stat-card {
        background-color: rgba(163, 140, 175, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1rem;
        padding: 20px;
        text-align: center;
    }

    .participant-item {
        background-color: rgba(163, 140, 175, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 0.75rem;
        padding: 16px;
        transition: all 0.2s;
    }

    .participant-item:hover {
        background-color: rgba(163, 140, 175, 0.25);
        border-color: rgba(255, 255, 255, 0.1);
    }
</style>

<main class="max-w-6xl mx-auto glass-container p-6 md:p-10 shadow-2xl mt-6 mb-12">
    <div class="mb-8 flex items-center justify-between">
        <a href="/myCreateEvent" class="bg-white text-gray-800 px-5 py-1.5 rounded-full flex items-center gap-2 text-sm font-medium hover:bg-gray-100 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i> จัดการกิจกรรม
        </a>
        <h2 class="text-xl font-medium tracking-wide">ศูนย์บริหารกิจกรรม</h2>
    </div>

    <?php if ($event): ?>
        <!-- Event Details Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-white mb-4">ข้อมูลกิจกรรม</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-light text-gray-300 mb-2">ชื่อกิจกรรม</label>
                        <input type="text" value="<?= htmlspecialchars($event['event_name'] ?? '') ?>" class="custom-field" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-light text-gray-300 mb-2">จำนวนผู้เข้าร่วม</label>
                        <input type="text" value="<?= htmlspecialchars($event['amount'] ?? '') ?> คน" class="custom-field" readonly>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-light text-gray-300 mb-2">วันที่เริ่มกิจกรรม</label>
                        <input type="text" value="<?= htmlspecialchars($event['start_date'] ?? '') ?>" class="custom-field" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-light text-gray-300 mb-2">วันที่สิ้นสุดกิจกรรม</label>
                        <input type="text" value="<?= htmlspecialchars($event['stop_date'] ?? '') ?>" class="custom-field" readonly>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-light text-gray-300 mb-2">รายละเอียดกิจกรรม</label>
                <textarea rows="4" class="custom-field resize-none" readonly><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-white mb-4">สถิติกิจกรรม</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="stat-card">
                    <div class="text-3xl font-bold text-white mb-2">
                        <i class="fa-solid fa-users text-blue-400"></i>
                        <span id="approvedCount"><?= countApprovedMember($event['event_id']) ?></span>
                    </div>
                    <p class="text-gray-300 text-sm">จำนวนผู้ได้รับการอนุมัติ</p>
                </div>
                <div class="stat-card">
                    <div class="text-3xl font-bold text-white mb-2 ">
                        <i class="fa-solid fa-circle-xmark text-red-400"></i>
                        <span id="rejectedCount"><?= countRejectedMember($event['event_id']) ?></span>
                    </div>
                    <p class="text-gray-300 text-sm">จำนวนผู้ไม่ได้รับการอนุมัติ</p>
                </div>
                <div class="stat-card">
                    <div class="text-3xl font-bold text-white mb-2">
                        <i class="fa-solid fa-chart-line text-yellow-400"></i>
                        <span id="totalCount"><?= countPendingMember($event['event_id']) ?></span>
                    </div>
                    <p class="text-gray-300 text-sm">จำนวนผู้รออนุมัติ</p>
                </div>
                <div class="stat-card">
                    <div class="text-3xl font-bold text-white mb-2">
                        <i class="fa-solid fa-right-to-bracket text-green-600"></i>
                        <span id="totalCount"><?= countAllCheckInMember($event['event_id']) ?></span>
                    </div>
                    <p class="text-gray-300 text-sm">เข้างานเเล้ว</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-white mb-4">จัดการกิจกรรม</h3>
            <div class="flex flex-wrap gap-4">
                <form action="/editEvent" method="post">
                    <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                    <button class="btn-primary">
                        <i class="fa-solid fa-edit mr-2"></i> แก้ไขข้อมูล
                    </button>
                </form>
                <button onclick="showDeleteModal(<?= $event['event_id'] ?? 0 ?>)" class="btn-danger">
                    <i class="fa-solid fa-trash mr-2"></i> ลบกิจกรรม
                </button>
            </div>
        </div>

        <!-- Participants Section -->
        <div>
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white mb-2">รายชื่อผู้เข้าร่วม</h3>
                <div class="text-right bg-[#8b6a96]/20 border border-white/10 rounded-xl p-2 mb-2 flex justify-center items-center">
                    <h3 class="text-white text-sm">ทั้งหมด <span id="totalCount" class="font-bold text-yellow-400"><?= countAllMemberByEventId($event['event_id']) ?></span> คน</h3>
                </div>
            </div>

            <!-- Pending Members -->
            <div class="mb-6">
                <div class="bg-[#8b6a96]/20 border border-white/10 rounded-xl p-4">
                    <h4 class="text-white font-medium mb-3 flex items-center">
                        <i class="fa-solid fa-clock text-yellow-400 mr-2"></i>
                        รอการอนุมัติ
                    </h4>
                    <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        <?php if (empty($pendingMember)) { ?>
                            <div class="text-gray-400 text-center py-4">
                                <i class="fa-solid fa-check-circle text-green-400 mr-2"></i>
                                ไม่มีผู้ใช้ที่รอการอนุมัติ
                            </div>
                        <?php } else { ?>
                            <?php foreach ($pendingMember as $member) { ?>
                                <div class="participant-item">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                <i class="fa-solid fa-user text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium"><?= htmlspecialchars($member['name']) ?></p>
                                                <p class="text-gray-400 text-sm"><?= htmlspecialchars($member['email']) ?></p>
                                                <p class="text-gray-400 text-sm">อายุ: <?= getAge($member['birthday']) ?> ปี</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <form action="/approveMember" method="POST" class="inline">
                                                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?? 0 ?>">
                                                <input type="hidden" name="user_id" value="<?= $member['user_id'] ?? 0 ?>">
                                                <button type="submit" class="btn-primary mx-2">อนุมัติ</button>
                                            </form>
                                            <form action="/rejectMember" method="POST" class="inline">
                                                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?? 0 ?>">
                                                <input type="hidden" name="user_id" value="<?= $member['user_id'] ?? 0 ?>">
                                                <button type="submit" class="btn-danger">ไม่อนุมัติ</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Approved Members -->
            <div class="mb-6">
                <div class="bg-[#8b6a96]/20 border border-white/10 rounded-xl p-4">
                    <h4 class="text-white font-medium mb-3 flex items-center">
                        <i class="fa-solid fa-check-circle text-green-400 mr-2"></i>
                        อนุมัติแล้ว
                    </h4>
                    <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        <?php if (empty($approvedMember)) { ?>
                            <div class="text-gray-400 text-center py-4">
                                <i class="fa-solid fa-users text-gray-500 mr-2"></i>
                                ยังไม่มีผู้ใช้ที่ได้รับการอนุมัติ
                            </div>
                        <?php } else { ?>
                            <?php foreach ($approvedMember as $member) { ?>
                                <?php $join_id = getJoinIdByEventId($event['event_id'], $member['user_id']) ?>
                                <?php $isUsed = getIsUsedByJoinId($join_id['join_id']) ?>
                                <?php if ($isUsed['is_used'] == 0) { ?>
                                    <div class="participant-item opacity-75">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                    <i class="fa-solid fa-check text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="text-white font-medium"><?= htmlspecialchars($member['name']) ?></p>
                                                    <p class="text-gray-400 text-sm"><?= htmlspecialchars($member['email']) ?></p>
                                                    <p class="text-gray-400 text-sm">อายุ: <?= getAge($member['birthday']) ?> ปี</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-green-400 text-sm font-medium">
                                                    <i class="fa-solid fa-check-circle mr-1"></i>อนุมัติแล้ว
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="text-gray-400 text-center py-4">
                                        <i class="fa-solid fa-users text-gray-500 mr-2"></i>
                                        ยังไม่มีผู้ใช้ที่ได้รับการอนุมัติ
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Rejected Members -->
            <div class="mb-6">
                <div class="bg-[#8b6a96]/20 border border-white/10 rounded-xl p-4">
                    <h4 class="text-white font-medium mb-3 flex items-center">
                        <i class="fa-solid fa-times-circle text-red-400 mr-2"></i>
                        ไม่อนุมัติ
                    </h4>
                    <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        <?php if (empty($rejectedMember)) { ?>
                            <div class="text-gray-400 text-center py-4">
                                <i class="fa-solid fa-heart text-gray-500 mr-2"></i>
                                ไม่มีผู้ใช้ที่ถูกปฏิเสธ
                            </div>
                        <?php } else { ?>
                            <?php foreach ($rejectedMember as $member) { ?>
                                <div class="participant-item opacity-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                <i class="fa-solid fa-times text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium"><?= htmlspecialchars($member['name']) ?></p>
                                                <p class="text-gray-400 text-sm"><?= htmlspecialchars($member['email']) ?></p>
                                                <p class="text-gray-400 text-sm">อายุ: <?= getAge($member['birthday']) ?> ปี</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-red-400 text-sm font-medium">
                                                <i class="fa-solid fa-times-circle mr-1"></i>ไม่อนุมัติ
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- check in Members -->
            <div class="mb-6">
                <div class="bg-[#8b6a96]/20 border border-white/10 rounded-xl p-4">
                    <h4 class="text-white font-medium mb-3 flex items-center">
                        <i class="fa-solid fa-check-circle text-green-400 mr-2"></i>
                        เข้าร่วมงานเเล้ว
                    </h4>
                    <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        <?php if (empty($isUsed_1_Member)) { ?>
                            <div class="text-gray-400 text-center py-4">
                                <i class="fa-solid fa-users text-gray-500 mr-2"></i>
                                ยังไม่มีผู้เข้าร่วมงาน
                            </div>
                        <?php } else { ?>
                            <?php foreach ($isUsed_1_Member as $member) { ?>
                                <?php $join_id = getJoinIdByEventId($event['event_id'], $member['user_id']) ?>
                                <?php $isUsed = getIsUsedByJoinId($join_id['join_id']) ?>
                                <div class="participant-item opacity-75">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                <i class="fa-solid fa-check text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium"><?= htmlspecialchars($member['name']) ?></p>
                                                <p class="text-gray-400 text-sm"><?= htmlspecialchars($member['email']) ?></p>
                                                <p class="text-gray-400 text-sm">อายุ: <?= getAge($member['birthday']) ?> ปี</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-green-400 text-sm font-medium">
                                                <i class="fa-solid fa-check-circle mr-1"></i>เข้างานเเล้ว
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>

    <?php else: ?>
        <div class="text-center py-12">
            <i class="fa-solid fa-exclamation-triangle text-6xl text-yellow-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-white mb-2">ไม่พบข้อมูลกิจกรรม</h3>
            <p class="text-gray-300 mb-6">ไม่สามารถค้นหาข้อมูลกิจกรรมที่คุณต้องการได้</p>
            <button onclick="window.location.href='/myCreateEvent'" class="btn-primary">
                <i class="fa-solid fa-arrow-left mr-2"></i> กลับไปหน้ากิจกรรมของฉัน
            </button>
        </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>