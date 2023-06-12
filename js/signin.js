function signIn() {
    console.log("Test");
    let email = document.getElementById("email_field").innerHTML;
    let password = document.getElementById("password_field").innerHTML;

    if (email.length == 0 || password.length == 0) {
        return;
    } else {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/signin.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                window.location.href = "/index.php";
            }
        }

        xhr.send(`email=${email}&password=${password}`);
    }
}

document.getElementById("submit_button").onclick(signIn());