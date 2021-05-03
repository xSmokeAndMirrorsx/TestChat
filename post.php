<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    $idnum = $_POST['idnum'];
    $likeID = "like_".$idnum."_txt";
    $likebuttonID = "like_".$idnum;
    $commentID = "comment_".$idnum."_txt";
    $commentbuttonID = "comment_".$idnum;
     
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<p><span><input name='".$idnum."' type='submit' id='likeButton' value='Like' />  Likes: <b id='".$likeID."' value='0'></b></span></p><br></div>";
    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
}
?>
