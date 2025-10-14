<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cash Track - Tableau de bord</title>
  <link rel="stylesheet" href="./assets/css/dashboard.css">
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="container">
    
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo"> Cash Track</h2>
      <nav class="menu">
        <a href="#" class="active"><i class='bx bx-grid-alt'></i> Tableau de bord</a>
        <a href="#"><i class='bx bx-user'></i> Utilisateurs</a>
        <a href="#"><i class='bx bx-transfer-alt'></i> Transactions</a>
        <div class="submenu">
          <a href="#"><i class='bx bx-plus-circle'></i> Crédit</a>
          <a href="#"><i class='bx bx-minus-circle'></i> Débit</a>
        </div>
        <a href="#"><i class='bx bx-phone-call'></i> Cas d'urgence</a>
      </nav>
    </aside>

    <!-- Contenu principal à droite -->
    <div class="main-content">
      <!-- Barre du haut -->
      <header class="topbar">
        <div class="user-info">
          <i class='bx bx-user-circle'></i>
          <span>USER NAME</span>
        </div>
      </header>

      <!-- Contenu du tableau de bord -->
      <section class="dashboard-content">
        <h1>Bienvenue sur le tableau de bord</h1>
        <p>Ici s'afficheront les crédits, débits ou autres informations importantes.</p>
      </section>
    </div>

  </div>
</body>
</html>
