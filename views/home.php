        <?php include 'header.php' ?>
        <div class="space-y-4 p-4 md:p-10 rounded-2xl bg-[#2e2335] h-[calc(100vh-120px)] md:h-[800px] overflow-y-auto custom-scrollbar">
            <div class="bg-white/5 p-3 rounded-lg border border-white/10">
                <form action="/home" method="get">
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
                    <a href="/detailEvent?event_id=<?php echo htmlspecialchars($each['event_id']) ?>" class="block">
                        <div class="flex flex-col md:flex-row items-start bg-white/5 p-3 rounded-lg border border-white/10 shadow-2xl hover:bg-white/10 transition-all duration-300">
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
                            <div class="flex flex-col justify-center items-center mt-4 md:mt-0 md:justify-end md:items-center h-auto md:h-32 lg:h-40 w-full md:w-auto md:ml-4">
                                <?php if (isset($_SESSION['user'])) { ?>
                                    <form action="/joinEvent" method="post" class="w-full md:w-auto">
                                        <input type="hidden" name="event_id" value="<?php echo $each['event_id'] ?? '' ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['user_id'] ?? '' ?>">
                                        <?php if (countApprovedMember($each['event_id']) < $each['amount']) { ?>
                                            <?php if (isApproved($_SESSION['user']['user_id'] ?? 0, $each['event_id']) == 'pending') { ?>
                                                <button disabled type="submit" class="w-full md:w-auto bg-yellow-700 text-white px-6 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                                    <i class="fa-solid fa-clock-rotate-left mr-2"></i>ขอลงทะเบียนเเล้ว
                                                </button>
                                            <?php } else if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'approved') { ?>
                                                <button type="submit" disabled class="w-full md:w-auto bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                                    <i class="fa-solid fa-circle-check mr-2"></i>เข้าร่วมกิจกรรมเเล้ว
                                                </button>
                                            <?php } else if (isApproved($_SESSION['user']['user_id'], $each['event_id']) == 'rejected') { ?>
                                                <button type="submit" class="w-full md:w-auto bg-red-700 text-white px-6 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                                    <i class="fa-solid fa-circle-xmark mr-2"></i>ถูกปฏิเสธ
                                                </button>
                                            <?php } else { ?>
                                                <button type="submit" class="w-full md:w-auto bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-6 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                                    <i class="fa-solid fa-user-plus mr-2"></i>ลงทะเบียน
                                                </button>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <button type="submit" disabled class="w-full md:w-auto bg-red-800 text-white px-6 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                                <i class="fa-solid fa-envelope mr-2"></i>ผู้เข้าร่วมเต็ม
                                            </button>
                                        <?php } ?>
                                    </form>
                                <?php } else { ?>
                                    <form action="/login" method="GET">
                                        <button type="submit" class="w-full md:w-auto bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-6 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                            <i class="fa-solid fa-user-plus mr-2"></i>ลงทะเบียน
                                        </button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            <?php } else { ?>
                <p class="text-gray-300 text-sm">ไม่พบกิจกรรมที่ค้นหา</p>
            <?php } ?>
        </div>
        </div>
        <?php include 'footer.php' ?>