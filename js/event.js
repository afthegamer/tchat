

/** Gestionnaire evenement SUBMIT dorm message
 * @param {object} event evenement submit 
 * @return {void}
 */
function submitMessage(event)
{
    // on stop la propagation des évènements. Donc plus de submit vers l'action du FORM
    event.preventDefault();
    
    // on récupère les données du formulaire à transmettre 
    // encodeURIComponent (https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Objets_globaux/encodeURIComponent) 
    // nous permet d'encoder les caractères spéciaux pour les transmettre dans notre requête
    let message = encodeURIComponent(document.querySelector('#message').value);
    
    // On va déclencher une requête Ajax vers le serveur
    const requesteSend = new XMLHttpRequest();
    requesteSend.onreadystatechange = function() {
        if (requesteSend.readyState === XMLHttpRequest.DONE) {
            if (requesteSend.status === 200) {
                document.querySelector('#message').value = '';
                /** On a reçu une réponse du serveur état 200
                 * On ne sait pas vraiment si le serveur a bien enregistré les données
                 * Mais on sait que la requête s'est bien passée !
                 * Maintenant on va tenter de récupérer les messages sur le serveur
                 * Pour mettre à jour uniquement les messages et pas toute la page
                 * On appelle une fonction updateMessage qui va s'occuper de ça !
                 */
                updateMessage();
            }
        }    
    }
    requesteSend.open('POST','api/tchat.php?request=save');
    requesteSend.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    requesteSend.send(`message=${message}&user=${userName}`);
}

/** Evenement qui déclenche un requête pour récuperer tous les messages sur le serveur !
 * @param {void}
 * @return {void}
 */
function updateMessage()
{
    console.log('Mise à jour des messages !');
    // On va faire une requête XHR vers un fichier PHP qui va nous founir tous les messages en JSON
    // On a déja un fichier capable de lire tous les messages index.php
    // On va faire un nouveau fichier qui reprend les bases de se dernier mais au lieu de transmettre du HTML il va transmettre du JSON
    
    const requesteUpdate = new XMLHttpRequest();
    requesteUpdate.onreadystatechange = function() {
        if (requesteUpdate.readyState === XMLHttpRequest.DONE) {
            if (requesteUpdate.status === 200) {
                let messages = JSON.parse(requesteUpdate.responseText);
                if(messages.length >= 1)
                    dateLastUpdateMessage = messages[messages.length-1].m_create_at;
                displayMessage(messages);
            }
        }    
    }
    
    if(firstLoad === true)
        requesteUpdate.open('GET','api/tchat.php?request=list');
    else
        requesteUpdate.open('GET',`api/tchat.php?request=listlast&date=${dateLastUpdateMessage}`);
        
    requesteUpdate.send();
}

function displayMessage(messages)
{
    
    let zoneHtml = document.querySelector('#tchat');
    
    if(firstLoad === true)
        zoneHtml.innerHTML = '';
    
    messages.forEach(message=>{
        
        let divMessage = document.createElement('div');
        divMessage.classList.add('message');
        
        if(message.m_username == userName)
            divMessage.classList.add('myMessage');
        
        let spanUser = document.createElement('span');
        spanUser.innerText = `${message.m_username} ${message.m_create_at}`;
        
        let pMessage = document.createElement('p');
        pMessage.innerText = message.m_content;
        
        divMessage.appendChild(spanUser).appendChild(pMessage);
        
        zoneHtml.appendChild(divMessage);
    });
    
    if(firstLoad === true)
        window.scrollTo(0,document.body.scrollHeight);
        
    firstLoad = false;
    
}

/** Gestionnaire d'évènement quand on click sur le submit du form pour demander le nom user
 * @param {object} event evenement submit
 * @return {void}
 */
function submitUserName(event)
{
    // on stop la propagation des évènements. Donc plus de submit vers l'action du FORM
    event.preventDefault();
    
    userName = encodeURIComponent(document.querySelector('#user').value);
    
    document.querySelector('#formUser').classList.add('hide');
    document.querySelector('#tchat').classList.remove('hide');
    document.querySelector('footer').classList.remove('hide');
    
    /** Maintenant que nous avons le nom d'utilisateur
     * On charge tous les messages et on déclenche le timer pour une recharge toutes les 5 secondes !
     */
    updateMessage(); // instant t de la première recharge 
    
    window.setInterval(updateMessage,UPDATE_TIME);
}