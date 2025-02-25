document.addEventListener("DOMContentLoaded", function() {
    const subscribersList = document.getElementById('subscribers-list');

    subscribersList.addEventListener('click', function(event) {
        const target = event.target;
        const id = target.getAttribute('data-id');

        if (target.classList.contains('delete-btn')) {
            deleteUser(id);
        }
    });

    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this subscription?')) {
            fetch(`/moderator/subscribers/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    alert('Subscription deleted successfully');
                    window.location.reload();
                } else {
                    alert('Failed to delete subscription');
                }
            });
        }
    }
});
