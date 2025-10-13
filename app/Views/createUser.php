<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Créer un compte</title>
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- CSS -->
  <link rel="stylesheet" href="../../public/assets/css/login.css"> <!-- On réutilise le même CSS -->
</head>
<body>
  <div class="login">
    <form action="">
      <h1>Créer un compte</h1>

      <div class="input-container">
        <label for="name">Nom</label>
        <div class="input-field">
          <i class='bx bx-user'></i>
          <input type="text" id="name" placeholder="Votre nom">
        </div>
      </div>

      <div class="input-container">
        <label for="email">E-mail</label>
        <div class="input-field">
          <i class='bx bx-envelope'></i>
          <input type="email" id="email" placeholder="exemple@gmail.com">
        </div>
      </div>

      <div class="input-container">
        <label for="password">Mot de passe</label>
        <div class="input-field">
          <i class='bx bx-lock'></i>
          <input type="password" id="password" placeholder="Mot de passe">
        </div>
      </div>

      <div class="input-container">
        <label for="confirm-password">Confirmer le mot de passe</label>
        <div class="input-field">
          <i class='bx bx-lock-alt'></i>
          <input type="password" id="confirm-password" placeholder="Confirmer le mot de passe">
        </div>
      </div>

      <button type="submit" class="submit">Créer un compte</button>

      <div class="creer_compte">
        <p>Déjà un compte ? <a href="login.html">Se connecter</a></p>
      </div>
    </form>
  </div>
</body>
</html>
