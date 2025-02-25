document.addEventListener('DOMContentLoaded', () => {
    const articleId = document.querySelector('meta[name="article-id"]').content;
    const themeId = document.querySelector('meta[name="theme-id"]').content;
    const issueId = document.querySelector('meta[name="issue-id"]').content;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    document.querySelectorAll('.reply-button').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.querySelector(`.reply-form[data-comment-id="${commentId}"]`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });

    document.querySelectorAll('.reply-form').forEach(form => {
        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            const commentId = this.getAttribute('data-comment-id');
            const replyText = this.querySelector('.reply-text').value;
            const url = themeId !== 'null'
                ? `/themes/${themeId}/articles/${articleId}/comments`
                : `/numbers/${issueId}/${articleId}/comments`;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken
                    },
                    body: JSON.stringify({
                        content: replyText,
                        parent_id: commentId
                    })
                });

                const data = await response.json();
                if (data.success) {
                    const newReply = document.createElement('div');
                    newReply.classList.add('comment', 'reply');
                    newReply.innerHTML = `
                        <p class="comment-author"><strong>${data.user_name}:</strong></p>
                        <p class="comment-content">${replyText}</p>
                    `;
                    this.insertAdjacentElement('beforebegin', newReply);
                    this.querySelector('.reply-text').value = '';
                    this.style.display = 'none';
                }
            } catch (error) {
                console.error('Error posting reply:', error);
            }
        });
    });

    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            const commentText = document.getElementById('comment-text').value;
            // Fix: Make parent_id optional by using optional chaining and nullish coalescing
            const parentId = document.getElementById('parent-id')?.value || null;
            const url = themeId !== 'null'
                ? `/themes/${themeId}/articles/${articleId}/comments`
                : `/numbers/${issueId}/${articleId}/comments`;

            try {
                const response = await fetch(url, { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken
                    },
                    body: JSON.stringify({
                        content: commentText,
                        parent_id: parentId
                    })
                });

                const data = await response.json();
                if (data.success) {
                    const commentSection = document.getElementById('comments-section');
                    const newComment = document.createElement('div');
                    newComment.classList.add('comment');
                    newComment.innerHTML = `
                        <p class="comment-author"><strong>${data.user_name}:</strong></p>
                        <p class="comment-content">${commentText}</p>
                    `;

                    if (parentId) {
                        // Fix: Add null check for parent comment
                        const parentComment = document.querySelector(`.reply-button[data-comment-id="${parentId}"]`)?.parentElement;
                        if (parentComment) {
                            parentComment.insertAdjacentElement('beforeend', newComment);
                        } else {
                            commentSection.appendChild(newComment);
                        }
                    } else {
                        commentSection.appendChild(newComment);
                    }

                    this.reset();
                }
            } catch (error) {
                console.error('Error posting comment:', error);
            }
        });
    }

    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', async function() {
            const rating = this.getAttribute('data-value');

            try {
                const response = await fetch(`/articles/${articleId}/ratings`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken
                    },
                    body: JSON.stringify({ rating: rating })
                });

                const data = await response.json();
                if (data.success) {
                    document.querySelectorAll('.star').forEach(s => s.classList.remove('selected'));
                    for (let i = 1; i <= rating; i++) {
                        document.querySelector(`.star[data-value="${i}"]`)?.classList.add('selected');
                    }
                }
            } catch (error) {
                console.error('Error updating rating:', error);
            }
        });
    });
});
