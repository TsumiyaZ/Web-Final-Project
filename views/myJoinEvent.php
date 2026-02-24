        <?php include 'header.php' ?>

        <div class="space-y-4 p-10 rounded-2xl bg-[#2e2335] h-[800px] overflow-y-auto custom-scrollbar">
            <div class="flex gap-2 items-center">
                <form action="/myJoinEvent" method="get">
                    <div class="flex">
                        <div class="relative">
                            <input type="text" name="search" placeholder="ค้นหากิจกรรม" value="<?php echo htmlspecialchars($data['keyword'] ?? ''); ?>" class="bg-[#4d4d4d] text-gray-300 pl-4 pr-10 py-1.5 rounded-full text-sm focus:outline-none w-64">
                        </div>
                        <div>
                            <span class="ml-2">วันที่เริ่ม </span><input type="date" value="<?php echo htmlspecialchars($data['start_date'] ?? ''); ?>" name="start_date" class="bg-[#4d4d4d] text-gray-300 pl-4 pr-10 py-1.5 rounded-full text-sm focus:outline-none w-64"> -
                            <span>จนถึงวัน </span><input type="date" value="<?php echo htmlspecialchars($data['stop_date'] ?? ''); ?>" name="stop_date" class="bg-[#4d4d4d] text-gray-300 pl-4 pr-10 py-1.5 rounded-full text-sm focus:outline-none w-64">
                            <button type="submit" class="bg-[#4d4d4d] hover:bg-white text-white px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                ค้นหาวัน
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if (!empty($data['allEvent'])) { ?>
                <?php foreach ($data['allEvent'] as $each) { ?>
                    <?php $firstImg = getFirstImgByEventId($each['event_id']); ?>

                    <div class="flex items-center bg-[#8b6a96]/30 p-6 rounded-2xl border border-white/10 shadow-2xl hover:bg-[#8b6a96]/40 transition-all duration-300">
                        <div class="flex-shrink-0 w-32 h-32 md:w-40 md:h-40 bg-[#a38caf]/40 rounded-xl overflow-hidden shadow-inner">
                            <div class="w-full h-full flex items-center justify-center text-white/50">
                                <?php if ($firstImg): ?>
                                    <img src="<?php echo $firstImg['img_path'] ?>" alt="Event Image" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="fa-solid fa-image text-4xl"></i>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="flex-grow ml-6 space-y-3">
                            <h3 class="text-xl font-semibold text-white"><?php echo htmlspecialchars($each['event_name']); ?></h3>
                            <div class="space-y-2">
                                <p class="text-gray-300 text-sm line-clamp-2">
                                    <i class="fa-solid fa-book"></i> <?php echo htmlspecialchars($each['description']); ?>
                                </p>
                                <div class="flex flex-col gap-2 text-gray-400 text-sm">
                                    <div>
                                        <i class="fa-solid fa-calendar"></i>
                                        <span>วันที่เริ่มกิจกรรม: <?php echo htmlspecialchars($each['start_date']); ?></span>
                                    </div>
                                    <div>
                                        <i class="fa-solid fa-calendar"></i>
                                        <span>วันที่สิ้นสุดกิจกรรม: <?php echo htmlspecialchars($each['stop_date']); ?></span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-gray-400 text-sm">
                                    <i class="fa-solid fa-users"></i>
                                    <span><?php echo countApprovedMember($each['event_id']) ?>/<?php echo htmlspecialchars($each['amount']); ?> คน</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col justify-center items-end h-32 md:h-40">
                            <div class="flex flex-1">
                                <div>
                                    <?php if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'approved') { ?>
                                        <button type="submit" disabled class="bg-blue-600 text-white rounded-lg p-3 font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                            <i class="fa-solid fa-circle-check mr-2"></i>เข้าร่วมกิจกรรมเเล้ว
                                        </button>
                                    <?php } else if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'pending') { ?>
                                        <button type="submit" disabled class="bg-yellow-600 text-white rounded-lg p-3 font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                            <i class="fa-solid fa-spinner mr-2 animate-spin"></i>รอการอนุมัติ
                                        </button>
                                    <?php } else if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'rejected') { ?>
                                        <button type="submit" disabled class="bg-red-600 text-white rounded-lg p-3 font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                            <i class="fa-solid fa-circle-xmark mr-2"></i>ไม่ผ่านการอนุมัติ
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'approved') { ?>
                                <form action="/otp" method="post">
                                    <input type="hidden" name="join_id" value="<?php echo getJoinIdByEventId($each['event_id'], $_SESSION['user']['user_id'])['join_id'] ?>">
                                    <button type="submit" class="bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                        ขอ OTP
                                    </button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-gray-300 text-sm">ไม่พบกิจกรรมที่ค้นหา</p>
            <?php } ?>
        </div>
        </main>

        <!-- OTP Modal Overlay -->
        <?php if ($_SESSION['showOtpModal'] && $_SESSION['generatedOtp']): ?>
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