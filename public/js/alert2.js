function alert_delete_account() {
    if(confirm("Etes-vous sûr de supprimer?") !== false){
        document.location.href="index.php?page=user&section=param&action=deleteAccount"
    }
}

function alert_delete_user(id){
  var answer = confirm( "Etes-vous sûr de supprimer?");
  if( answer == false){

  }else{
    document.location.href="index.php?page=user&section=admin&action=deleteUser&id="+id;
  }
}
function alert_delete_sheet(id){
  var answer = confirm("Etes-vous sûr de supprimer?");
  if (answer == false){

  }else {
    document.location.href="index.php?page=user&section=admin&action=deleteSheet&id="+id;
  }
}
function alert_delete_sheets(){
  var answer = confirm( "Etes-vous sûr de supprimer?");
  if( answer == false){
  document.location.href ="index.php?page=user&section=admin&action=sheetsModif"
  }else{
    document.location.href="index.php?page=user&section=admin&action=clearTableSheets"
  }
}
function alert_delete_all_users(){
  var answer = confirm( "Etes-vous sûr de supprimer?");
  if( answer == false){
    document.location.href="index.php?page=user&section=admin&action=usersModif";

  }else{
    document.location.href="index.php?page=user&section=admin&action=clearTableUser";
  }
}
function alert_comment(){
  alert("Vous n'etes pas connecté");
}
function alert_delete_quiz(id){
  var answer = confirm("Etes-vous sûr de supprimer?");
  if (answer == false){

  }else {
    document.location.href="index.php?page=user&section=admin&action=deleteQuiz&id="+id;
  }
}
