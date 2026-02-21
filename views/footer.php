    <script>
        const modalOverlay = document.getElementById('modal-overlay');
        const mainContent = document.getElementById('main-content');

        const password = document.getElementById('password');
        const conPassword = document.getElementById('confirm-password');
        const errorText = document.getElementById('password-error');
        const signUp = document.getElementById('sign-up');

        function openLogin() {
            modalOverlay.style.opacity = '1';
            modalOverlay.style.pointerEvents = 'auto';
            mainContent.classList.add('background-blur');
        }

        function closeModal() {
            modalOverlay.style.opacity = '0';
            modalOverlay.style.pointerEvents = 'none';
            mainContent.classList.remove('background-blur');
        }

        function notify(msg, type = 'error') {
            if (!msg) return;
            const div = document.createElement('div');

            if (type == 'success') {
                div.style.background = '#2ecc71';
            } else {
                div.style.background = '#ff4d4d';
            }

            div.className = 'toast';
            div.innerHTML = `<i class="fa-solid fa-circle-exclamation mr-2"></i> ${msg}`;
            document.body.appendChild(div);

            setTimeout(() => div.remove(), 3000);
        }


        const signupOverlay = document.getElementById('signup-modal-overlay');

        function openSignup() {
            signupOverlay.style.opacity = '1';
            signupOverlay.style.pointerEvents = 'auto';
            mainContent.classList.add('background-blur');
        }

        function closeSignup() {
            signupOverlay.style.opacity = '0';
            signupOverlay.style.pointerEvents = 'none';
            mainContent.classList.remove('background-blur');
        }

        function switchToSignup() {
            closeModal();
            setTimeout(openSignup, 100);
        }

        function switchToLogin() {
            closeSignup();
            setTimeout(openLogin, 100);
        }

        function checkConfirmPassword() {
            if (conPassword.value === '') {
                errorText.classList.add('hidden');
                signUp.disabled = false;

                signUp.style.opacity = '1';
                signUp.style.cursor = 'pointer';
                return;
            }

            if (conPassword.value !== password.value) {
                errorText.classList.remove('hidden');
                signUp.disabled = true;
                signUp.style.opacity = '0.5';
                signUp.style.cursor = 'not-allowed';
            } else {
                errorText.classList.add('hidden');
                signUp.disabled = false;
                signUp.style.opacity = '1';
                signUp.style.cursor = 'pointer';
            }
        }


        password.addEventListener('input', checkConfirmPassword);
        conPassword.addEventListener('input', checkConfirmPassword);
    </script>

    <?php if (!empty($_SESSION['error'])): ?>
        <script>
            notify("<?php echo $_SESSION['error']; ?>", 'error');
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <script>
            notify("<?php echo $_SESSION['success']; ?>", 'success');
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
</body>

</html>