let friendlist = new Array(2);

function main() {
    getPossibleFriends();
}


function getPossibleFriends() {
    // Create HttpRequest and its reaction to it
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                friendlist = JSON.parse(xmlhttp.responseText);
                fillDataList('');
            }
        };

        // Send GET request to server with the required token etc.
        // TODO Request Send ändern
        xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/959ed065-65d3-429a-bb11-5c95a0ef0eb5/user", true);
        // Add token, e. g., from Tom
        xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM3MTU0ODE4fQ.5j4ARl5S8RjdFV3YDY1zrn4q5xfViMF7IA51wprnzDM');
        xmlhttp.send();
    }

function keyup(input){
    const prefix = input.value;
    getPossibleFriends();
    fillDataList(prefix);
}

function fillDataList(prefix){
    const datalist = document.getElementById('names');
    // DataList zurücksetzen
    datalist.innerHTML = '';

    for(let x = 0; x < friendlist.length; x++){
        if(prefix === '' || friendlist[x].toLowerCase().startsWith(prefix.toLowerCase())){
            const option = document.createElement('option');
            option.value = friendlist[x];
            datalist.appendChild(option);
        }
    }
}