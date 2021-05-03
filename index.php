<?php
 
session_start();
 
if(isset($_GET['logout'])){    
     
    //Simple exit message
    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
     
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
 
function loginForm(){
    echo
    '<div id="loginform">
    <p>Please enter your name to continue!</p>
    <form action="index.php" method="post">
      <label for="name">Name &mdash;</label>
      <input type="text" name="name" id="name" />
      <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
  </div>';
}
 
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
 
        <title>Tuts+ Chat Application</title>
        <meta name="description" content="WROTTiT" />
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
    <?php
    if(!isset($_SESSION['name'])){
        loginForm();
    }
    else {
    ?>
         <style>
            div.cent{
                text-align: center;
            }
         </style>
     
         <!--Header Div-->
         <div class="cent" style="background-color:dimgrey ">
            <h1 class="multicolor" style="color:white;">WROTiTT</h1>
            <h2 class="multicolor" id="uName">Welcome, <?php echo $_SESSION['name']; ?></h2>
            <p></p>
        </div>
     
         <!-- Div containing 3 vertical divs -->
    <div style="background-color:dimgrey; min-height:100%">
      <!-- Social Div -->
      <div class ="cent" style="display: inline-block; *display: inline; width: 19%; background-color: slategrey; vertical-align: top;">
        <div class ="cent" style="background-color: grey;">
            <h2 class ="multicolor">Social: Friends & Events</h2>
        </div>
            <h3 id = "correct_count">Friends Yay</h3>
            <h2 id = "correct"></h2>
            <!-- <ul id = "correct-answers"></ul> -->
      </div>
      
      <!-- Posting and Feed div -->
      <div class ="cent" style = "display: inline-block; *display: inline; width: 60%; background-color: silver; vertical-align: top;">
        <div id="wrapper">
            <div id="menu">
                <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
                <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
            </div>
 
            <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("log.html") > 0){
                $contents = file_get_contents("log.html");          
                echo $contents;
            }
            ?>
            </div>
 
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>
      </div>
      <!-- Profile Options Div -->
      <div class ="cent" style="display: inline-block; *display: inline; width: 19%; background-color: slategrey; vertical-align: top; height: 100%;">
        <div class="cent" style="background-color: grey;">
          <h2 class ="multicolor">User: Profile and Options</h2>
            </div>
	       <h3 id = "profName"><?php echo $_SESSION['name']; ?>'s Profile Settings</h3>
        <p></p>
        Customize Word Color: <input type = "color" id = "wordColor">
      </div>
          
    </div>
       
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
	    	var postCount = 0;
		
            $(document).ready(function () {
                $("#submitmsg").click(function () {
		    postCount = postCount + 1;
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg, idnum: postCount });
                    $("#usermsg").val("");
                    return false;
                });
 
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
 
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div
 
                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }   
                        }
                    });
                }
 
                setInterval (loadLog, 2000);
 
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
            });
         
                 //function used to change the color of the headers based on user input
        var changeColorHandler = function (evt){
            let mycolor = evt.currentTarget.value
            var elements = document.getElementsByClassName("multicolor");
            for(var i=0; i<elements.length; i++){
              elements[i].style.color = mycolor;
            }
        }
        
        document.querySelector("#wordColor").addEventListener(
            "change",
            changeColorHandler
        )
        </script>
    </body>
</html>
<?php
}
?>
