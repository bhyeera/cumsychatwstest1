<?php
session_start();
if (!isset($_SESSION['userid'])) {
    $_SESSION['userid'] = "anon_".sha1(rand(10000000,99999999));
}
// echo $_SESSION['userid']
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script>
    <script defer src="chatapp.js"></script>
    <link rel="stylesheet" href="bootstrap-icons-1.2.2\font\bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <title>Cumsy - Video chat with random people.</title>
</head>
<body>
    <div id="navbarmain">
        <div id="navbar">
            <a href="index.php">
                <div id="navbarlogowrap">
                    <h4>Cumsy</h4>
                </div>
            </a>
            <a href="">Login <span>PREMIUM</span></a>
        </div>
    </div>

    <div class="bodywrapper">

        <div id="javascripterror">
            <h1><i class="bi bi-exclamation-octagon"></i> ERROR</h1>
            <h3>SOMETHING WENT WRONG WITH JAVASCRIPT IN YOUR BROWSER</h3>
            <h4>Please refresh the page or check if your browser is compatible.</h4>
        </div>

        <div id="chatwrap" hidden>

            <div id="videos">
                <div id="chatcontrols">
                    <button id="giftchatbtn" onclick="console.log('clicked gift')"; style="left:10px;"><i class="bi bi-gift-fill"></i></button>
                    <div id="giftsBtnsWrapper">
                        <button id="giftchatbtn" onclick="console.log('clicked gift')"; ><i class="bi bi-flower1"></i> Flower</button>
                        <button id="giftchatbtn" onclick="console.log('clicked gift')"; ><i class="bi bi-sunglasses"></i> Sunglasses</button>
                        <button id="giftchatbtn" onclick="console.log('clicked gift')"; ><i class="bi bi-watch"></i> Watch</button>
                        <button id="giftchatbtn" onclick="console.log('clicked gift')"; ><i class="bi bi-gift-fill"></i></button>
                    </div>
                    <button id="endchatbtn"><i class="bi bi-power"></i> STOP</button>
                    <button id="nextchatbtn">NEXT <i class="bi bi-reply-fill"></i></button>
                </div>
                <video id="videoLocal" autoplay muted></video>
                <video id="videoRemote" autoplay></video>
            </div>

            <div id="chatarea">

                <div id="messages">

                </div>

                <div id="chatInputArea">
                    <form action="#" id="messageAreaForm" onsubmit="sendMessage(event);">
                        <input id="messageSubmitInput" type="text" id="messageBox" autocomplete="off" placeholder="Type your message here to start chatting!" onfocus="inputFocusScroll();">
                        <input id="messageSubmitButton" type="button" value="Send" onclick="sendMessage(event);">
                    </form>
                </div>

            </div>
        </div>

        <div id="adultconsentwrap" hidden>
            <h3><i class="bi bi-exclamation-triangle-fill"></i> WARNING! POSSIBLE ADULT CONTENT!</h3>
            <h4>Confirm you are over 18 years old:</h4>
            <h5>We have no control over the actions of the users in our website which means that adult content might be found during your use. If you are over 18 years old and accept this condition please press continue. If you are under 18 or do not feel comfortable with the possibility of finding adult content press the leave button.</h5>
            <button id="adultconsentcontinue" onclick="showChat();">Continue</button>
            <button id="adultconsentleave" onclick="leaveWebsite();">Leave</button>
        </div>

        <div id="contentBox">
            <button id="startChattingButton">START CHAT</button>
            <h1>Start chatting with other people, earn cash!</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae sint amet nisi doloremque recusandae perferendis. Porro unde architecto voluptatibus veritatis ratione. Quae, sunt voluptatibus vero vel ea inventore voluptatem natus repellat eum culpa accusantium, sint odio eius, odit in, dolorem deserunt quas reiciendis numquam quis ratione assumenda. Adipisci magni facere eos facilis dolorum voluptatem vero repellat maxime mollitia ipsam. Odit veritatis laborum vel dolorem consequuntur veniam distinctio quos dolorum, sunt totam laboriosam ipsam impedit cumque a excepturi deleniti tenetur rem saepe, quae, quas animi doloribus. Quae, consectetur iste autem commodi officiis explicabo, quaerat, tempore totam ipsum laudantium ab maxime porro?</p>
        </div>

            <div id="currentonlineusers">
                <p><i class="bi bi-people-fill"> </i>Online: <span id="onlineusersnum">0</span></p>
            </div>
    </div>

    <div id="footer">
        <div id="footerWrap">
            <div id="footerleft">
                <h4>Cumsy - Video chat with strangers!</h4>
                <br>
                <img src="img/cumsylogosmall.png" alt="CumsyLogo">
                <br>
                <p>Est. 2020.</p>
                <br>
                <p>We are created with the purpose to provide every user a exciting experience in online video chatting. Join us in this adventure and see if the next stranger could be your new friend or lover!</p>
            </div>
            <div id="footercenter">
                <h4>Useful links:</h4>
                <br>
                <a href="">Privacy Policy</a>
                <br>
                <a href="">User responsability</a>
                <br>
                <a href="">Terms and Conditions</a>
                <br>
                <a href="">FAQs</a>
                <br>
                <a href="">Contact form</a>
                <br>
                <br>
                <p>Support E-mail:</p>
                <a href="mailto:name@email.com">support@cumsy.com</a>
            </div>
            <div id="footerright">
                <h4>Social:</h4>
                <br>
                <a href="">Instagram</a>
                <br>
                <a href="">Twitter</a>
                <br>
                <a href="">Facebook</a>
                <br>
                <br>
                <h4>Accepted payments:</h4>
                <br>
                <a href="">Visa</a>
                <br>
                <a href="">Maestro</a>
                <br>
                <a href="">American Express</a>
                <br>
                <a href="">Bitcoin</a>
            </div>
        </div>
        <div id="bottomfooter">
            <p>Copyright © 2020 | Juan Gouveia - <a href="mailto:name@email.com">webmaster@cumsy.com</a></p>
        </div>
    </div>

    <audio id="newMessageAudio">
        <source src="newMessage.mp3" type="audio/mpeg">
      Your browser does not support the audio element.
    </audio>

    <audio id="newPartnerAudio">
        <source src="newPartner.mp3" type="audio/mpeg">
      Your browser does not support the audio element.
    </audio>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="main.js"></script>
    <!-- <script type="text/javascript" src="network.js"></script> -->
    <!-- <script type="text/javascript" src="js/chatapp.js"></script> -->
</body>
</html>
