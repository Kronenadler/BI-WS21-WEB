

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