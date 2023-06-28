function fetchPlanes() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            document.getElementById("frame").innerHTML = response.message;
        }
    };
    xhr.open("POST", "./admin/planes.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
}

function addPlane(tailId, modelName, year, manufacturer, nickname) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            document.getElementById("frame").innerHTML = response.message;
        }
    };
    xhr.open("POST", "./admin/planes.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("tail_id="+tailId+"&model_name="+modelName+"&year="+year+"&manufacturer="+manufacturer+"&nickname="+nickname);
}