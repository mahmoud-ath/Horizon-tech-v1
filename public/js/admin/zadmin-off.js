// Global state management
const state = {
     users: [],

    currentUser: {
      name: 'Admin',
      role: 'admin',
    },



  };

  // DOM Elements Cache
  const elements = {
    sections: document.querySelectorAll('section'),
    sidebarLinks: document.querySelectorAll('.sidebar a'),
    logoutBtn: document.getElementById('logout-btn'),
    statsElements: {
      totalSubscribers: document.getElementById('total-subscribers'),
      activeSubscribers: document.getElementById('active-subscribers'),
      totalThemes: document.getElementById('total-themes'),
      activeResponsibleThemes: document.getElementById('active-responsible-themes'),
      totalNumbers: document.getElementById('total-numbers'),
      publishedNumbers: document.getElementById('published-numbers'),
      totalArticles: document.getElementById('total-articles'),
      publishedArticles: document.getElementById('published-articles'),
      pendingArticles: document.getElementById('pending-articles'),
    },
    articlesTableBody: document.querySelector('.articles-table tbody'),
    themeFilter: document.getElementById('theme-filter'),
    statusFilter: document.getElementById('status-filter'),
    createArticleForm: document.getElementById('create-article-form'),
    usersTableBody: document.querySelector('.users-table tbody'),
    userModal: document.getElementById('user-modal'),
    userForm: document.getElementById('user-form'),
    userIdInput: document.getElementById('user-id'),
    userNameInput: document.getElementById('user-name'),
    userEmailInput: document.getElementById('user-email'),
    userStatusSelect: document.getElementById('user-status'),
    closeModalBtn: document.getElementById('close-modal-btn'),
    addUserBtn: document.getElementById('add-user-btn'),
    roleFilter: document.getElementById('role-filter'),
    userRoleInput: document.getElementById('user-role'),
    themesTableBody: document.querySelector('.themes-table tbody'),
    themeStatusFilter: document.getElementById('theme-status-filter'),
    issuesTableBody: document.querySelector('.issues-table tbody'),
    issuestatusFilter: document.getElementById('issue-status-filter'),
    addissuesBtn: document.getElementById('add-issue-btn'),
  };

  // Navigation Handler
  function handleNavigation() {
    const hash = window.location.hash || '#dashboard';

    if (!elements.sections || !elements.sidebarLinks) {
        console.error('Elements are not defined correctly.');
        return;
    }

    elements.sections.forEach((section) => section.classList.remove('active'));
    elements.sidebarLinks.forEach((link) => link.classList.remove('active'));

    const currentSection = document.querySelector(hash);
    const currentLink = document.querySelector(`a[href="${hash}"]`);

    if (currentSection) currentSection.classList.add('active');
    if (currentLink) currentLink.classList.add('active');
}

window.addEventListener('load', handleNavigation);
window.addEventListener('hashchange', handleNavigation);

  // Update Statistics Display
  function updateStatistics() {
    Object.entries(state.statistics).forEach(([key, value]) => {
      const element = elements.statsElements[key];
      if (element) {
        element.textContent = value.toLocaleString();
      }
    });
  }

  // Render Themes in Table
  function renderThemes() {
    const statusFilter = elements.themeStatusFilter.value;

    const filteredThemes = state.themes.filter((theme) =>
      statusFilter === 'all' || theme.status === statusFilter
    );

    elements.themesTableBody.innerHTML = '';

    filteredThemes.forEach((theme) => {
      const row = document.createElement('tr');

      elements.themesTableBody.appendChild(row);
    });

    addThemeActions();
  }

  // Add Event Listeners for Theme Actions
  function addThemeActions() {
    document.querySelectorAll('.change-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const themeId = parseInt(button.dataset.id, 10);
        changeResponsible(themeId);
      });
    });

    document.querySelectorAll('.remove-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const themeId = parseInt(button.dataset.id, 10);
        removeResponsible(themeId);
      });
    });

    document.querySelectorAll('.status-toggle-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const themeId = parseInt(button.dataset.id, 10);
        toggleThemeStatus(themeId);
      });
    });
  }

  // Change Responsible for Theme
  function changeResponsible(themeId) {
    const theme = state.themes.find((theme) => theme.id === themeId);
    if (theme) {
      const newResponsible = prompt('Enter the name of the new responsible user:');
      if (newResponsible) {
        theme.responsible = newResponsible;
        alert(`Responsible for theme "${theme.name}" updated to ${newResponsible}`);
        renderThemes();
      }
    }
  }

  // Remove Responsible from Theme
  function removeResponsible(themeId) {
    const theme = state.themes.find((theme) => theme.id === themeId);
    if (theme) {
      theme.responsible = 'Unassigned';
      alert(`Responsible removed for theme "${theme.name}"`);
      renderThemes();
    }
  }

  // Toggle Theme Status
  function toggleThemeStatus(themeId) {
    const theme = state.themes.find((theme) => theme.id === themeId);
    if (theme) {
      theme.status = theme.status === 'Public' ? 'Private' : 'Public';
      alert(`Status for theme "${theme.name}" changed to ${theme.status}`);
      renderThemes();
    }
  }

  // Render Users in Table
// Initialize State

  // Fetch and Render Users in Table
  function fetchUsers() {
    // Assuming the user data is embedded in the page via a script tag or a hidden element
    const usersData = JSON.parse(document.getElementById('users-data').textContent);
    state.users = usersData;
    renderUsers();
  }

  // Render Users in Table
  function renderUsers() {
    const roleFilter = document.getElementById('role-filter').value;
    const usersTableBody = document.querySelector('.users-table tbody');

    const filteredUsers = state.users.filter((user) => {
      return roleFilter === 'all' || user.usertype === roleFilter;
    });

    usersTableBody.innerHTML = '';
    filteredUsers.forEach((user) => {
      const row = document.createElement('tr');
      row.dataset.id = user.id;
      row.innerHTML = `
        <td>${user.id}</td>
        <td class="user-name">${user.name}</td>
        <td class="user-email">${user.email}</td>
        <td class="user-usertype">${user.usertype}</td>
        <td class="user-status">${user.email_verified_at ? 'Active' : 'Blocked'}</td>
        <td class="actions">
          <button class="edit-btn" data-id="${user.id}">Edit</button>
          <button class="save-btn hidden" data-id="${user.id}">Save</button>
          <button class="block-btn" data-id="${user.id}">${user.email_verified_at ? 'Block' : 'Unblock'}</button>
          <button class="delete-btn" data-id="${user.id}">Delete</button>
        </td>
      `;
      usersTableBody.appendChild(row);
    });

    addUserActions();
  }

  // Add Event Listeners for User Actions
  function addUserActions() {
    document.querySelectorAll('.edit-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const userId = parseInt(button.dataset.id, 10);
        enableEditing(userId);
      });
    });

    document.querySelectorAll('.save-btn').forEach((button) => {
      button.addEventListener('click', async () => {
        const userId = parseInt(button.dataset.id, 10);
        await saveUserEdits(userId);
      });
    });

    document.querySelectorAll('.block-btn').forEach((button) => {
      button.addEventListener('click', async () => {
        const userId = parseInt(button.dataset.id, 10);
        await toggleBlockUser(userId);
        fetchUsers();
      });
    });

    document.querySelectorAll('.delete-btn').forEach((button) => {
      button.addEventListener('click', async () => {
        const userId = parseInt(button.dataset.id, 10);
        await deleteUser(userId);
        fetchUsers();
      });
    });
  }

  // Enable editing mode for a user
  function enableEditing(userId) {
    const row = document.querySelector(`tr[data-id="${userId}"]`);
    const nameCell = row.querySelector('.user-name');
    const emailCell = row.querySelector('.user-email');
    const usertypeCell = row.querySelector('.user-usertype');
    const statusCell = row.querySelector('.user-status');

    nameCell.innerHTML = `<input type="text" value="${nameCell.textContent}">`;
    emailCell.innerHTML = `<input type="email" value="${emailCell.textContent}">`;
    usertypeCell.innerHTML = `<input type="text" value="${usertypeCell.textContent}">`;
    statusCell.innerHTML = `
    <select>
      <option value="Active"${statusCell.textContent === 'Active' ? ' selected' : ''}>Active</option>
      <option value="Blocked"${statusCell.textContent === 'Blocked' ? ' selected' : ''}>Blocked</option>
    </select>
  `;

  // Hide the edit button and show the save button
  row.querySelector('.edit-btn').classList.add('hidden');
  row.querySelector('.save-btn').classList.remove('hidden');
}

// Save user edits
async function saveUserEdits(userId) {
  // Get the row corresponding to the user ID
  const row = document.querySelector(`tr[data-id="${userId}"]`);
  // Get the input fields that contain the updated user data
  const nameInput = row.querySelector('.user-name input');
  const emailInput = row.querySelector('.user-email input');
  const usertypeInput = row.querySelector('.user-usertype input');
  const statusSelect = row.querySelector('.user-status select');

  // Create an object with the updated user data
  const updatedUser = {
    name: nameInput.value,
    email: emailInput.value,
    usertype: usertypeInput.value,
    status: statusSelect.value,
  };

  // Send the updated user data to the server via a PUT request
  await fetch(`/admin/users/${userId}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(updatedUser),
  });

  // Fetch and render users again to update the table
  fetchUsers();
}

// Block/Unblock User
async function toggleBlockUser(userId) {
  const user = state.users.find((user) => user.id === userId);
  if (user) {
    const action = user.email_verified_at ? 'block' : 'unblock';
    if (confirm(`Are you sure you want to ${action} this user?`)) {
      user.email_verified_at = user.email_verified_at ? null : new Date().toISOString();
      await fetch(`/admin/users/${userId}/toggle`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(user),
      });
      fetchUsers();
    }
  }
}

// Delete User
async function deleteUser(userId) {
  if (confirm('Are you sure you want to delete this user?')) {
    await fetch(`/admin/users/${userId}`, {
      method: 'DELETE',
    });
    fetchUsers();
  }
}

// Open Modal for Adding or Editing User
function openModal(isEdit = false, user = null) {
    const userModal = document.getElementById('user-modal');
    const userForm = document.getElementById('user-form');
    userModal.classList.remove('hidden'); // Show the modal
    userForm.reset(); // Reset the form fields

    if (isEdit && user) {
      // If editing, populate the form fields with user data
      document.getElementById('modal-title').textContent = 'Edit User';
      document.getElementById('user-id').value = user.id;
      document.getElementById('user-name').value = user.name;
      document.getElementById('user-email').value = user.email;
      document.getElementById('user-role').value = user.usertype;
      document.getElementById('user-status').value = user.email_verified_at ? 'Active' : 'Blocked';
      // Hide password fields when editing
      document.getElementById('user-password').parentElement.classList.add('hidden');
      document.getElementById('password-confirmation').parentElement.classList.add('hidden');
    } else {
      // If adding, set the modal title to "Add User" and show password fields
      document.getElementById('modal-title').textContent = 'Add User';
      document.getElementById('user-password').parentElement.classList.remove('hidden');
      document.getElementById('password-confirmation').parentElement.classList.remove('hidden');
    }
  }

// Save User (Add or Edit)
async function saveUser(event) {
    event.preventDefault();

    const userIdInput = document.getElementById('user-id');
    const userNameInput = document.getElementById('user-name');
    const userEmailInput = document.getElementById('user-email');
    const userRoleInput = document.getElementById('user-role');
    const userStatusSelect = document.getElementById('user-status');
    const userPasswordInput = document.getElementById('user-password');
    const userPasswordConfirmationInput = document.getElementById('user-password-confirmation');

    const id = userIdInput.value ? parseInt(userIdInput.value, 10) : null;
    const name = userNameInput.value;
    const email = userEmailInput.value;
    const usertype = userRoleInput.value;
    const status = userStatusSelect.value;
    const password = userPasswordInput.value;
    const password_confirmation = userPasswordConfirmationInput.value;

    const user = { id, name, email, usertype, status, password, password_confirmation };
    const method = id ? 'PUT' : 'POST'; // Determine if it's an update or a create
    const endpoint = id ? `/admin/users/${id}` : '/admin/users'; // Set endpoint URL

    // Send the user data to the server
    const response = await fetch(endpoint, {
      method,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(user),
    });

    if (!response.ok) {
      const errorMessage = await response.json();
      alert(`Error: ${errorMessage.message}`);
      return;
    }

    // Fetch and render users again to update the table
    fetchUsers();
    // Close the modal
    closeModal();
  }


// Initialize Manage Users - Add event listeners to buttons
document.getElementById('add-user-btn').addEventListener('click', () => openModal());
document.getElementById('close-modal-btn').addEventListener('click', closeModal);
document.getElementById('user-form').addEventListener('submit', saveUser);

// Fetch initial users data when the document is loaded
document.addEventListener('DOMContentLoaded', fetchUsers);

 // issues
 document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const issuesTableBody = document.querySelector('.issues-table tbody');

    // Fetch and render issues
    function fetchIssues() {
        fetch('/issues')
            .then(response => response.json())
            .then(issues => {
                renderIssues(issues);
            });
    }

    // Render issues in the table
    function renderIssues(issues) {
        issuesTableBody.innerHTML = '';
        issues.forEach(issue => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${issue.id}</td>
                <td>${issue.name}</td>
                <td><img src="${issue.imagepath}" alt="${issue.name}" width="50"></td>
                <td>${issue.publication_date}</td>
                <td>${issue.status}</td>
                <td class="actions">
                    <button class="reopen-issue-btn" data-id="${issue.id}">Reopen</button>
                    <button class="close-issue-btn" data-id="${issue.id}">Close</button>
                    <button class="remove-issue-btn" data-id="${issue.id}">Remove</button>
                </td>
            `;
            issuesTableBody.appendChild(row);
        });

        addIssueActions();
    }

    // Add event listeners for issue actions
    function addIssueActions() {
        document.querySelectorAll('.reopen-issue-btn').forEach(button => {
            button.addEventListener('click', () => {
                const issueId = button.dataset.id;
                console.log(`Reopen button clicked for issue ID: ${issueId}`);
                updateIssueStatus(issueId, 'Open');
            });
        });

        document.querySelectorAll('.close-issue-btn').forEach(button => {
            button.addEventListener('click', () => {
                const issueId = button.dataset.id;
                console.log(`Close button clicked for issue ID: ${issueId}`);
                updateIssueStatus(issueId, 'Closed');
            });
        });

        document.querySelectorAll('.remove-issue-btn').forEach(button => {
            button.addEventListener('click', () => {
                const issueId = button.dataset.id;
                console.log(`Remove button clicked for issue ID: ${issueId}`);
                removeIssue(issueId);
            });
        });
    }

    // Update issue status
    function updateIssueStatus(issueId, status) {
        fetch(`/issues/${issueId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ status }),
        })
        .then(response => response.json())
        .then(updatedIssue => {
            console.log('Issue status updated:', updatedIssue);
            fetchIssues();
        })
        .catch(error => console.error('Error:', error));
    }

    // Remove issue
    function removeIssue(issueId) {
        console.log(`Attempting to remove issue with ID: ${issueId}`);
        fetch(`/issues/${issueId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }
            return response.json();
        })
        .then(data => {
            console.log('Issue removed:', data);
            fetchIssues();
        })
        .catch(error => console.error('Error:', error));
    }

    // Initial fetch
    fetchIssues();
});


  // Initialize Application
  document.addEventListener('DOMContentLoaded', () => {
    handleNavigation();
    updateStatistics();
    renderArticles();
    renderUsers();
    renderThemes();
    renderIssues();

    window.addEventListener('hashchange', handleNavigation);

    elements.themeFilter?.addEventListener('change', renderArticles);
    elements.statusFilter?.addEventListener('change', renderArticles);
    elements.themeStatusFilter?.addEventListener('change', renderThemes);
  });

  //settings
  document.getElementById('settings-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch('/admin/update-settings', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();

        if (response.ok) {
            // Update the UI
            document.getElementById('current-username').textContent = data.username;

            if (data.profile_image) {
                document.querySelector('.admin-img').src = `/storage/${data.profile_image}`;
            }

            alert('Settings updated successfully!');
        } else {
            alert('An error occurred: ' + data.message);
        }
    } catch (error) {
        console.error('Error updating settings:', error);
        alert('Failed to update settings. Please try again.');
    }



  // button of the header

  // Handle logout
  document.getElementById("logout-btn").addEventListener("click", function () {
    // Logout logic (e.g., redirect to login page)
    alert("Logged out successfully!");
    // Redirect to login page (example)
    window.location.href = "login.html";
  });

  document.getElementById("back-home-btn").addEventListener("click", function() {
    window.location.href = "/"; // Replace with your homepage URL
  });
  document.getElementById("theme-btn-header").addEventListener("click", function() {
    window.location.href = "/themes"; // Replace with your homepage URL
  });



  //
  document.addEventListener("DOMContentLoaded", function () {

    // Cache DOM elements
    const themeFilter = document.getElementById('themeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const articlesTableBody = document.getElementById('articlesTableBody');
    const articleRows = articlesTableBody.getElementsByTagName('tr');

    // Event listeners for filters
    themeFilter.addEventListener('change', filterArticles);
    statusFilter.addEventListener('change', filterArticles);

    // Filter articles based on theme and status
    function filterArticles() {
        const selectedTheme = themeFilter.value;
        const selectedStatus = statusFilter.value;

        for (let row of articleRows) {
            const theme = row.getAttribute('data-theme');
            const status = row.getAttribute('data-status');

            const matchesTheme = (selectedTheme === 'all' || selectedTheme === theme);
            const matchesStatus = (selectedStatus === 'all' || selectedStatus === status);

            // Show or hide the row based on filter criteria
            row.style.display = (matchesTheme && matchesStatus) ? '' : 'none';
        }
    }

    // Update article status (Activate/Deactivate)
    function updateArticleStatus(articleId, newStatus) {
        fetch('/articles/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id: articleId, status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`tr[data-id='${articleId}']`);
                updateRowStatus(row, newStatus);
            } else {
                alert("Erreur lors de la mise à jour.");
            }
        });
    }

    // Remove article and update table
    function removeArticle(articleId) {
        if (!confirm("Are you sure you want to remove this article?")) return;

        fetch('/articles/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id: articleId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`tr[data-id='${articleId}']`);
                row.remove();
            } else {
                alert("Erreur lors de la suppression.");
            }
        });
    }

    // Helper function to update row status
    function updateRowStatus(row, newStatus) {
        row.querySelector(".status").textContent = newStatus;
        row.querySelector(".activate-btn").classList.toggle("hidden", newStatus === "Published");
        row.querySelector(".deactivate-btn").classList.toggle("hidden", newStatus === "Pending");
    }

    // Event listeners for action buttons (Activate, Deactivate, Remove)
    function addActionListeners() {
        document.querySelectorAll(".activate-btn").forEach(button => {
            button.addEventListener("click", () => updateArticleStatus(button.dataset.id, "Published"));
        });

        document.querySelectorAll(".deactivate-btn").forEach(button => {
            button.addEventListener("click", () => updateArticleStatus(button.dataset.id, "Pending"));
        });

        document.querySelectorAll(".remove-btn").forEach(button => {
            button.addEventListener("click", () => removeArticle(button.dataset.id));
        });
    }

    // Initialize action listeners
    addActionListeners();
  });
});
