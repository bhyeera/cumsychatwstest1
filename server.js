// ############# WEBSOCKET SETUP SETTINGS #############
const express = require('express');
const http = require('http');
const WebSocket = require('ws');

const port = 3000;
const server = http.createServer(express);
const socketServer = new WebSocket.Server({ server })

// ############# CHAT BACKEND WEBSOCKET CODE #############
//
let parsedData;
let userQueue = [];
let userPeerId = []
let userMatch = [];
let onlineUsers = 0;
let caller = null;
let receiver = null;
let randomIndex;

socketServer.on('connection', socket => {
    // send message to user that they are connected to the web socket
    // update total online users (users on the page)
    if(onlineUsers>=0) {
        onlineUsers++;
    } else {
        onlineUsers = 0;
    }

// ########## SEND EVERY CLIENT THE NEW CONNECTION AND UPDATE ONLINE USERS ##########
    socketServer.clients.forEach(function each(client) {

        if(client.readyState == WebSocket.OPEN) {
            client.send('{"type":"update-online-users", "data": "'+ onlineUsers + '" }')
        }

    })

// ########## ROUTE THE ACTION DEPENDING ON MESSAGE TYPE ##########
    socket.on('message', data => {

        parsedData = JSON.parse(data);

        switch (parsedData.type) {
            case 'join-queue':
                socketJoinQueue(socket)
                break;

            case 'join-server':
                socketJoinServer(parsedData.data)
                break;

            default:
                // statements_def
                break;
        }

    })

    // socket.on('message', data => {

    //     socketServer.clients.forEach(function each(client) {

    //         if(client != socket && client.readyState == WebSocket.OPEN) {
    //             client.send(data);
    //         }

    //     })

    // })


    // print user connections on server + total users connected
    console.log('Total users online: ' + onlineUsers)
    // socket.send("hello guys")

    function socketJoinQueue(socket) {
        // console.log(socket.id)
        userQueue.push(socket.id);
        console.log('New user in queue! Total: ' + userQueue.length + ' awaiting match');
    }


    function socketJoinServer(peerId) {
        socket.id = peerId
        // userPeerId[socket] = peerId
        // console.log('peer id is ' + socket.id)
        // console.log('user peer id for this socket is ' + socket.id)
    }

    socket.on('close', () => {

        let userIndex = userQueue.indexOf(socket.id);
        if(userIndex != -1) {
            userQueue.splice(userIndex, 1);
        }
        onlineUsers--;
        console.log('A socket disconnected')

        socketServer.clients.forEach(function each(client) {

            if(client.readyState == WebSocket.OPEN) {
                client.send('{"type":"update-online-users", "data": "'+ onlineUsers + '" }')
            }

        })
    })

})

// pair matching
setInterval(() => {
    while(userQueue.length>0) {
        if(userQueue.length==1) {
            return;
        }
        // tell user he is caller
        //
        socketServer.clients.forEach(function each(client) {

            if(client.id == userQueue[0] && client.readyState == WebSocket.OPEN) {
                // console.log(userQueue[0])
                // console.log(client)
                // console.log('{"type":"partner-peer-id","data":"' + userQueue[1] + '"}');
                client.send('{"type":"partner-peer-id","data":"' + userQueue[1] + '"}');
            }

        })

        // tell user he is receiver
        socketServer.clients.forEach(function each(client) {

            if(client == userQueue[1] && client.readyState == WebSocket.OPEN) {
                // console.log(userQueue[1])
                // console.log(client)
                // console.log('{"type":"partner-peer-id","data":"' + userQueue[0] + '"}');
                client.send('{"type":"partner-peer-id","data":"' + userQueue[0] + '"}');
            }

        })

        userMatch[userQueue[0]] = userQueue[1];
        userMatch[userQueue[1]] = userQueue[0];

        // if(userIndex != -1) {
        userQueue.shift();
        userQueue.shift();

        // }

    // while(userQueue.length>0) {
        // randomIndex = Math.floor(Math.random() * userQueue.length);
        // if(caller == null) {
        //     // tell user he is caller
        //     io.to(userQueue[randomIndex]).emit('chat-message','you are caller');
        //     // if(userIndex != -1) {
        //     userQueue.splice(randomIndex, 1);
        //     caller = 1;
        //     // }
        // } else if (receiver == null) {
        //     // tell user he is receiver
        //     io.to(userQueue[randomIndex]).emit('chat-message','you are receiver');
        //     // if(userIndex != -1) {
        //         userQueue.splice(randomIndex, 1);
        //         receiver = 1;
        //     // }
        // } else {
        //     caller = null;
        //     receiver = null;
    // }
    }

    // socket.broadcast.to(userQueue[random]).emit('chat-message','your random is ' + random);
    // console.log('queue length is: ' +userQueue.length+ ' random is ');
}, 1000);

// ############# MAKE SERVER LISTEN ON PORT 3000 #############
server.listen(port, function() {
    console.log('Server listening in port ' + port)
})
