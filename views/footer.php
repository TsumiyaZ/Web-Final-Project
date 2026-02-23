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

        function confirmDelete() {
            return confirm('คุณต้องการลบกิจกรรมนี้หรือไม่?');
        }

        function showDeleteModal(eventId) {
            // Create modal container
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50';
            
            // Create modal content
            const modalContent = document.createElement('div');
            modalContent.className = 'bg-white rounded-lg p-6 max-w-sm mx-auto shadow-xl';
            
            // Create title
            const title = document.createElement('h3');
            title.className = 'text-lg font-semibold mb-4 text-gray-800';
            title.textContent = 'ยืนยันการลบกิจกรรม';
            
            // Create message
            const message = document.createElement('p');
            message.className = 'text-gray-600 mb-6';
            message.textContent = 'คุณต้องการลบกิจกรรมนี้หรือไม่?';
            
            // Create button container
            const buttonContainer = document.createElement('div');
            buttonContainer.className = 'flex gap-3 justify-end';
            
            // Create cancel button
            const cancelBtn = document.createElement('button');
            cancelBtn.className = 'px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors';
            cancelBtn.textContent = 'ยกเลิก';
            cancelBtn.onclick = closeDeleteModal;
            
            // Create delete button
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors';
            deleteBtn.textContent = 'ลบกิจกรรม';
            deleteBtn.onclick = () => deleteEvent(eventId);
            
            // Assemble modal
            buttonContainer.appendChild(cancelBtn);
            buttonContainer.appendChild(deleteBtn);
            modalContent.appendChild(title);
            modalContent.appendChild(message);
            modalContent.appendChild(buttonContainer);
            modal.appendChild(modalContent);
            
            document.body.appendChild(modal);
        }

        function closeDeleteModal() {
            const modal = document.querySelector('.fixed.inset-0');
            if (modal) {
                modal.remove();
            }
        }

        function deleteEvent(eventId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/deleteEvent';
            form.style.display = 'none';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'event_id';
            input.value = eventId;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
        

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