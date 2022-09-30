window.onload = function() {
    let msgBox = document.getElementById('bloc_msg');
    msgBox.scrollTop = msgBox.scrollHeight;
}

function getMessages(){
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("GET", "script.php");
    
    requeteAjax.onload = function(){
    const resultat = JSON.parse(requeteAjax.responseText);
    const html = resultat.reverse().map(function(message){
        return `
        <div class="message">
            <span class="date">${message.created_at.substring(11, 16)}</span>
            <span class="author"><strong>${message.author}</strong></span> :             
            <span class="content">${message.content}</span>
        </div>
        `
    }).join('');
        const messages = document.querySelector('.messages');
        messages.innerHTML = html;
        messages.scrollTop = messages.scrollHeight;
    }
    let msgBox = document.getElementById('bloc_msg');
    msgBox.scrollTop = msgBox.scrollHeight;
    requeteAjax.send();
}

function postMessage(event){
    event.preventDefault();

    const author = document.querySelector('#author');
    const content = document.querySelector('#content');
    const data = new FormData();

    data.append('author', author.value);
    data.append('content', content.value);
    
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open('POST', 'script.php?task=write');
    
    requeteAjax.onload = function(){
        content.value = '';
        content.focus();
        getMessages();
    }
    requeteAjax.send(data);
}

document.querySelector('form').addEventListener('submit', postMessage);
const interval = window.setInterval(getMessages, 3000);
getMessages();

const onglets = document.querySelectorAll('a');
const contenu = document.querySelectorAll('.contenu');
let index = 0;

onglets.forEach(onglet => {
    onglet.addEventListener('click', () => {
        if(onglet.classList.contains('active')) {
            return;
        }
        else {
            onglet.classList.add('active');
        }

        index = onglet.getAttribute('data-anim');
        for(i = 0;i < onglets.length; i++) {
            if(onglets[i].getAttribute('data-anim') != index) {
                onglets[i].classList.remove('active');
            }
        }
    })
})