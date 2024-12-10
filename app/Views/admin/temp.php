<!-- show success and error messages through SweetAlert -->
<div class="title float-right mb-2 mt-2" id="flashMessage">
    <?php if (session()->getFlashdata('success')): ?>
        <!-- Success message in SweetAlert -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    text: '<?= addslashes(session()->getFlashdata('success')) ?>',
                    timer: 2000,
                    showConfirmButton: false,  // Hide the OK button
                    willClose: () => { // Optional: you can add any additional actions when the alert closes
                        // You can do something after the alert closes, like redirecting
                    }
                });
            });
        </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <!-- Error message in SweetAlert -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    text: '<?= addslashes(session()->getFlashdata('error')) ?>',
                    timer: 2000,
                    showConfirmButton: false,  // Hide the OK button
                    willClose: () => { // Optional: you can add any additional actions when the alert closes
                        // You can do something after the alert closes, like redirecting
                    }
                });
            });
        </script>
    <?php endif; ?>
</div>