const socket = new WebSocket('ws://' + window.location.hostname + ':3000')
const peer = new Peer({host:'peerjs-server.herokuapp.com', secure:true, port:443})
console.log('Loading app...')


let offerJson = document.getElementById('offerJson');
let answerJson = document.getElementById('offerJson');
let dataChannel = null;
let incDataMsg = null;
let iceCandidatesArray = [];
let chatStarted = null;
let localPeerId;
let partnerId;
let partnerPeerId;
let parsedData;

peer.on('open', id => {
    localPeerId = id;
    socket.send('{"type":"join-server", "data":"' + localPeerId + '"}');
})

peer.on('call', call => {
    console.log('Receiving call')
    call.answer(localVideo.srcObject)

    call.on('stream', remoteVideoStream => {
        remoteVideo.srcObject = remoteVideoStream;
    })
})

socket.onopen = () => {
    console.log('Socket connection opened! Connected to ' + socket.url)
}

socket.onmessage = data => {
    console.log(JSON.parse(data.data))
    parsedData = JSON.parse(data.data)
    switch (parsedData.type) {

        case "update-online-users":
            document.getElementById("onlineusersnum").innerHTML = parsedData.data;
            break;

        case "partner-peer-id":
            connectToNewUser(parsedData.data, localVideo.srcObject)
            break;

        default:
            // statements_def
            break;
    }
}

// socket.on('partner-peer-id', partnerPeer => {
//     connectToNewUser(partnerPeer, localVideo.srcObject)
//     console.log(partnerPeerId)
// })
// // get id of matched partner
// socket.on('partner-id', data => {
//     partnerId = data;
// })

// socket.on('connect', () => {
//     // socket.emit('username','i am ' + socket.id)
//     // console.log("My socket id is: " + socket.id)
// })

// socket.on('connected-message', data => {
//     console.log(data)
// })

// socket.on('chat-message', data => {
//     console.log(data)
// })

// socket.on('user-do-disconnect', data => {
//     doNewChat()
// })

// socket.on('update-onlineusers', date => {
//     document.getElementById("onlineusersnum").innerHTML = date;
// })

const localVideo = document.getElementById("videoLocal");
const remoteVideo = document.getElementById("videoRemote");

const constraints = {
    'video': true,
    'audio': {'echoCancellation': true}
}

navigator.mediaDevices.getUserMedia(constraints)
.then(stream => {
    localVideo.srcObject = stream;
    localVideo.addEventListener('loadedmetadata', () => {
        localVideo.play()
    })
        // stream = streamResult;
})
.catch(error => {
     console.error('Error accessing media devices.', error);
});

async function connectToNewUser(userId, stream) {
    console.log('connecting to new peer user')
    const call = await peer.call(userId,stream)
    console.log(call)
    console.log(userId)
    console.log(stream)
    call.on('stream', remoteStream => {
        remoteVideo.srcObject = remoteStream;
        remoteVideo.addEventListener('loadedmetadata', () => {
            remoteVideo.play()
        })
    })
    call.on('close', () => {
        remoteVideo.srcObject = null;
    })

    document.getElementById('endchatbtn').addEventListener('click', () => {
        call.close()
        socket.emit('user-do-disconnect', partnerId);
    }, true)
}

function doNewChat() {
    remoteVideo.srcObject = null;
    socket.send('{"type":"join-queue", "data":"' + localPeerId + '"}');
}

function userDoNext() {
    socket.emit('user-do-disconnect', partnerId);
    doNewChat();
}

// console.clear();
console.log("CHAT APP SUCCESSFULLY LOADED!");
// async function getAnswer() {
//     // body...
//     var test;
//     returnAnswer()
//     .then(result => {
//        peerConnection.setRemoteDescription(JSON.parse(result));
//     })
//     .catch(error => {
//         console.error('Error accessing media devices.', error);
//     });

//     // await peerConnection.setRemoteDescription(JSON.parse(test));

// }
