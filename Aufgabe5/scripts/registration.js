const form = document.getElementById('form');
const username = document.getElementById('username');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');
var pw1 = false;
var pw2 = false;
var un = false;
form.addEventListener('keyup', e => {
	checkInputs();
	e.preventDefault();

});
function goOn() {
	if (pw1 + pw2 + un === 3) {
		return true;
	}
	return false;

}

function checkInputs() {
	const usernameValue = username.value.trim();
	const passwordValue = password.value.trim();
	const password2Value = password2.value.trim();
	var xmlhttp = new XMLHttpRequest();

	//Check if passwords are emtpy and identical
	if (passwordValue === '' || passwordValue.length < 8) {
		setErrorFor(password);
		pw1 = false;
	} else {
		setSuccessFor(password);
		pw1 = true;
	}
	if (password2Value === '') {
		pw2 = false;
		setErrorFor(password2);
	} else if (passwordValue !== password2Value) {
		setErrorFor(password2);
		pw2 = false;
	} else {
		setSuccessFor(password2);
		pw2 = true;
	}

	//Check if Username already exist
	if (usernameValue != "" && usernameValue.length > 2) {
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4) {
				if (xmlhttp.status == 204) {
					setErrorFor(username);
					un = false;
				} else if (xmlhttp.status == 404) {
					setSuccessFor(username);
					un = true;
				}
			}
		}
		xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/ab1b1a8b-5b50-442b-a191-4ff2809750f6/user/" + usernameValue, true);
		xmlhttp.send();
	} else {
		setErrorFor(username);
	}
}
//Change border to red
function setErrorFor(input) {
	const formControl = input.parentElement;
	//const small = formControl.querySelector('small');
	formControl.className = 'form-control error';
}
//Change border to green
function setSuccessFor(input) {
	const formControl = input.parentElement;
	formControl.className = 'form-control success';
}

