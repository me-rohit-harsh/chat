document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const chatList = document.getElementById('chatList');
    const chats = chatList.getElementsByClassName('list-group-item');

    // Function to filter chat list based on search input
    function filterChats() {
        const searchText = searchInput.value.trim().toLowerCase();

        Array.from(chats).forEach(chat => {
            const userName = chat.querySelector('h6').textContent.toLowerCase();
            if (userName.includes(searchText)) {
                chat.style.display = 'block';
            } else {
                chat.style.display = 'none';
            }
        });
    }

    // Event listener for search input
    searchInput.addEventListener('input', filterChats);
});

// Function to scroll the chat container to the bottom
function scrollChatToBottom() {
    var chatContainer = document.getElementById("chatContainer");
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

// Call the scroll function when the page is loaded
window.onload = function () {
    scrollChatToBottom();
};
function userMessageUpdate(message, updatedAt) {
    var html = `
        <div class="message incoming">
            <i class="fa-solid fa-user text-dark"></i>
            <div class="message-content">
                ${message}
                <div class="message-meta">
                    <span class="message-time"> ${updatedAt} </span>
                </div>
            </div>
        </div>`;

    // Append the HTML to the chatContainer
   var chatContainer = document.getElementById("chatMessageId");
   chatContainer.insertAdjacentHTML('beforeend', html);


    // Scroll the chat to bottom
    scrollChatToBottom();
}

