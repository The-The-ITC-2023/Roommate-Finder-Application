function getID(oObject) {
    var id = oObject.id;
    var msg = document.getElementById(id).innerHTML;
    document.cookie = 'email = ' + msg;
}