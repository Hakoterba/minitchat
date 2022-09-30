<?php
    try{
        $db = new PDO('mysql:host=localhost:3306;dbname=tchat;charset=utf8mb4','root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e){
        echo "fail";
    }

    session_start();

    $task = "list";

    if(array_key_exists("task", $_GET)){
        $task = $_GET['task'];
    }

    if($task == "write"){
        postMessage();
    } 
    else {
        getMessages();
    }

    function getMessages(){
        global $db;
        if(isset($_SESSION['salon'])) {
            $salon =  $_SESSION['salon'];
        }
        else {
            $salon = 0;
        }
        $resultats = $db->query("SELECT * FROM messages WHERE salon='$salon' ORDER BY created_at DESC LIMIT 22");
        $messages = $resultats->fetchAll();
        echo json_encode($messages);
    }

    function postMessage(){
        global $db;
        if(!array_key_exists('author', $_POST) || !array_key_exists('content', $_POST) || strlen($_POST['author']) < 1 || strlen($_POST['content']) < 1){
            echo json_encode(["status" => "error", "message" => "One field or many have not been sent"]);
            return;
        }

        function smiley($txt) {
            $smiley = array(
                ":)" => '&#128578;',
                ":(" => '&#128577;',
                ":P" => '&#128539;',
                ":D" => '&#128512;',
                ":moon:" => '&#127770;',
                ":sun:" => '&#127773;',
                ":love:" => '&#128525;',
                ";)" => '&#128521;',
                ":kiss:" => '&#128536;',
                "8)" => '&#128526;',
                ":nokid:" => '&#128286;',
                ":kaaba:" => '&#128331;',
                ":mosquee:" => '&#128332;',
                ":trash:" => '&#128686;',
                ":clown:" => '&#129313;',
                "<3" => '&#1291505;',
                "</3" => '&#128148;',
                ":poop:" => '&#128169;',
                ":100:" => '&#128175;',
                ":fire:" => '&#128293;',
                ":angry:" => '&#128545;',
                ":cycliste:" => '&#128692;',
                ":nocycliste:" => '&#128691;',
                ":42:" => '&#9855;',
                ":reiner:" => "<img src='img/reiner.gif' height='50' class='my-1'>",
                ":b_transform:" => "<img src='img/b_transform.gif' height='50' class='my-1'>",
                ":eat:" => "<img src='img/eat.gif' height='50' class='my-1'>",
                ":fight:" => "<img src='img/fight.gif' height='50' class='my-1'>",
                ":nahnou:" => "<img src='img/nahnou.gif' height='50' class='my-1'>",
                ":ohoh:" => "<img src='img/ohoh.gif' height='50' class='my-1'>",
                ":omg:" => "<img src='img/omg.gif' height='50' class='my-1'>",
                ":pose:" => "<img src='img/pose.gif' height='50' class='my-1'>",
                ":ceasar:" => "<img src='img/ceasar.gif' height='50' class='my-1'>",
                ":rollerda:" => "<img src='img/rollerda.gif' height='50' class='my-1'>",
                ":sasageyo:" => "<img src='img/sasageyo.gif' height='50' class='my-1'>",
                ":warrior:" => "<img src='img/warrior.gif' height='50' class='my-1'>",
                ":yareyare:" => "<img src='img/yareyare.gif' height='50' class='my-1'>",
                ":zawarudo:" => "<img src='img/zawarudo.gif' height='50' class='my-1'>",
                ":zeke:" => "<img src='img/zeke.gif' height='50' class='my-1'>",
                ":now:" => "<img src='img/now.gif' height='50' class='my-1'>",
            );
            return str_replace(array_keys($smiley), array_values($smiley),$txt);
        }

        $author = htmlspecialchars($_POST['author']);
        $content = htmlspecialchars($_POST['content']);
        $content = smiley($content);
        if(isset($_SESSION['salon'])) {
            $salon =  $_SESSION['salon'];
        }
        else {
            $salon = 0;
        }
        $query = $db->prepare('INSERT INTO messages SET author = ?, content = ?, created_at = NOW(), salon = ?');
        $query->execute(array($author,$content,$salon));
        echo json_encode(["status" => "success"]);
    }
?>