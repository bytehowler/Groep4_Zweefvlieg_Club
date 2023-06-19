document.addEventListener("DOMContentLoaded", function(){
    function signUp() {

        const getValue = (id) => document.getElementById(id).value;

        const fields = [
            getValue("firstname_field"),
            getValue("lastname_field"),
            getValue("email_field"),
            getValue("password_field"),
            getValue("confirm_password_field"),
            getValue("phone_field"),
            getValue("birthdate_field"),
            getValue("verification_code_field")
        ];

        if (fields.some(field => field.length === 0)) {
            return;
        } else if (getValue("password_field") !== getValue("confirm_password_field")) {
            alert("Wachtwoorden komen niet overeen.");
            return;
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./signup.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                window.location.href = "./";
            } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 403) {
                alert("Ongeldige inloggegevens ingevoerd.");
            }
        }

        const params = new URLSearchParams();
        params.append("firstName", getValue("firstname_field"));
        params.append("lastName", getValue("lastname_field"));
        params.append("email", getValue("email_field"));
        params.append("password", getValue("password_field"));
        params.append("confirmationPassword", getValue("confirm_password_field"));
        params.append("phoneNumber", getValue("phone_field"));
        params.append("birthDate", getValue("birthdate_field"));
        params.append("verifyCode", getValue("verification_code_field"));

        xhr.send(params.toString());

    }

    document.getElementById("submit_button").onclick = signUp;
});