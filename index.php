<?php 
    session_start(); 
    if(isset($_GET['salon'])) {
        $_SESSION['salon'] = (int)htmlspecialchars($_GET['salon']);
    }
    else {
        session_destroy();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include("meta.php"); ?>
    <title>Tchat - local</title>
</head>
<body>
    <div class="container" id="bloc">
        <div class="container-onglets">
            <div class="onglets <?php if(!isset($_GET['salon'])) {echo "active";} ?>" data-anim="1"><a href="index.php">Général</a></div>
            <div class="onglets <?php if(isset($_GET['salon']) && $_GET['salon'] == 1) {echo "active";} ?>" data-anim="2"><a href="index.php?salon=1">Salon 1</a></div>
            <div class="onglets <?php if(isset($_GET['salon']) && $_GET['salon'] == 2) {echo "active";} ?>" data-anim="3"><a href="index.php?salon=2">Salon 2</a></div>
            <div class="onglets <?php if(isset($_GET['salon']) && $_GET['salon'] == 3) {echo "active";} ?>" data-anim="3"><a href="index.php?salon=3">Salon 3</a></div>
            <div class="onglets <?php if(isset($_GET['salon']) && $_GET['salon'] == 4) {echo "active";} ?>" data-anim="3"><a href="index.php?salon=4">Salon 4</a></div>
        </div>
        <div class="container" id="bloc_msg">
            <div id="message">
                <div class="messages">
                    
                </div>
            </div>
        </div>
        <div id="tchat">
            <form action="script.php?task=write" method="POST">
                <div class="form-group">
                    <input class="form-control" type="text" name="author" placeholder="name ?" id="author">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="content" placeholder="Type in your message right here 🔥" id="content">
                </div>
                <div class="form-group">
                    <button class="btn" type="submit" id="btn" onclick="postMessage()"><i class="fa fa-send-o"></i></button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="script.js"></script> 
</body>
</html>