document.addEventListener("DOMContentLoaded", function () {
  const themeFilter = document.getElementById('themeFilter');
  const statusFilter = document.getElementById('statusFilter');
  const articlesTableBody = document.getElementById('articlesTableBody');
  const articleRows = articlesTableBody.getElementsByTagName('tr');

  themeFilter.addEventListener('change', filterArticles);
  statusFilter.addEventListener('change', filterArticles);

  function filterArticles() {
    const selectedTheme = themeFilter.value;
    const selectedStatus = statusFilter.value;

    for (let row of articleRows) {
      const theme = row.getAttribute('data-theme');
      const status = row.getAttribute('data-status');

      const matchesTheme = (selectedTheme === 'all' || selectedTheme === theme);
      const matchesStatus = (selectedStatus === 'all' || selectedStatus === status);

      row.style.display = (matchesTheme && matchesStatus) ? '' : 'none';
    }
  }

  const switchStatusButtons = document.querySelectorAll('.switch-status-btn');
  const removeButtons = document.querySelectorAll('.remove-btn');
  const assignIssueButtons = document.querySelectorAll('.assign-issue-btn');
  const switchStatusForm = document.getElementById('switch-status-form');
  const removeForm = document.getElementById('remove-form');
  const assignIssueForm = document.getElementById('assign-issue-form');
  const switchStatusArticleIdInput = document.getElementById('switch-status-article-id');
  const removeArticleIdInput = document.getElementById('remove-article-id');
  const assignIssueArticleIdInput = document.getElementById('assign-issue-article-id');
  const assignIssueIdInput = document.getElementById('assign-issue-id');
  const issueModal = document.getElementById('issueModal');
  const issueSelect = document.getElementById('issueSelect');
  const assignIssueBtn = document.getElementById('assignIssueBtn');
  const closeModal = document.querySelector('.close');

  switchStatusButtons.forEach(button => {
      button.addEventListener('click', function () {
          const articleId = this.getAttribute('data-id');
          switchStatusArticleIdInput.value = articleId;
          switchStatusForm.action = `/admin/articles/switch-status/${articleId}`;
          switchStatusForm.submit();
      });
  });

  removeButtons.forEach(button => {
      button.addEventListener('click', function () {
          const articleId = this.getAttribute('data-id');
          removeArticleIdInput.value = articleId;
          removeForm.action = `/admin/articles/remove/${articleId}`;
          removeForm.submit();
      });
  });

  assignIssueButtons.forEach(button => {
      button.addEventListener('click', function () {
          const articleId = this.getAttribute('data-id');
          assignIssueArticleIdInput.value = articleId;
          issueModal.style.display = "block";
      });
  });

  assignIssueBtn.addEventListener('click', function () {
      const issueId = issueSelect.value;
      assignIssueIdInput.value = issueId;
      assignIssueForm.submit();
  });

  closeModal.addEventListener('click', function () {
      issueModal.style.display = "none";
  });

  window.addEventListener('click', function (event) {
      if (event.target == issueModal) {
          issueModal.style.display = "none";
      }
  });
  });
