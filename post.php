<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    $idnum = $_POST['idnum'];
    $likeID = "like_".$idnum;
    $likebuttonID = "likeB_".$idnum;
    $commentID = "comment_".$idnum;
    $commentbuttonID = "commentB_".$idnum;
     
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<p><span><input name='like' type='submit' id='".$likebuttonID."' value='Like' />  Likes: <b id='".$likeID."'>0</b></span></p><br></div><script type='text/javascript'>$('#".$likebuttonID."').click(function(){var likeCount=parseInt($('#".$likeID."').val(), 10); likeCount=likeCount+1; $('#".$likeID."').val(likeCount); });</script>";
    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
}
?>
