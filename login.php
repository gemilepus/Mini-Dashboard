<?php
require 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
// path & log level
$log->pushHandler(new StreamHandler('m.log', Logger::INFO));

session_start();

function getUserIP(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    }
    else {
        $ip = $remote;
    }
    return $ip;
}
$user_ip = getUserIP();


if ( ! empty( $_POST ) ) {
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
        // Getting submitted user data from database
//        $con = new mysqli($db_host, $db_user, $db_pass, $db_name);
//        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
//        $stmt->bind_param('s', $_POST['username']);
//        $stmt->execute();
//        $result = $stmt->get_result();
//    	$user = $result->fetch_object();
//
//    	 //Verify user password and set $_SESSION
//    	if ( password_verify( $_POST['password'], $user->password ) ) {
//    		$_SESSION['user_id'] = $user->ID;
//    	}
        $_SESSION['user_id'] = "id";

        $log->addInfo($user_ip." Login: ".$_POST['username']."  ");
    }
}


if ( isset( $_SESSION['user_id'] ) ) {
    header("Location: index.php");
}

?>

<?php
function footer_fixed() {
?>
    <hr class="footer-fixed">
    <div class="container footer-container">
        <div class="footer-links">
            <a href="">About</a>
        </div>
    </div>
<?php
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="https://pytorch.org/favicon.ico?">
    <title>Login</title>


    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
    <script src="js/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dashboard.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap-datetimepicker-standalone.min.css" />
</head>
<body class="text-center">
<div class="container">
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="">ヾ(・ω・ｏ)</a>
</nav>

<form class="form-signin" action="" method="post">
    <img class="mb-4" src="https://pytorch.org/assets/images/pytorch-logo.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="input-user-name" name="username" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" id="input-user-password" class="sr-only">Password</label>
    <input type="password" name="password"  class="form-control" placeholder="Password" required>
    <script>
        document.getElementById("input-user-name").value = "root@gmail.com";
    </script>
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-dark btn-block" type="submit" value="Submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted"> Power by ...</p>
</form>

<?php

//if form has been submitted process it
//      if(isset($_POST['submit']) AND isset($_POST['email']))
//      {
//          $email = $_POST['email'];
//          $postVeridator = new PostVeridator();
//          $userVeridator = new UserVeridator();
//          $userAction = new UserAction();
//          $log = new Log();
//          if($postVeridator->isValidEmail($email)) { // 信箱是否合法
//              if($userVeridator->isEmailDuplicate($email)) { // 信箱是否存在
//                  try {
//                      $resetToken = $userAction->getResetToken(); // 創建 Token 並存到資料庫
//                      $userAction->sendResetEmail($resetToken); // 用 Token 組出重置信件並寄出
//                      $userAction->redir2login(); // 重導向登入頁並顯示成功
//                  } catch(PDOException $e) {
//                      $error[] = $e->getMessage();
//                      $log->error(__FILE__, json_encode($error));
//                  }
//              }else{ // 不存在就假裝成功, 避免被試出會員信箱
//                  $log->warning(__FILE__, 'WRONG EMAIL: ' .$email);
//                  sleep(rand(1,2));
//                  $userAction->redir2login(); // 重導向登入頁並顯示成功
//                  exit;
//              }
//          } else { // 不合法就顯示踢回上一頁顯示錯誤
//              header('Location: ' . $_SERVER['HTTP_REFERER']);
//              exit;
//          }
//      }else{ // 非正常進入就踢回首頁
//          header('Location: ' . Config::BASE_URL);
//          exit;
//      }

footer_fixed();
?>
</div>
</body>
</html>