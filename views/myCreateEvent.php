<?php
include 'header.php';

?>


<div class="space-y-4 p-4 md:p-10 rounded-2xl bg-[#2e2335] h-[calc(100vh-120px)] md:h-[800px] overflow-y-auto custom-scrollbar">
    <div class="bg-white/5 p-3 rounded-lg border border-white/10">
        <div class="flex flex-col md:flex-row gap-3">
            <form action="/myCreateEvent" method="get" class="flex-1">
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
            <button onclick="window.location.href='/createEvent'" class="bg-white/20 text-white px-4 py-1.5 rounded text-sm hover:bg-white/30 transition-colors w-full md:w-auto">สร้างกิจกรรมใหม่</button>
        </div>
    </div>
    <?php if (!empty($data['allEvent'])) { ?>
        <?php foreach ($data['allEvent'] as $allEvent) { ?>
            <?php $firstImg = getFirstImgByEventId($allEvent['event_id']); ?>
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
                        <h3 class="text-lg md:text-xl font-semibold text-white"><?php echo htmlspecialchars($allEvent['event_name']); ?></h3>
                        <div class="space-y-2">
                            <p class="text-gray-300 text-sm line-clamp-2">
                                <i class="fa-solid fa-book"></i> <?php echo htmlspecialchars($allEvent['description']); ?>
                            </p>
                            <div class="flex flex-col gap-2 text-gray-400 text-sm">
                                <div>
                                    <i class="fa-solid fa-calendar"></i>
                                    <span class="text-xs md:text-sm">วันที่เริ่ม: <?= date('d M Y H:i', strtotime($allEvent['start_date'])) ?></span>
                                </div>
                                <div>
                                    <i class="fa-solid fa-calendar"></i>
                                    <span class="text-xs md:text-sm">วันที่สิ้นสุด: <?= date('d M Y H:i', strtotime($allEvent['stop_date'])) ?></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-gray-400 text-sm">
                                <i class="fa-solid fa-users"></i>
                                <span class="text-xs md:text-sm"><?php echo countApprovedMember($allEvent['event_id']) ?>/<?php echo htmlspecialchars($allEvent['amount']); ?> คน</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center items-center mt-4 md:mt-0 md:justify-end md:items-center h-auto md:h-32 lg:h-40 w-full md:w-auto ml-0 md:ml-4">
                        <div class="flex flex-col gap-2 w-full md:w-auto">
                            <form action="/editEvent" method="POST" class="w-full md:w-auto">
                                <input type="hidden" name="event_id" value="<?= $allEvent['event_id'] ?>">
                                <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all hover:bg-blue-700">
                                    แก้ไขกิจกรรม
                                </button>
                            </form>
                            <form action="/manageEvent" method="POST" class="w-full md:w-auto">
                                <input type="hidden" name="event_id" value="<?= $allEvent['event_id'] ?>">
                                <input type="hidden" name="user_id" value="<?= $_SESSION['user']['user_id'] ?>">
                                <button type="submit" class="w-full md:w-auto bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-xs md:text-sm transition-all hover:bg-green-700">
                                    จัดการกิจกรรม
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="text-gray-300 text-sm">ไม่พบกิจกรรมที่ค้นหา</p>
    <?php } ?>
</div>

<script>
    function clearFilters() {
        // Clear form values
        const form = document.querySelector('form[action="/myCreateEvent"]');
        if (form) {
            form.querySelector('input[name="search"]').value = '';
            form.querySelector('input[name="start_date"]').value = '';
            form.querySelector('input[name="stop_date"]').value = '';
            
            // Submit the form to clear filters
            form.submit();
        }
    }
</script>

<?php
include 'footer.php'
?>