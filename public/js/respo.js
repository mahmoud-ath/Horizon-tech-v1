document.querySelectorAll('.menu-link').forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();

        // Get the target section
        const targetSection = link.getAttribute('data-section');

        // Hide all sections
        document.querySelectorAll('section').forEach(section => {
            section.classList.remove('active');
        });

        // Show the target section
        document.getElementById(targetSection).classList.add('active');

        // Update active class on sidebar links
        document.querySelectorAll('.menu-link').forEach(item => {
            item.classList.remove('active');
        });
        link.classList.add('active');
    });
});


//settings

document.getElementById('update-profile-form').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent the form from submitting the traditional way

    // Get the new username and image data
    const newUsername = document.getElementById('username').value;
    const newImage = document.getElementById('profile-img').files[0];

    // Update the displayed username and image on the sidebar
    document.getElementById('admin-username').textContent = newUsername;

    // If a new image is uploaded, update the profile image on the sidebar and main content
    if (newImage) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Update the profile image on sidebar and main content
            document.getElementById('admin-img').src = e.target.result;  // Sidebar image
            document.getElementById('profile-image').src = e.target.result;  // Profile settings preview
        };
        reader.readAsDataURL(newImage);  // Convert the uploaded image to data URL
    }

    // Optionally, you can show a success message or handle backend updates here
    alert('Profile updated successfully!');
});

// Example conversations data (In a real application, this would come from the backend)
let conversations = [
    { id: 1, message: 'Great article! I loved it.', status: 'Approved' },
    { id: 2, message: 'Very informative, looking forward to the next post!', status: 'Approved' },
];

// Function to render the conversations table
function renderConversations() {
    const conversationsList = document.getElementById('conversations-list');
    conversationsList.innerHTML = ''; // Clear existing content

    conversations.forEach(conversation => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${conversation.message}</td>
            <td>${conversation.status}</td>
            <td>
                <button class="delete-conversation-btn" data-id="${conversation.id}">Delete</button>
            </td>
        `;
        conversationsList.appendChild(row);
    });
}

// Event listener for the delete button in the conversations table
document.getElementById('conversations-list').addEventListener('click', function(event) {
    const button = event.target;
    const id = button.getAttribute('data-id');

    if (button.classList.contains('delete-conversation-btn')) {
        deleteConversation(id);
    }
});

// Function to delete a conversation
function deleteConversation(id) {
    conversations = conversations.filter(conversation => conversation.id != id);
    renderConversations(); // Re-render conversations table
}

// Initial rendering of conversations
renderConversations();


/* Manage Subscribers Table */
// Example subscribers data (in a real-world application, this data would come from a database)
let subscribers = [
    { id: 1, username: 'JohnDoe', email: 'johndoe@example.com', status: 'Subscribed' },
    { id: 2, username: 'JaneSmith', email: 'janesmith@example.com', status: 'Not Subscribed' },
];

// Function to render the subscribers table
function renderSubscribers() {
    const subscribersList = document.getElementById('subscribers-list');
    subscribersList.innerHTML = ''; // Clear the existing content

    subscribers.forEach(subscriber => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${subscriber.username}</td>
            <td>${subscriber.email}</td>
            <td>${subscriber.status}</td>
            <td>
                ${subscriber.status === 'Not Subscribed' ?
                    `<button class="subscribe-btn" data-id="${subscriber.id}">Subscribe</button>` :
                    `<button class="unsubscribe-btn" data-id="${subscriber.id}">Unsubscribe</button>`}
            </td>
        `;
        subscribersList.appendChild(row);
    });
}

// Event listeners for Subscribe and Unsubscribe buttons
document.getElementById('subscribers-list').addEventListener('click', function(event) {
    const button = event.target;

    if (button.classList.contains('subscribe-btn')) {
        const id = button.getAttribute('data-id');
        updateSubscriptionStatus(id, 'Subscribed');
    } else if (button.classList.contains('unsubscribe-btn')) {
        const id = button.getAttribute('data-id');
        updateSubscriptionStatus(id, 'Not Subscribed');
    }
});

// Function to update the subscription status of a subscriber
function updateSubscriptionStatus(id, status) {
    const subscriber = subscribers.find(sub => sub.id == id);
    if (subscriber) {
        subscriber.status = status;
        renderSubscribers(); // Re-render the table after status update
    }
}

// Initial rendering of subscribers
renderSubscribers();


// MANaging article and propsals
// Example articles data (In a real application, this would come from the backend)
let articles = [
    { id: 1, title: 'How to Improve Your Focus', theme: 'Motivation', status: 'En Cours' },
    { id: 2, title: 'Mastering Time Management', theme: 'Productivity', status: 'En Cours' },
];

// Example subscriber proposals data
let proposals = [
    { id: 1, title: 'Building a Positive Mindset', theme: 'Motivation', status: 'Proposed' },
    { id: 2, title: 'Time Management Tips', theme: 'Productivity', status: 'Proposed' },
];

// Function to render the articles table
function renderArticles() {
    const articlesList = document.getElementById('articles-list');
    articlesList.innerHTML = ''; // Clear existing content

    articles.forEach(article => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${article.title}</td>
            <td>${article.theme}</td>
            <td>${article.status}</td>
            <td>
                <button class="view-btn" data-id="${article.id}">View</button>
                <button class="delete-btn" data-id="${article.id}">Delete</button>
                <button class="publish-btn" data-id="${article.id}">Publish</button>
            </td>
        `;
        articlesList.appendChild(row);
    });
}

// Function to render the proposals table
function renderProposals() {
    const proposalsList = document.getElementById('proposals-list');
    proposalsList.innerHTML = ''; // Clear existing content

    proposals.forEach(proposal => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${proposal.title}</td>
            <td>${proposal.theme}</td>
            <td>${proposal.status}</td>
            <td>
                <button class="delete-proposal-btn" data-id="${proposal.id}">Delete</button>
                <button class="propose-edit-btn" data-id="${proposal.id}">Propose for Editing</button>
            </td>
        `;
        proposalsList.appendChild(row);
    });
}

// Event listener for the articles table actions
document.getElementById('articles-list').addEventListener('click', function(event) {
    const button = event.target;
    const id = button.getAttribute('data-id');

    if (button.classList.contains('view-btn')) {
        viewArticle(id);
    } else if (button.classList.contains('delete-btn')) {
        deleteArticle(id);
    } else if (button.classList.contains('publish-btn')) {
        publishArticle(id);
    }
});

// Event listener for the proposals table actions
document.getElementById('proposals-list').addEventListener('click', function(event) {
    const button = event.target;
    const id = button.getAttribute('data-id');

    if (button.classList.contains('delete-proposal-btn')) {
        deleteProposal(id);
    } else if (button.classList.contains('propose-edit-btn')) {
        proposeForEditing(id);
    }
});

// Function to view an article
function viewArticle(id) {
    alert(`Viewing article ID: ${id}`);
}

// Function to delete an article
function deleteArticle(id) {
    articles = articles.filter(article => article.id != id);
    renderArticles(); // Re-render articles table
}

// Function to publish an article
function publishArticle(id) {
    const article = articles.find(article => article.id == id);
    if (article) {
        article.status = 'Publié';
        renderArticles(); // Re-render articles table
    }
}

// Function to delete a proposal
function deleteProposal(id) {
    proposals = proposals.filter(proposal => proposal.id != id);
    renderProposals(); // Re-render proposals table
}

// Function to propose a proposal for editing
function proposeForEditing(id) {
    const proposal = proposals.find(proposal => proposal.id == id);
    if (proposal) {
        proposal.status = 'Proposed for Editing';
        renderProposals(); // Re-render proposals table
    }
}

// Initial rendering of articles and proposals
renderArticles();
renderProposals();


// Handle logout
document.getElementById("logout-btn").addEventListener("click", function () {
    // Logout logic (e.g., redirect to login page)
    alert("Logged out successfully!");
    // Redirect to login page (example)
    window.location.href = "login.html";
  });
