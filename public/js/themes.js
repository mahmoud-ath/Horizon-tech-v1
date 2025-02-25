document.addEventListener('DOMContentLoaded', function() {
    window.toggleSubscription = function(themeId) {
        fetch('/themes/toggleSubscription', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ theme: themeId })
        })
        .then(response => {
            if (response.redirected) {
                // If user is not authenticated, redirect to login page
                window.location.href = response.url;
                return;
            }
            if (!response.ok) {
                if (response.status === 401) {
                    // Unauthorized, redirect to login
                    window.location.href = '/login';
                    return;
                }
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                const buttonElement = document.getElementById(`subscribe-${themeId}`);

                // Toggle button text based on current state
                if (buttonElement) {
                    const isCurrentlySubscribed = buttonElement.textContent.trim() === 'Unsubscribe';
                    buttonElement.textContent = isCurrentlySubscribed ? 'Subscribe' : 'Unsubscribe';

                    // Optional: Add visual feedback
                    buttonElement.classList.toggle('subscribed', !isCurrentlySubscribed);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Check if we need to redirect to login
            if (error.message === 'Unauthorized') {
                window.location.href = '/login';
            } else {
                alert('Error updating subscription status');
            }
        });
    }
});
