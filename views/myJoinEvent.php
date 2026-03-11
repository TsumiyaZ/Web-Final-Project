        <?php include 'header.php' ?>

<div class="space-y-4 p-4 md:p-10 rounded-2xl bg-[#2e2335] h-[calc(100vh-120px)] md:h-[800px] overflow-y-auto custom-scrollbar">
    <div class="bg-white/5 p-3 rounded-lg border border-white/10">
        <form action="/myJoinEvent" method="get">
            <div class="flex flex-col md:flex-row gap-2">
                <input type="text" name="search" placeholder="ค้นหา..." value="<?php echo htmlspecialchars($data['keyword'] ?? ''); ?>" class="flex-1 bg-white/10 text-white px-3 py-1.5 rounded text-sm focus:outline-none focus:bg-white/20">
                <input type="date" value="<?php echo htmlspecialchars($data['start_date'] ?? ''); ?>" name="start_date" class="bg-white/10 text-white px-3 py-1.5 rounded text-sm focus:outline-none focus:bg-white/20">
                <input type="date" value="<?php echo htmlspecialchars($data['stop_date'] ?? ''); ?>" name="stop_date" class="bg-white/10 text-white px-3 py-1.5 rounded text-sm focus:outline-none focus:bg-white/20">
                <button type="submit" class="bg-white/20 text-white px-4 py-1.5 rounded text-sm hover:bg-white/30">
                    ค้นหา
                </button>
            </div>
        </form>
    </div>
    <?php if (!empty($data['allEvent'])) { ?>
        <?php foreach ($data['allEvent'] as $each) { ?>
            <?php $firstImg = getFirstImgByEventId($each['event_id']); ?>

            <div class="bg-white/5 p-3 rounded-lg border border-white/10 mt-4">
                <div class="flex flex-col md:flex-row gap-2">
                    <div class="flex-shrink-0 w-full h-48 md:w-32 md:h-32 lg:w-40 lg:h-40 bg-white/10 rounded-lg overflow-hidden shadow-inner mb-4 md:mb-0">
                        <div class="w-full h-full flex items-center justify-center text-white/50">
                            <?php if ($firstImg): ?>
                                <img src="<?php echo htmlspecialchars($firstImg['img_path']) ?>" alt="Event Image" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fa-solid fa-image text-4xl"></i>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex-grow ml-0 md:ml-6 space-y-3">
                        <h3 class="text-lg md:text-xl font-semibold text-white"><?php echo htmlspecialchars($each['event_name']); ?></h3>
                        <div class="space-y-2">
                            <p class="text-gray-300 text-sm line-clamp-2">
                                <i class="fa-solid fa-book"></i> <?php echo htmlspecialchars($each['description']); ?>
                            </p>
                            <div class="flex flex-col gap-2 text-gray-400 text-sm">
                                <div>
                                    <i class="fa-solid fa-calendar"></i>
                                    <span class="text-xs md:text-sm">วันที่เริ่ม: <?= date('d M Y H:i', strtotime($each['start_date'])) ?></span>
                                </div>
                                <div>
                                    <i class="fa-solid fa-calendar"></i>
                                    <span class="text-xs md:text-sm">วันที่สิ้นสุด: <?= date('d M Y H:i', strtotime($each['stop_date'])) ?></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-gray-400 text-sm">
                                <i class="fa-solid fa-users"></i>
                                <span class="text-xs md:text-sm"><?php echo countApprovedMember($each['event_id']) ?>/<?php echo htmlspecialchars($each['amount']); ?> คน</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center items-center mt-4 md:mt-0 md:justify-end md:items-center h-auto md:h-32 lg:h-40 w-full md:w-auto">
                        <div class="flex flex-col gap-2 w-full md:w-auto">
                            <div>
                                <?php if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'approved') { ?>
                                    <?php if (isUsed_1($_SESSION['user']['user_id'], $each['event_id'])) { ?>
                                        <button type="submit" disabled class="w-full md:w-auto bg-green-600 text-white rounded-lg px-4 py-2 font-semibold text-xs md:text-sm transition-all">
                                            <i class="fa-solid fa-circle-check mr-2"></i>เข้าร่วมกิจกรรมแล้ว
                                        </button>
                                    <?php } else { ?>
                                        <button type="submit" disabled class="w-full md:w-auto bg-blue-600 text-white rounded-lg px-4 py-2 font-semibold text-xs md:text-sm transition-all">
                                            <i class="fa-solid fa-circle-check mr-2"></i>ได้รับการอนุมัติแล้ว
                                        </button>
                                    <?php } ?>
                                <?php } else if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'pending') { ?>
                                    <button type="submit" disabled class="w-full md:w-auto bg-yellow-600 text-white rounded-lg px-4 py-2 font-semibold text-xs md:text-sm transition-all">
                                        <i class="fa-solid fa-spinner mr-2 animate-spin"></i>รอการอนุมัติ
                                    </button>
                                <?php } else if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'rejected') { ?>
                                    <button type="submit" disabled class="w-full md:w-auto bg-red-600 text-white rounded-lg px-4 py-2 font-semibold text-xs md:text-sm transition-all">
                                        <i class="fa-solid fa-circle-xmark mr-2"></i>ไม่ผ่านการอนุมัติ
                                    </button>
                                <?php } ?>
                            </div>
                            <?php if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'approved') { ?>
                                <?php if (!isUsed_1($_SESSION['user']['user_id'], $each['event_id'])) { ?>
                                    <form action="/otp" method="post" class="w-full md:w-auto flex justify-end">
                                        <input type="hidden" name="join_id" value="<?php echo htmlspecialchars(getJoinIdByEventId($each['event_id'], $_SESSION['user']['user_id'])['join_id']) ?>">
                                        <button type="submit" class="w-full md:w-auto bg-white text-black px-4 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all hover:bg-gray-200">
                                            ขอ OTP
                                        </button>
                                    </form>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="text-gray-300 text-sm">ไม่พบกิจกรรมที่ค้นหา</p>
    <?php } ?>
</div>

<!-- OTP Modal Overlay -->
<?php if ($_SESSION['showOtpModal'] ?? false && $_SESSION['generatedOtp'] ?? false): ?>
    <div id="otpModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div class="bg-gradient-to-br from-[#7c5176] to-[#4a304d] rounded-2xl p-8 max-w-md w-full shadow-2xl border border-white/20">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-shield-halved text-3xl text-[#fff9c4]"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">รหัส OTP ของคุณ</h3>
                <p class="text-gray-300 text-sm">รหัสนี้จะหมดอายุใน 30 นาที</p>
            </div>

            <div class="bg-[#2e2335] rounded-xl p-6 mb-6 text-center">
                <span class="text-4xl font-mono font-bold text-[#fff9c4] tracking-[0.5em]">
                    <?php echo htmlspecialchars($_SESSION['generatedOtp']); ?>
                </span>
            </div>

            <div class="text-center">
                <button onclick="window.location.href='/myJoinEvent?closeModal=1'"
                    class="bg-white/10 hover:bg-white/20 text-white px-8 py-3 rounded-xl font-semibold transition-all">
                    ปิด
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php' ?>