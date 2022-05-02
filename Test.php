<?php    
 session_start();
 $code = $_GET["code"];
 $appId = $common->getAppId(); // your app id
 $myUrl = $_SERVER['HTTP_REFERER'];
 $appSecret = $common->secret(); //your app secret
  if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
                 . $appId . "&redirect_uri=" . urlencode($myUrl) . "&state="
                 . $_SESSION['state']."&scope=email,publish_stream,user_likes";
      echo("<script> top.location.href='" . $dialog_url . "'</script>");
  }
  if($_GET['state'] == $_SESSION['state']){
     $token_url = "https://graph.facebook.com/oauth/access_token?"
            . "client_id=" . $appId . "&redirect_uri=" . urlencode($myUrl)
            . "&client_secret=" . $appSecret . "&code=" . $code;
     $response = file_get_contents($token_url);              
  }else{
     //CSRF  protection
    //Somebody or some file is attacking
  }
?>
