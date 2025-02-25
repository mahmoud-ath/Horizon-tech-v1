
// Function to display an article in the table
function displayArticle(article) {
    const tableBody = document.getElementById('articles-list');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${article.title}</td>
        <td>${article.themes.join(', ')}</td>
        <td>${article.status}</td>
    `;
    tableBody.appendChild(row);
}

document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById("editArticleModal");
    var span = document.getElementsByClassName("close")[0];

    document.querySelectorAll('.edit-article-btn').forEach(button => {
        button.addEventListener('click', function() {
            var articleId = this.dataset.id;
            var title = this.dataset.title;
            var content = this.dataset.content;

            document.getElementById('articleId').value = articleId;
            document.getElementById('title').value = title;
            document.getElementById('content').value = content;

            var form = document.getElementById('editArticleForm');
            form.action = '/articles/' + articleId;

            modal.style.display = "block";
        });
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});