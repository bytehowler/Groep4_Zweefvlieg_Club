function fetchMessages(messageId = 0, removeMessage = 0) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            document.getElementById("frame").innerHTML = response.message;
        }
    };
    xhr.open("POST", "./admin/messages.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("message_id=" + messageId + "&remove_flag=" + removeMessage);
}

function deleteMail(id) {
    console.log(id);
}