document.addEventListener('DOMContentLoaded', function () {
    const profileImageInput = document.getElementById('profile-image');
    const usernameInput = document.getElementById('username');

    if (profileImageInput) {
        profileImageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('admin-img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (usernameInput) {
        usernameInput.addEventListener('input', function () {
            document.getElementById('admin-username').textContent = this.value;
        });
    }
});
