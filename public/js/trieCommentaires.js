var trie = 1;
var trie_date = 1;
function trier_moyenne(){
  var commentaire = document.getElementsByName('commentaire');
  var mark = document.getElementsByName('avg');
  var i;
  var y;

  for(i=0;i<commentaire.length-1;i++){
    var markMin = mark[i].innerHTML;
    for(y=i+1;y<commentaire.length;y++){
      var markTest =mark[y].innerHTML;
      if (trie == 1){
        if (markTest > markMin) {
            commentaire[i].parentNode.insertBefore(commentaire[y],commentaire[i]);
            markMin=markTest;
        }
      }else if(trie == 0){
        if (markTest < markMin) {
          commentaire[i].parentNode.insertBefore(commentaire[y],commentaire[i]);
          markMin=markTest;
        }
      }
    }
  }
  if (trie == 1){
    trie = 0;
  }else if (trie == 0){
    trie = 1;
  }
}
function trier_date(){
  var commentaire = document.getElementsByName('commentaire');
  var date = document.getElementsByName('date');
  var i;
  var y;
  var k;
  var tmp;
  for(i=0;i<commentaire.length-1;i++){
    console.log(trie_date);
    var dateMin = date[i].innerHTML;
    console.log(dateMin);
    for(y=i+1;y<commentaire.length;y++){
      var dateTest =date[y].innerHTML;
      for (k=0;k<dateTest.length;k++){
      if (trie_date == 1){
        if (dateTest[k] > dateMin[k]) {
            console.log(dateTest);
            console.log(k);
            dateMin = dateTest;
            commentaire[i].parentNode.insertBefore(commentaire[y],commentaire[i]);
            break;
        }else if(dateTest[k] < dateMin[k]){
          break;
        }
      }else if(trie_date == 0){
        if (dateTest[k] < dateMin[k]) {
          dateMin = dateTest;
          commentaire[i].parentNode.insertBefore(commentaire[y],commentaire[i]);
          break;
        }else if(dateTest[k] > dateMin[k]){
          break;
        }
      }
    }
    }
  }
  if (trie_date == 1){
    trie_date = 0;
  }else if (trie_date == 0){
    trie_date = 1;
  }
}
