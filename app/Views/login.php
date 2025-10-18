<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Se connecter</title>
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- CSS -->
  <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>

  <?php 
  if(!empty ($Erreur)) {
    $message = htmlspecialchars_decode($Erreur);
    echo '<script> alert('.$Erreur.')</script>';
    $Erreur ="";
  }
  ?>

  <div class="login">
    <form action="/login" method="post">
      <h1>Se connecter</h1>

      <div class="input-container">
        <label for="email">E-mail</label>
        <div class="input-field">
          <i class='bx bx-envelope'></i>
          <input type="email" id="email" placeholder="exemple@gmail.com" name="email">
        </div>
      </div>

      <div class="input-container">
        <label for="password">Mot de passe</label>
        <div class="input-field">
          <i class='bx bx-lock'></i>
          <input type="password" id="password" placeholder="Mot de passe" name="mdp">
        </div>
      </div>

      <a href="/dashboard"><button type="submit" class="submit" >Se connecter</button></a>

      <div class="creer_compte">
        <p>Pas de compte ? <a href="/createUser">Créer un compte</a></p>
      </div>
    </form>
  </div>
</body>
</html>
