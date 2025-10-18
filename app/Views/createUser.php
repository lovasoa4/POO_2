<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Créer un compte</title>
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- CSS -->
  <link rel="stylesheet" href="./assets/css/login.css"> <!-- On réutilise le même CSS -->
</head>
<body>
  <div class="login">
    <form action="/createUser" method="POST">
      <h1>Créer un compte</h1>

      <div class="input-container">
        <label for="name">Nom</label>
        <div class="input-field">
          <i class='bx bx-user'></i>
          <input type="text" id="name" placeholder="Votre nom" name="nom">
        </div>
      </div>

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

      <button type="submit" class="submit">Créer un compte</button>
    </form>
  </div>
</body>
</html>
