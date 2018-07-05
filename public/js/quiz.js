var position=0;
var correct=0;
function affiche_question(){
  verif_fin();
  var question= document.getElementById('question_'+position).innerHTML;
  var reponse= document.getElementById('reponse_'+position).innerHTML;
  var choix = [1,2,3,4];
  choix = changetab(choix,position);
  var choix2= document.getElementById('choix2_'+position).innerHTML;
  var choix3= document.getElementById('choix3_'+position).innerHTML;
  var choix4= document.getElementById('choix4_'+position).innerHTML;

  var input_question = document.getElementById('zone_question');
  input_question.innerHTML = question;
  var input_reponse1 = document.getElementById('zone_reponse'+choix[0]);
  input_reponse1.innerHTML = "<input type='radio' name='choice' value='ok' ><label><h4>"+reponse+"</h4></label><br>";
  var input_reponse2 = document.getElementById('zone_reponse'+choix[1]);
  input_reponse2.innerHTML = "<input type='radio' name='choice' value="+choix2+" ><label><h4>"+choix2+"</h4></label><br>";
  var input_reponse3 = document.getElementById('zone_reponse'+choix[2]);
  if (choix3.length == 0 ) {
    input_reponse3.innerHTML = "<input type='radio' name='choice' class='secret'><br>";
  }else{
    input_reponse3.innerHTML = "<input type='radio' name='choice' value="+choix3+" ><label><h4>"+choix3+"</h4></label><br>";
  }
  var input_reponse4 = document.getElementById('zone_reponse'+choix[3]);
  if (choix4.length == 0) {
    input_reponse4.innerHTML = "<input type='radio' name='choice' class='secret' ><br>";
  }else{
  input_reponse4.innerHTML = "<input type='radio' name='choice' value="+choix4+" ><label><h4>"+choix4+"</h4></label><br>";
  }
}
function changetab(tab,position){
var temp=0;
var random1;
var random2;
var max=2;
if(document.getElementById('choix3_'+position).innerHTML != ""){
  max++;
}
if(document.getElementById('choix4_'+position).innerHTML != ""){
  max++;
}
for (var i = 0; i < 4 ; i++) {
  random1 = Math.floor(Math.random()*max);
  temp=tab[random1];
  random2 = Math.floor(Math.random()*max);7
  tab[random1]=tab[random2];
  tab[random2]=temp;
}
return tab;
}

function checkReponse(){
  if(position>0){
  var choice;
  var choices = document.getElementsByName("choice");
  var answer = document.getElementById("reponse_"+position).innerHTML;
  console.log(answer);
  for (var i = 0; i < choices.length; i++) {
    if (choices[i].checked) {
      choice = choices[i].value;
      console.log(choice);
    }
  }
  if (choice == 'ok') {
    correct++;
  }
}
  position++;
  affiche_question();
}

function verif_fin(){
  var length = document.getElementsByName('question').length;
  var zone = document.getElementById('zone_quiz');
  if (position > length) {
    zone.innerHTML = "<h2>FIN DU QUIZZ</h2><br><br><h2>Tu as "+correct+" questions correctes sur "+length+" questions. </h2> <br><br><a href='index.php?page=quizMenu'><button type='button'>Retournez au menu</button></a>";
    createMark();
  }
}
function createMark(){
  var user= document.getElementById('id_user').innerHTML;
  $.post("model/quizJquery.php",{
    user: user,
    quiz:getId(),
    mark:correct
  });
  console.log(user);
  console.log(getId());
  console.log(correct);
}
function getId(){
  var urlParametre = window.location.search.substring(1);
  urlParametre =urlParametre.split('&');
  urlParametre =urlParametre[1].split('=');
  return urlParametre[1];
}


//window.addEventListener("load", affiche_question, false);
