        <?php include 'header.php' ?>
        <?php $allEvent = getJoinedEventsByUserId($_SESSION['user']['user_id']); ?>

        <div class="space-y-4 p-10 rounded-2xl bg-[#2e2335] h-[800px] overflow-y-auto custom-scrollbar">
            <?php foreach ($allEvent as $each) { ?>
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
                            <p class="text-gray-300 text-sm line-clamp-2"><?php echo htmlspecialchars($each['description']); ?></p>
                            <div class="flex items-center gap-2 text-gray-400 text-sm">
                                <i class="fa-solid fa-calendar"></i>
                                <span><?php echo htmlspecialchars($each['start_date']); ?> - <?php echo htmlspecialchars($each['stop_date']); ?></span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-400 text-sm">
                                <i class="fa-solid fa-users"></i>
                                <span><?php echo htmlspecialchars($each['amount']); ?> คน</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center items-end h-32 md:h-40 ml-4">
                        <form action="/" method="post">
                            <input type="hidden" name="event_id" value="<?php echo $each['event_id'] ?>">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['user_id'] ?>">
                            <button type="submit" class="bg-[#f5f5f7] hover:bg-white text-[#5b3765] px-8 py-2 rounded-lg font-semibold text-sm transition-all transform active:scale-95 shadow-[0_4px_10px_rgba(0,0,0,0.2)]">
                                ขอ OTP
                            </button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
        </main>
        </div>

        <div id="modal-overlay" class="fixed inset-0 z-50 flex items-center justify-center p-4">

            <div class="relative w-full max-w-md modal-gradient rounded-xl p-8 pt-10 shadow-2xl">

                <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>

                <div class="text-center mb-8">
                    <h1 class="text-5xl font-oswald font-bold text-white tracking-wide mb-2 uppercase">Log In</h1>
                    <p class="text-sm text-gray-300">
                        Don't have an account? <a onclick="switchToSignup()" class="text-[#fff9c4] hover:text-white font-medium">Sign up</a>
                    </p>
                </div>

                <form action="/login" method="post" class="space-y-5">
                    <div class="space-y-1">
                        <label for="email" class="text-sm font-medium text-gray-200 block ml-1">Email</label>
                        <input type="email" name="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg custom-input text-white" required>
                    </div>

                    <div class="space-y-1">
                        <label for="password" class="text-sm font-medium text-gray-200 block ml-1">Password</label>
                        <input type="password" name="password" placeholder="Password" class="w-full px-4 py-3 rounded-lg custom-input text-white" required>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#fffdd0] hover:bg-[#fff9c4] text-[#2e2335] font-oswald font-bold text-xl py-3 rounded-full shadow-lg transform active:scale-95 transition-all duration-200 uppercase tracking-wider">
                            Log In
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="signup-modal-overlay" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="transition: opacity 0.3s ease; pointer-events: none; opacity: 0;">
            <div class="relative w-full max-w-md modal-gradient rounded-xl p-8 pt-10 shadow-2xl">
                <button onclick="closeSignup()" class="absolute top-4 right-4 text-gray-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>

                <div class="text-center mb-6">
                    <h1 class="text-5xl font-oswald font-bold text-white tracking-wide mb-2 uppercase">Sign Up</h1>
                    <p class="text-sm text-gray-300">
                        Already have an account? <a onclick="switchToLogin()" class="text-[#fff9c4] hover:text-white font-medium">Log in</a>
                    </p>
                </div>

                <form action="/register" method="post" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-200 block ml-1">Username</label>
                        <input type="text" name="username" placeholder="Username" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-200 block ml-1">Email</label>
                        <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-200 block ml-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-200 block ml-1">Confirm-Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm-Password" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" required>
                        <p id="password-error" class="text-xs text-red-400 mt-1 hidden">รหัสผ่านไม่ตรงกัน</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-200 block ml-1">Date of birth</label>
                        <input type="text" name="birthday" placeholder="yy/mm/dd" class="w-full px-4 py-2.5 rounded-lg custom-input text-white" onfocus="(this.type='date')">
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-200 block ml-1">Gender</label>
                        <select name="gender" class="w-full px-4 py-2.5 rounded-lg custom-input text-gray-400 focus:text-white appearance-none cursor-pointer">
                            <option class="text-black" value="" disabled selected>เลือกรายการ</option>
                            <option class="text-black" value="male">Male</option>
                            <option class="text-black" value="female">Female</option>
                            <option class="text-black" value="other">Other</option>
                        </select>
                    </div>

                    <div class="pt-4">
                        <button type="submit" id="sign-up" class="w-full bg-[#fffdd0] hover:bg-[#fff9c4] text-[#2e2335] font-oswald font-bold text-xl py-3 rounded-full shadow-lg transform active:scale-95 transition-all duration-200 uppercase tracking-wider">
                            Sign Up
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php include 'footer.php' ?> 