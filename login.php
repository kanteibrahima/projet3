<?php
session_start();

$erreur = "";

@$login = $_POST["login"];
@$pass = $_POST["pass"];
@$valider = $_POST["valider"];

if (isset($valider)) {

   $user = 'root';
   $passw = '';


   try {
      $db = new PDO('mysql:host=localhost;dbname=projet1php', $user, $passw);
   } catch (Exception $e) {
      die('Erreur :' . $e->getMessage());
   }
   $login = $_POST["login"];
   $pass = $_POST["pass"];

   if (!empty($login) && !empty($pass)) {
      if ($login != "") {
         if ($pass != "") {
            $query = $db->query("SELECT * FROM users WHERE email='$login' AND pass='$pass'");
            $query->execute(array());
            $rep = $query->fetch();
            $row = $query->rowCount();
            if ($rep['id'] != false) {
               $_SESSION["autoriser"] = "oui";
               header("location:session.php");
            }
            else{
               $erreur = "email or password inavalid";
            }
         } else {
            header('Location: index.php?login_err=password');
            die();
         }
      } else {
         header('Location: index.php?login_err=email');
         die();
      }
   } else {
      header("location:login.php");
      $erreur = 'veuillez tout remplir ';
   }
}
?>
<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8" />
   <style>
      * {
         font-family: arial;
      }

      body {
         margin: 20px;
      }

      input {
         border: solid 1px #2222AA;
         margin-bottom: 10px;
         padding: 16px;
         outline: none;
         border-radius: 6px;
      }

      .erreur {
         color: #CC0000;
         margin-bottom: 10px;
      }
   </style>
</head>

<body onLoad="document.fo.login.focus()">
   <h1>Authentification</h1>
   <div class="erreur"><?php echo $erreur ?></div>
   <form name="fo" method="POST" action="">
      <input type="email" name="login" placeholder="Login" /><br />
      <input type="password" name="pass" placeholder="Mot de passe" /><br />
      <input type="submit" name="valider" value="S'authentifier" />
   </form>
</body>

</html>