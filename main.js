let messagesMainWrap = document.getElementById("messages");
let chatAreaBox = document.getElementById("chatwrap");
let contentBox = document.getElementById("contentBox");
let nextChatBtn = document.getElementById('nextchatbtn');
// update sent message for local user
let msgSbmtBtn = document.getElementById("messageSubmitButton");
let msgSbmtInpt = document.getElementById("messageSubmitInput");
let messageParagraph;
let localChatWrap;
let remoteChatWrap;
let msgScrollHeight;
let footer = document.getElementById("footer");
let startChatBtn = document.getElementById("startChattingButton");
let jsErrWarn = document.getElementById("javascripterror");
let adultConsentAlert = document.getElementById("adultconsentwrap");


let newMessageTone = document.getElementById("newMessageAudio");
newMessageTone.volume = 0.1;
let newPartnerTone = document.getElementById("newPartnerAudio");
newPartnerTone.volume = 0.1;

jsErrWarn.remove();

function sendMessage(event) {
    event.preventDefault();
    if(!(/^ *$/.test(msgSbmtInpt.value))) {
        localChatWrap = document.createElement("div");
        localChatWrap.className = "localChat";
        messageParagraph = document.createElement("p");
        messageParagraph.innerText = msgSbmtInpt.value;
        dataChannel.send('{"type": "instant-message","content": "'+msgSbmtInpt.value+'"}');
        messagesMainWrap.appendChild(localChatWrap);
        localChatWrap.appendChild(messageParagraph);
        msgScrollHeight = messagesMainWrap.scrollHeight;
        messagesMainWrap.scroll(0, msgScrollHeight);
        window.scroll(0,60);
        msgSbmtInpt.value = "";
        msgSbmtInpt.blur();
    } else {
        msgSbmtInpt.value = "";
    }
}

function receiveMessage(message) {
        newMessageTone.play();
        remoteChatWrap = document.createElement("div");
        remoteChatWrap.className = "remoteChat";
        messageParagraph = document.createElement("p");
        messageParagraph.innerText = message;
        messagesMainWrap.appendChild(remoteChatWrap);
        remoteChatWrap.appendChild(messageParagraph);
        msgScrollHeight = messagesMainWrap.scrollHeight;
        messagesMainWrap.scroll(0, msgScrollHeight);
        window.scroll(0,60);
}

startChatBtn.addEventListener("click", function() {
    startChatBtn.hidden = true;
    checkAdultConsentSessionToken();
}, true);

function showChat() {
    doNewChat();
    setTimeout(() => {
        adultConsentAlert.remove();
        contentBox.hidden = true;
        chatAreaBox.hidden = false;
    },1000)
}

function checkAdultConsentSessionToken() {
        $.ajax({
            type: "POST",
            url: 'php/setconsenttoken.php',
            dataType: "html",
        })
        .then(result => {
            if(!result || result == "false") {
                adultConsentAlert.hidden = false;
            } else {
                showChat();
            }
        })
        .catch(error => {
            console.error('[JQUERY] An getting adult consent token', error);
        });
}

 function setAdultConsentSessionToken() {
        $.ajax({
            type: "POST",
            data: {'adultconsent': "true"},
            url: 'php/setconsenttoken.php',
            dataType: "html",
        })
        .then(() => {
            showChat();
        })
        .catch(error => {
            console.error('[JQUERY] Error setting adultconsenttoken', error);
        });
}

function leaveWebsite() {
    location.href = "http://www.google.com";
    location.replace("http://www.google.com");
    window.onunload = function(){
    location.history.go(-(location.history.length)+1);
    };
}

function inputFocusScroll() {
    window.scroll(0,60);
}

nextChatBtn.addEventListener("click", () => {
    userDoNext()
}, true);
// document.getElementsByClassName("bodywrapper")[0].style.height = window.innerHeight+"px";
//
// footer position
// window.onresize = function(event) {
//     document.getElementsByClassName("bodywrapper")[0].style.height = window.innerHeight+"px";
//     if(window.innerHeight>window.innerWidth) {
//         footer.style.position = 'fixed';
//         footer.style.bottom = "0px";
//     } else {
//         footer.style.position = 'static';
//         footer.style.bottom = "";
//     }
// };
