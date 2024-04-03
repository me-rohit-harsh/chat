document.addEventListener("DOMContentLoaded", function () {
    var chatBox = document.getElementById('chatBox');
    var chatButton = document.getElementById('chatButton');
    var maximizeButton = document.getElementById('maximizeChat');

    // Function to toggle chat box visibility
    function toggleChatBox() {
        if (chatBox.style.display === 'none') {
            chatBox.style.display = 'block';
            chatButton.innerHTML = '<i class="fas fa-times"></i>';
        } else {
            chatBox.style.display = 'none';
            chatButton.innerHTML = '<i class="fa-solid fa-comments fas fa-2x"></i>';
        }
    }

    // Call toggleChatBox() initially to ensure the chat box is displayed
    toggleChatBox();

    // Event listener for chat button
    document.getElementById('chatButton').addEventListener('click', function () {
        toggleChatBox();
    });

    // Event listener for maximize button
    document.getElementById('maximizeChat').addEventListener('click', function () {
        var isMaximized = chatBox.classList.toggle('maximized');
        maximizeButton.innerHTML = isMaximized ? '<i class="fas fa-compress-alt"></i>' : '<i class="fas fa-expand-alt"></i>';
    });
});


// Function to send a message from the user
function sendMessage() {
    // Get user input from the form fields
    // var department = document.getElementById('department').value;
    // var subject = document.getElementById('subject').value;
    var message = document.getElementById('message').value;
    var convForm = document.getElementById('convForm');
    var userInput = document.getElementById('userMessageInput');
    convForm.style.display = 'none';
    userInput.style.display = '';


    // Construct the message
    var userMessage = `
        <div class="message outgoing">
            <div class="message-content">
               ${message}           
            </div>
        </div>
    `;

    // Append the user message to the chat box
    document.getElementById('chatMessages').innerHTML += userMessage;

    setTimeout(function () {
        document.getElementById('chatMessages').innerHTML += userMessage;
        scrollChatToBottom();

    }, 2500)
    scrollChatToBottom();
    // Simulate admin reply (replace with actual backend logic)
    var adminReply = `
        <div class="message incoming">
            <div class="message-content">Thank you for your message. We will get back to you soon.
            </div>
        </div>
    `;

    // Append the admin reply to the chat box after a delay (simulating response time)
    setTimeout(function () {
        document.getElementById('chatMessages').innerHTML += adminReply;
        scrollChatToBottom();
    }, 1000); // Adjust the delay as needed (in milliseconds)
    setTimeout(function () {
        document.getElementById('chatMessages').innerHTML += adminReply;
        scrollChatToBottom();
    }, 2000); // Adjust the delay as needed (in milliseconds)
    setTimeout(function () {
        document.getElementById('chatMessages').innerHTML += adminReply;
        scrollChatToBottom();
    }, 3000); // Adjust the delay as needed (in milliseconds)

}

// Add event listener to the form submit button to send the message
document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission
    sendMessage(); // Call the sendMessage function
    scrollChatToBottom();
});
// Function to scroll the chat container to the bottom
function scrollChatToBottom() {
    var userMgCon = document.getElementById("userMgCon");
    userMgCon.scrollTop = userMgCon.scrollHeight;
}