function filter(tableau,button,filtrePar) {
  var input = document.getElementById(button);
  var filter = input.value.toUpperCase();
  var table = document.getElementById(tableau);
  var tr = table.getElementsByTagName("tr");
  var i;
  var td;
  var filterBy = document.getElementsByName(filtrePar)[0].value;
  console.log(filterBy);

  for(i=0; i<tr.length;i++) {
    td=tr[i].getElementsByTagName("td")[filterBy];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
       tr[i].style.display = "";
     }else {
       tr[i].style.display = "none";
     }
    }
  }
}

function filtrefiche() {
  var inputName = document.getElementById("choixNomFiche");
  var inputMatiere = document.getElementById("choixMatiere");
  var inputEtude = document.getElementById("Etude");
  var filtreEtude = inputEtude.options[inputEtude.selectedIndex].value.toUpperCase();
  var filtreName = inputName.value.toUpperCase();
  var filtreMatiere = inputMatiere.value.toUpperCase();
  var tableau =['',filtreName,filtreEtude,filtreMatiere];
  var liste = document.getElementById("liste_fiche");
  var ul = liste.getElementsByTagName("ul");
  var i;
  var y;
  var li;
  var isOk;

  for (i = 0; i < ul.length; i++) {
    isOk = 0 ;
    for (y=1;y<tableau.length;y++){
      li=ul[i].getElementsByTagName("li")[y];
      if(li) {
        if(li.innerHTML.toUpperCase().indexOf(tableau[y]) > -1){
        }else {
          isOk ++;
        }
      }
    }
    if (isOk == 0){
      ul[i].style.display = "";
    }else{
      ul[i].style.display = "none";
    }
  }
}
function fiche(){
  var type = getElementById("type");
  alert('coucou');
}
