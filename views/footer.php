    <script>
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

        function confirmDelete() {
            return confirm('คุณต้องการลบกิจกรรมนี้หรือไม่?');
        }

        function showDeleteModal(eventId) {
            // Create modal overlay
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm animate-fadeIn';
            
            // Create modal content
            const modalContent = document.createElement('div');
            modalContent.className = 'bg-gradient-to-br from-red-600/95 via-red-700/95 to-red-800/95 rounded-2xl p-8 max-w-md w-full shadow-2xl border border-white/20 transform animate-scaleIn';
            
            // Create icon container
            const iconContainer = document.createElement('div');
            iconContainer.className = 'w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm border border-white/20';
            iconContainer.innerHTML = '<i class="fa-solid fa-trash text-4xl text-red-300 animate-pulse"></i>';
            
            // Create title
            const title = document.createElement('h3');
            title.className = 'text-2xl font-bold text-white mb-4 text-center';
            title.textContent = 'ยืนยันการลบกิจกรรม';
            
            // Create message
            const message = document.createElement('p');
            message.className = 'text-white/90 text-center mb-8 text-lg leading-relaxed';
            message.innerHTML = 'คุณต้องการลบกิจกรรมนี้หรือไม่?<br><span class="text-white/70 text-sm">การกระทำนี้ไม่สามารถย้อนกลับได้</span>';
            
            // Create button container
            const buttonContainer = document.createElement('div');
            buttonContainer.className = 'flex flex-col sm:flex-row gap-4 justify-center';
            
            // Create cancel button
            const cancelBtn = document.createElement('button');
            cancelBtn.className = 'flex-1 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 backdrop-blur-sm border border-white/20';
            cancelBtn.textContent = 'ยกเลิก';
            cancelBtn.onclick = closeDeleteModal;
            
            // Create delete button
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg';
            deleteBtn.innerHTML = '<i class="fa-solid fa-trash mr-2"></i>ลบกิจกรรม';
            deleteBtn.onclick = () => deleteEvent(eventId);
            
            // Assemble modal
            buttonContainer.appendChild(cancelBtn);
            buttonContainer.appendChild(deleteBtn);
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
                    closeDeleteModal();
                }
            });
            
            // Add CSS animations
            if (!document.querySelector('#modal-animations')) {
                const style = document.createElement('style');
                style.id = 'modal-animations';
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
            notify("<?php echo htmlspecialchars($_SESSION['error']); ?>", 'error');
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <script>
            notify("<?php echo htmlspecialchars($_SESSION['success']); ?>", 'success');
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
</body>

</html>