function sendAjaxRequest(url){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            location.reload();
        }
    };
    request.open('GET', url);
    request.send();
}

function alert_delete(url){
    if(confirm("Etes-vous sûr de supprimer?") !== false){
        sendAjaxRequest(url);
    }
}