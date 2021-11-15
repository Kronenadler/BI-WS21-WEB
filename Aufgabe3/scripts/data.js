const API = {
    "url": "https://online-lectures-cs.thi.de/chat",
    "collection_id": "8cc791e3-93c6-422a-a3bd-461163934c10",
    "currentUser": "Tom",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2ODg0NjAxfQ.R7I9YHGJ-F03QFzHEt0B4lygZZ6p2XDRePR49easuo4",
    "messagedUser": "Jerry"
};

function getPossibleFriends() {
    // Create HttpRequest and its reaction to it
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                fillDataList(JSON.parse(xmlhttp.responseText));
            }
        };

        // Send GET request to server with the required token etc.
        // TODO Request Send ändern
        xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/" + chat.collection_id + "/message/" + chat.messagedUser, true);
        xmlhttp.setRequestHeader('Authorization', 'Bearer ' + chat.token);
        xmlhttp.send();
    }