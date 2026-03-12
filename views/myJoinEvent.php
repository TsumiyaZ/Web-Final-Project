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
                <button type="button" onclick="clearFilters()" class="bg-white/20 text-white px-4 py-1.5 rounded text-sm hover:bg-white/30">
                    <i class="fa-solid fa-eraser"></i>
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
                        <div class="flex flex-col gap-2 w-full md:w-auto md:items-end">
                            <div class="flex flex-col gap-2 w-full md:w-auto md:items-end">
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
                                    <form action="cancelEvent" method="POST" class="w-full md:w-auto">
                                        <input type="hidden" name="event_id" value="<?= $each['event_id'] ?>">
                                        <input type="hidden" name="user_id" value="<?= $_SESSION['user']['user_id'] ?>">
                                        <button type="button" onclick="showCancelConfirmModal(<?= $each['event_id'] ?>, <?= $_SESSION['user']['user_id'] ?>)" class="w-full md:w-auto bg-red-600 text-white rounded-lg px-4 py-2 font-semibold text-xs md:text-sm transition-all hover:bg-red-700 transform hover:scale-105">
                                            <i class="fa-solid fa-times mr-2"></i>ยกเลิกการเข้าร่วม
                                        </button>
                                    </form>
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


<script>
    function clearFilters() {
        // Clear form values
        const form = document.querySelector('form[action="/myJoinEvent"]');
        if (form) {
            form.querySelector('input[name="search"]').value = '';
            form.querySelector('input[name="start_date"]').value = '';
            form.querySelector('input[name="stop_date"]').value = '';
            
            // Submit the form to clear filters
            form.submit();
        }
    }

    function showCancelConfirmModal(eventId, userId) {
        // Create modal overlay
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm animate-fadeIn ';
        
        // Create modal content
        const modalContent = document.createElement('div');
        modalContent.className = 'bg-gradient-to-br from-red-600/95 via-red-700/95 to-red-800/95 rounded-2xl p-8 max-w-md w-full shadow-2xl border border-white/20 transform animate-scaleIn';
        
        // Create icon container
        const iconContainer = document.createElement('div');
        iconContainer.className = 'w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm border border-white/20';
        iconContainer.innerHTML = '<i class="fa-solid fa-exclamation-triangle text-4xl text-yellow-400 animate-pulse"></i>';
        
        // Create title
        const title = document.createElement('h3');
        title.className = 'text-2xl font-bold text-white mb-4 text-center';
        title.textContent = 'ยืนยันการยกเลิก';
        
        // Create message
        const message = document.createElement('p');
        message.className = 'text-white/90 text-center mb-8 text-lg leading-relaxed';
        message.innerHTML = 'คุณต้องการยกเลิกการเข้าร่วมกิจกรรมนี้หรือไม่?<br><span class="text-white/70 text-sm">การกระทำนี้ไม่สามารถย้อนกลับได้</span>';
        
        // Create button container
        const buttonContainer = document.createElement('div');
        buttonContainer.className = 'flex flex-col sm:flex-row gap-4 justify-center';
        
        // Create cancel button
        const cancelBtn = document.createElement('button');
        cancelBtn.className = 'flex-1 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 backdrop-blur-sm border border-white/20';
        cancelBtn.textContent = 'ยกเลิก';
        cancelBtn.onclick = () => {
            modal.remove();
        };
        
        // Create confirm button
        const confirmBtn = document.createElement('button');
        confirmBtn.className = 'flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg';
        confirmBtn.innerHTML = '<i class="fa-solid fa-times mr-2"></i>ยกเลิกการเข้าร่วม';
        confirmBtn.onclick = () => {
            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'cancelEvent';
            
            const eventIdInput = document.createElement('input');
            eventIdInput.type = 'hidden';
            eventIdInput.name = 'event_id';
            eventIdInput.value = eventId;
            
            const userIdInput = document.createElement('input');
            userIdInput.type = 'hidden';
            userIdInput.name = 'user_id';
            userIdInput.value = userId;
            
            form.appendChild(eventIdInput);
            form.appendChild(userIdInput);
            document.body.appendChild(form);
            form.submit();
        };
        
        // Assemble modal
        buttonContainer.appendChild(cancelBtn);
        buttonContainer.appendChild(confirmBtn);
        modalContent.appendChild(iconContainer);
        modalContent.appendChild(title);
        modalContent.appendChild(message);
        modalContent.appendChild(buttonContainer);
        modal.appendChild(modalContent);
        
        // Add modal to body
        document.body.appendChild(modal);
        
        // Close modal on background click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
        
        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    }
</script>

<?php include 'footer.php' ?>