function analyse(){
  var nombre_question_actuel = document.getElementsByName('question_reponse').length;
  var input = document.getElementById("nombre_de_question");
  var nombre_voulu = input.options[input.selectedIndex].value;
  if (nombre_question_actuel > nombre_voulu) {
    reduire(nombre_voulu);
  }
  else{
    ajouter(nombre_question_actuel,nombre_voulu);
  }
}

function ajouter(nombre_question_actuel,nombre_voulu) {
  var zone_question = document.getElementById("zone_question");
  var ligne;
  var question_reponse;

  for (var i = nombre_question_actuel; i < nombre_voulu; i++) {
    question_reponse = document.createElement("div");
    question_reponse.setAttribute("name","question_reponse");
    //ZONE QUESTIONN
    creation_question(i,question_reponse);
    //ZONE REPONSE+CHOIX1
    ligne =document.createElement("div");
    ligne.className ="row";
    creation_reponse("col-sm-6","Réponse :","reponse"+(i+1),ligne,question_reponse);
    creation_reponse("col-sm-6","Choix 2:","choix_2_"+(i+1),ligne,question_reponse);
    //ZONE CHOIX2 ET CHOIX 3
    ligne =document.createElement("div");
    ligne.className ="row";
    creation_reponse("col-sm-6","Choix 3:","choix_3_"+(i+1),ligne,question_reponse);
    creation_reponse("col-sm-6","Choix 4:","choix_4_"+(i+1),ligne,question_reponse);
    zone_question.appendChild(question_reponse);
  }
}

function creation_reponse(class_colonne,texte_value,name,ligne,conteneur){
  var colonne = document.createElement("div");
  colonne.className= class_colonne;
  var texte = document.createElement("label");
  texte.innerHTML = texte_value;
  var crea_input = document.createElement("input")
  crea_input.setAttribute("type","text");
  crea_input.setAttribute("name",name);

  colonne.appendChild(texte);
  colonne.appendChild(crea_input);
  ligne.appendChild(colonne);
  conteneur.appendChild(ligne);

}
function creation_question(i,conteneur){
  var ligne=document.createElement("div");
  ligne.className = "row";
  var colonne = document.createElement("div");
  colonne.className ="col-sm-12";
  var texte=document.createElement("label");
  texte.innerHTML = "Question "+(i+1);
  var saut =document.createElement("br");
  var crea_input = document.createElement("textarea");
  crea_input.setAttribute("rows","2");
  crea_input.setAttribute("cols","100");
  crea_input.setAttribute("name","question"+(i+1));
  crea_input.style.resize="none";

  colonne.appendChild(texte);
  colonne.appendChild(saut);
  colonne.appendChild(crea_input);
  ligne.appendChild(colonne);
  conteneur.appendChild(ligne);

}
function reduire(nombre_voulu){
  var table_question = document.getElementsByName('question_reponse');
  var zone_question = document.getElementById('zone_question');
  var max = table_question.length;
  var remove;
  while (table_question.length >nombre_voulu) {
    table_question[table_question.length-1].parentNode.removeChild(table_question[table_question.length-1]);
  }

  }

function verification(){
  var title = document.getElementById('title');
  var zone_titre = document.getElementById('zone_titre');
  var table_question = document.getElementsByName('question_reponse');
  var error = 0;
  var question;
  var reponse;
  var choix1;

  if (title.value.length < 5 || title.value.length > 120) {
    erreur("erreur_titre","Il faut un titre entre 5 et 120 caractères",zone_titre);
    error = 1;
  }else {
    clean("erreur_titre");
  }
  for (var i = 1; i < table_question.length+1; i++) {
    question = document.getElementsByName('question'+i)[0];
    reponse = document.getElementsByName('reponse'+i)[0];
    choix1 = document.getElementsByName('choix_2_'+i)[0];
    choix3 = document.getElementsByName('choix_3_'+i)[0];
    if (question.value.length < 15) {
      erreur("erreur_question"+i,"La question doit avoir au minimum 15 caractères",question);
      error=1;
    }
    else {
      clean("erreur_question"+i);
    }
    if (reponse.value.length == 0 || choix1.value.length == 0) {
      erreur("erreur_reponse"+i,"il faut au minimum une réponse et le Choix 2.",choix3);
      error=1;
    }
    else{
      clean("erreur_reponse"+i);
    }
  }
  if (error==0) {
    return true;
  }else {
    return false;
  }
}
function erreur(nom_erreur,texte_erreur,apparition) {
  var id_erreur = document.getElementById(nom_erreur);
  if (!id_erreur) {
  var texte = document.createElement('p');
  texte.setAttribute("id",nom_erreur);
  texte.innerHTML = texte_erreur;
  texte.style.color ="red";
  apparition.parentNode.appendChild(texte);
}

}
function clean(id_erreur){
  var erreur = document.getElementById(id_erreur);
  if (erreur) {
    console.log(erreur);
    erreur.parentNode.removeChild(erreur);
  }
}
