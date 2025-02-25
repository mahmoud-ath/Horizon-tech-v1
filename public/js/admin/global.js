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
   
   
    articlesTableBody: document.querySelector('.articles-table tbody'),
    themeFilter: document.getElementById('themeFilter'),
    statusFilter: document.getElementById('statusFilter'),
    createArticleForm: document.getElementById('create-article-form'),
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

  // Button of the header
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
