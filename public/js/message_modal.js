document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('messageModal');
    const modalMessage = document.getElementById('modalMessage');
    const closeBtn = document.querySelector('.close-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const viewBtns = document.querySelectorAll('.view-btn');

    // Ensure modal is hidden by default
    modal.style.display = 'none';

    viewBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modalMessage.textContent = btn.getAttribute('data-message');
            modal.style.display = 'flex';
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
