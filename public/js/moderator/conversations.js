// Example conversations data
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
