// Chat-API Token - Todo: move to somewhere not in this file
const chat = {
    "url": "https://online-lectures-cs.thi.de/chat",
    "collection_id": "8cc791e3-93c6-422a-a3bd-461163934c10",
    "currentUser": "Tom",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2ODg0NjAxfQ.R7I9YHGJ-F03QFzHEt0B4lygZZ6p2XDRePR49easuo4",
    "messagedUser": "Jerry"
};
let last_msgs = "";

/**
 * Main
 * > first funtcion to call
 */
function main() {
    // Initialize vars

    // Initialize labels
    document.getElementById("chat_title").innerText = "Chat with " + chat.messagedUser;
    getMessages();

    // Update message area every 2 seconds
    window.setInterval(function () {
        getMessages();
    }, 2000);
}

/**
 * Requests and receives all sent messages from the server
 */
function getMessages() {
    // Create HttpRequest and its reaction to it
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            // if new messages came in, update
            if (last_msgs !== xmlhttp.responseText) {
                last_msgs = xmlhttp.responseText;

                // Parse JSON to an object and display in the message area
                displayMessages(JSON.parse(xmlhttp.responseText));
            }
        }
    };

    // Send GET request to server with the required token etc.
    xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/" + chat.collection_id + "/message/" + chat.messagedUser, true);
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + chat.token);
    xmlhttp.send();
}

/**
 * Display the message given in data
 * 
 * @data the object returned as JSON by the server
 */
function displayMessages(data) {
    let messages_html = "";

    for (let msg of data) {
        // Create new div per message
        let timestamp = new Date(msg.time).toLocaleString();
        messages_html +=
            `<div>
                <label><b>${msg.from}</b>: ${msg.msg}</label>
                <label class="timestamp">${timestamp}</label>
            </div>`;
    }

    // Set message area to new content
    let message_box = document.getElementById("message_box");
    message_box.innerText = "";
    message_box.innerHTML = messages_html;
}

/**
 * Send the actual message to the test Server
 */
function sendMessage() {
    // Message structure
    let msg = {
        "message": "",
        "to": chat.messagedUser
    }

    // Get input
    let input = document.getElementById("message_form_input");
    msg.message = input.value;
    input.value = "";

    console.log(JSON.stringify(msg)); //Todo

    // Create POST message
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {

            console.log("Message sent!"); //Todo
        }
    };

    // Send POST request to server with the required token etc.
    xmlhttp.open("POST", "https://online-lectures-cs.thi.de/chat/" + chat.collection_id + "/message", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + chat.token);
    xmlhttp.send(JSON.stringify(msg)); // Send msg serialized as JSON
}

