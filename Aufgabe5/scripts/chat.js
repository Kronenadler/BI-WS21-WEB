// Save the string of last messages, so we don't have to update the div all over again every 2 seconds
let last_msgs = "";

/**
 * Main
 * > first funtcion to call
 */
function main() {
    // Initialize vars

    // Initialize labels
    getMessages();

    // Update message area every 2 seconds
    window.setInterval(function() {
        getMessages();
    }, 2000);
}



/**
 * Requests and receives all sent messages from the server
 */
function getMessages() {
    // Create HttpRequest and its reaction to it
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            // if new messages came in, update
            if (last_msgs !== xmlhttp.responseText) {
                last_msgs = xmlhttp.responseText;

                // Parse JSON to an object and display in the message area
                var data = JSON.parse(xmlhttp.responseText);
                if (data.length > 0) {
                    displayMessages(data);
                }
            }
        }
    };

    // Send GET request to server with the required token etc.
    xmlhttp.open("GET", chat.url + '/' + chat.collection_id + "/message/" + chat.messagedUser, true);
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

    //console.log(JSON.stringify(msg)); //Todo

    // Create POST message
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {

            //console.log("Message sent!"); //Todo
            getMessages();
        }
    };

    // Send POST request to server with the required token etc.
    xmlhttp.open("POST", chat.url + '/' + chat.collection_id + "/message", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.setRequestHeader('Authorization', 'Bearer ' + chat.token);
    xmlhttp.send(JSON.stringify(msg)); // Send msg serialized as JSON
}