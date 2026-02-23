<?php
include 'header.php';

$allYourEvent = getAllYourEventByUserId((int)$_SESSION['user']['user_id']);
?>

<button onclick="window.location.href='/createEvent'" class="bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-1.5 rounded-full text-sm transition-colors mb-4">สร้างกิจกรรมใหม่</button>
<div class="space-y-4 p-10 rounded-2xl bg-[#2e2335] h-[800px] overflow-y-auto custom-scrollbar">
    <?php foreach ($allYourEvent as $allEvent) { ?>
        <?php $firstImg = getFirstImgByEventId($allEvent['event_id']); ?>
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
                <h3 class="text-xl font-semibold text-white"><?php echo htmlspecialchars($allEvent['event_name']); ?></h3>
                <div class="space-y-2">
                    <p class="text-gray-300 text-sm line-clamp-2"><?php echo htmlspecialchars($allEvent['description']); ?></p>
                    <div class="flex items-center gap-2 text-gray-400 text-sm">
                        <i class="fa-solid fa-calendar"></i>
                        <span><?php echo htmlspecialchars($allEvent['start_date']); ?> - <?php echo htmlspecialchars($allEvent['stop_date']); ?></span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-400 text-sm">
                        <i class="fa-solid fa-users"></i>
                        <span><?php echo htmlspecialchars($allEvent['amount']); ?> คน</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-center items-end h-32 md:h-40 ml-4">
                <form action="/editEvent" method="POST" style="display: inline;">
                    <input type="hidden" name="event_id" value="<?= $allEvent['event_id'] ?>">
                    <button type="submit" class="bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                        จัดการกิจกรรม
                    </button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>
<div>

</div>

<?php
include 'footer.php'
?>