<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    $idnum = $_POST['idnum'];
    $likeID = "like_".$idnum;
    $likebuttonID = "likeB_".$idnum;
    $commentID = "comment_".$idnum;
    $commentbuttonID = "commentB_".$idnum;
     
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<p><span><button id='".$likebuttonID."' onclick='add_likes(".$likeID.")'> Like </button> -- Likes: <b id='".$likeID."'>0</b></span></p><br></div>";
    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
}
?>
