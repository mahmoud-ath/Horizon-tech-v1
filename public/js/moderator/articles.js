document.addEventListener("DOMContentLoaded", function() {
    const articlesList = document.getElementById('articles-list');

    articlesList.addEventListener('click', function(event) {
        const target = event.target;
        const articleId = target.getAttribute('data-id');

        if (target.classList.contains('view-btn')) {
            viewArticle(articleId);
        } else if (target.classList.contains('delete-btn')) {
            deleteArticle(articleId);
        } else if (target.classList.contains('publish-btn')) {
            publishArticle(articleId);
        }
    });

    function viewArticle(id) {
        window.location.href = '/moderator/articles/' + id;
    }

    function deleteArticle(id) {
        if (confirm('Are you sure you want to delete this article?')) {
            fetch('/moderator/articles/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    alert('Article deleted successfully');
                    window.location.reload();
                } else {
                    alert('Failed to delete article');
                }
            });
        }
    }

    function publishArticle(id) {
        if (confirm('Are you sure you want to publish this article?')) {
            fetch('/moderator/articles/' + id + '/publish', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    alert('Article published successfully');
                    window.location.reload();
                } else {
                    alert('Failed to publish article');
                }
            });
        }
    }
});
