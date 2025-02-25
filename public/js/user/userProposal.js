$(document).ready(function() {
    // Handle form submission
    $('#article-form').submit(function(event) {
        // Basic validation
        const title = $('#article-title').val();
        const themeId = $('#article-themes').val();
        const content = $('#article-description').val();
        
        if (!title || !themeId || !content) {
            event.preventDefault();
            showNotification('Please fill in all required fields', 'error');
            return false;
        }
        
        // Optional: Add loading state
        $('#submit-article-btn').prop('disabled', true).text('Envoi en cours...');
        
        // Show success notification before form submission
        showNotification('Article successfully submitted!', 'success');
        return true;
    });

    // Function to show notifications
    function showNotification(message, type) {
        let $notification = $('#notification');
        
        // Create notification if it doesn't exist
        if ($notification.length === 0) {
            $notification = $('<div id="notification" class="notification"></div>');
            $('body').append($notification);
        }

        $notification
            .removeClass('success error')
            .addClass(type)
            .html(message)
            .css('display', 'none') // Ensure it's hidden before showing
            .fadeIn(300);

        // Auto hide after 5 seconds
        setTimeout(function() {
            $notification.fadeOut(300);
        }, 5000);
    }
});