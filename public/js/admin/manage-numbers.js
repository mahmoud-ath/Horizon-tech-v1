function showAddIssueModal() {
    document.getElementById('addIssueModal').style.display = 'block';
}

function closeAddIssueModal() {
    document.getElementById('addIssueModal').style.display = 'none';
}

function switchStatus(issueId) {
    document.getElementById('switchStatusForm-' + issueId).submit();
}

function deleteIssue(issueId) {
    if (confirm('Are you sure you want to delete this issue?')) {
        document.getElementById('deleteIssueForm-' + issueId).submit();
    }
}

function showIssuePage(issueId) {
    window.location.href = '/numbers/' + issueId; 
}

function filterIssues() {
    const filter = document.getElementById('issue-status-filter').value;
    const issues = document.querySelectorAll('.issue-box');

    issues.forEach(issue => {
        if (filter === 'all' || issue.getAttribute('data-status') === filter) {
            issue.style.display = 'block';
        } else {
            issue.style.display = 'none';
        }
    });
}

window.onclick = function(event) {
    const modal = document.getElementById('addIssueModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}