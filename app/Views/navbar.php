<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
      <link rel="stylesheet" href="./assets/css/transaction.css">
    <title>Document</title>
</head>
<body>
     <aside class="sidebar" style="width:240px; position:fixed; top:0; left:0; height:100%; background:#198754; color:#fff; padding:20px;">
   <nav class="navbar-custom">
    <h3><i class="bi bi-wallet2"></i> Cash Track</h3>

    <div class="nav-links">
      <a href="/dashboard"><i class="bi bi-house-door"></i> Tableau de bord</a>
      <a href="/afficher"><i class="bi bi-arrow-left-right"></i> Transactions</a>
      <a href="/transaction_Credit"><i class="bi bi-arrow-up-right-circle"></i> Crédit</a>
      <a href="/transaction_Debit"><i class="bi bi-arrow-down-right-circle"></i> Débit</a>
      <a href="/profil"><i class="bi bi-person-circle"></i> Profil</a>
      <a href="/login"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </div>

    <div class="user-info">
     
      <i class="bi bi-person-circle"></i>
       <span><?= htmlspecialchars($user_name) ?></span>
    </div>
  </nav>
  </aside>
</body>
</html>