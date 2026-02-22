<?php
include 'header.php';

$allYourEvent = getAllYourEventByUserId((int)$_SESSION['user']['user_id']);
?>

<button onclick="window.location.href='/createEvent'" class="bg-[#4d4d4d] hover:bg-[#5d5d5d] text-gray-300 px-4 py-1.5 rounded-full text-sm transition-colors">สร้างกิจกรรมใหม่</button>
<div class="space-y-4 p-10 rounded-2xl bg-gray-500 h-[800px] overflow-y-auto custom-scrollbar">
    <?php foreach ($allYourEvent as $allEvent) { ?>
        <div class="flex items-center bg-[#8b6a96]/30  p-4 rounded-2xl border border-white/10 shadow-2xl hover:bg-[#8b6a96]/40 transition-all duration-300">
            <div class="flex-shrink-0 w-32 h-32 md:w-40 md:h-40 bg-[#a38caf]/40 rounded-xl overflow-hidden shadow-inner">
                <div class="w-full h-full flex items-center justify-center text-white/50">
                    <img src="<?= getFirstImgByEventId($allEvent['event_id'])['img_path'] ?>" alt="">
                </div>
            </div>

            <div class="flex-grow ml-6 space-y-3">
                <div class="h-5 bg-[#a38caf]/50 rounded-full w-1/3"><?php echo $allEvent['event_name'] ?></div>
                <div class="space-y-2">
                    <div class="h-3 bg-[#a38caf]/30 rounded-full w-full"><?php echo $allEvent['start_date'] ?></div>
                    <div class="h-3 bg-[#a38caf]/30 rounded-full w-full"><?php echo $allEvent['stop_date'] ?></div>
                    <div class="h-3 bg-[#a38caf]/30 rounded-full w-3/4"><?php echo $allEvent['description'] ?></div>
                    <div class="h-3 bg-[#a38caf]/30 rounded-full w-3/4"><?php echo $allEvent['amount'] ?></div>
                </div>
                <div class="h-4 bg-[#a38caf]/40 rounded-full w-1/4 mt-2"></div>
            </div>

            <div class="flex flex-col justify-between items-end h-32 md:h-40 ml-4">
                <div class="h-6 bg-[#d1c4e9]/30 border border-white/10 rounded-full w-16"></div>

                <form action="/editEvent" method="POST" style="display: inline;">
                    <input type="hidden" name="event_id" value="<?= $allEvent['event_id'] ?>">
                    <button type="submit" class="bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-6 py-1.5 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
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