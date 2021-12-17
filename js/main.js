/** 
 * On souhaite capter dans un premier temps la soumission du formulaire et récupérer les données
 * de ce formulaire ! 
 * Quel évènement déclencher ? 
 *  Déjà on commence à executer le JS uniquement si le DOM est chargé : DOMContentLoaded
 *  Puis il faut capter la soumission du FORM ? submit ? on regarde les évènements
 * Puis est-ce que notre fonction est appelé quand l'évènement se produit ?
 *  On test la fonction... on ne voit rien avec un console.log ? Que se passe t-il ? 
 *  Avec un alert() on voit des choses... mais quand on ferme la fenêtre => le formulaire est soumis donc rechargement de la page !
 *  Comment empêcher ça ? Ma fonction de callBack peut recevoir un paramètre, un objet event qui détail l'évènement qui se produit... et contient la propagation de l'évènement...
 *  Il nous faut empêcher cette propagation : preventDefault()
 * Maintenant que nous gérer la soumission de notre formulaire il va nous falloir faire notre requête HTTP POST nous même
 *  Pas de miracle on invente rien... on va chercher un exemple complet : https://developer.mozilla.org/fr/docs/Web/API/XMLHttpRequest/send
Voir Example: POST

 */
 
 
'use strict';

const UPDATE_TIME = 1000;

let userName = '';
let firstLoad = true;
let dateLastUpdateMessage = new Date();

document.addEventListener('DOMContentLoaded',function(){
    
    document.querySelector('#formMessage').addEventListener('submit',submitMessage);
    document.querySelector('#form').addEventListener('submit',submitUserName);
    

});