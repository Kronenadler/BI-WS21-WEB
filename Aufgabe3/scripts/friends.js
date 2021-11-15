



function keyup(input){
    const prefix = input.value;
    fillDataList(prefix);
}

function fillDataList(prefix, names){
    const datalist = document.getElementById('names');
    // DataList zurücksetzen
    datalist.innerHTML = '';

    for(let name in names){
        if(prefix === '' || name.startWith(prefix)){
            const option = document.CreateElement('option');
            option.value = name;
            datalist.appendChild(option);
        }
    }
}

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