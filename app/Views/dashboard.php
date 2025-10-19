<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$userEmail = $_SESSION['email'] ?? 'Utilisateur';
$tabData = $tabData ?? [];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cash Track - Tableau de bord</title>
  <link rel="stylesheet" href="./assets/css/transaction.css">
  <link rel="stylesheet" href="./assets/css/dashboard.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    .main-content { margin-left: 240px; padding: 20px; }
    .topbar { display:flex; justify-content:flex-end; padding:10px 0; }
    .user-info { display:flex; align-items:center; gap:8px; color:#333; }
    .wrap { display:flex; flex-direction:column; gap:18px; max-width:1200px; margin:0 auto; }
    .card { background:#fff; border-radius:10px; padding:18px; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
    .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .table-wrap table { width:100%; border-collapse:collapse; }
    .table-wrap th, .table-wrap td { padding:10px; border:1px solid #eee; text-align:center; }
    .empty { text-align:center; padding:40px 10px; color:#666; }
    .pill { padding:6px 10px; border-radius:999px; color:#fff; font-weight:600; display:inline-block; }
    .income { background:#198754; }
    .expense { background:#c82333; }
    .neutral { background:#6c757d; }
    .badge { cursor:pointer; }
    .muted { color:#666; font-size:0.95rem; }
    .search input { padding:6px 10px; border-radius:6px; border:1px solid #ccc; }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar" style="width:240px; position:fixed; top:0; left:0; height:100%; background:#198754; color:#fff; padding:20px;">
    <h2 class="logo">Cash Track</h2>
    <nav class="menu">
      <a href="#" class="active" style="color:#fff; display:flex; align-items:center; gap:8px;"><i class='bx bx-grid-alt'></i> Tableau de bord</a>
      <a href="#" style="color:#fff; display:flex; align-items:center; gap:8px;"><i class='bx bx-user'></i> Utilisateurs</a>
      <a href="/afficher" style="color:#fff; display:flex; align-items:center; gap:8px;"><i class='bx bx-transfer-alt'></i> Transactions</a>
      <div class="submenu" style="padding-left:20px;">
        <a href="/transaction_Credit" style="color:#fff; display:flex; align-items:center; gap:8px;"><i class='bx bx-plus-circle'></i> Crédit</a>
        <a href="/transaction_Debit" style="color:#fff; display:flex; align-items:center; gap:8px;"><i class='bx bx-minus-circle'></i> Débit</a>
      </div>
      <a href="#" style="color:#fff; display:flex; align-items:center; gap:8px;"><i class='bx bx-phone-call'></i> Cas d'urgence</a>
    </nav>
  </aside>

  <!-- Contenu principal -->
  <div class="main-content">
    <header class="topbar">
      <div class="user-info">
        <i class='bx bx-user-circle' style="font-size:1.6rem;"></i>
        <span><?= htmlspecialchars($userEmail) ?></span>
      </div>
    </header>

    <section class="dashboard-content" style="width:100%;">
      <h1 style="text-align:center; margin-bottom:4vh;margin-top: -3vh;">Bienvenue sur le tableau de bord</h1>

      <div class="wrap">
        <div class="card">
          <div class="header">
            <div>
              <div class="title"><strong>Résumé</strong></div>
              <div class="subtitle" style="color:#666; font-size:0.95rem;">Vue des crédits / débits par mois</div>
            </div>
            <div class="controls">
              <form action="" method="post" style="display:flex;flex-direction:row; gap:10px;">
                <div class="search">
                  <input type="search" name="nom" placeholder="Chercher par nom, description..." style="width:40vh;" />
                </div>
                <button class="badge" style="border:none; padding:8px 12px; border-radius:6px; background:#0d6efd; color:#fff;">Rechercher</button>
                <button class="badge" type="button" disabled style="border:none; padding:8px 12px; border-radius:6px; background:#6c757d; color:#fff; opacity:0.9;">Exporter</button>
              </form>
            </div>
          </div>

          <div class="table-wrap">
            <?php if (!empty($tabData)) : ?>
              <table style="text-align:center;">
                <thead>
                  <tr>
                    <th>Utilisateur</th>
                    <th style="background-color: green;color:#f1f5f9;">Total Crédit</th>
                    <th style="background-color: red;color:#f1f5f9;">Total Débit</th>
                    <th style="background-color: orange;color:#f1f5f9;">Mois</th>
                    <th style="background-color: greenyellow;color:#000;">Année</th>
                    <th style="background-color: blue;color:#f1f5f9;">Évolution</th>
                    <th style="background-color: black;color:#f1f5f9;">Évaluation</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($tabData as $user) : ?>
                    <tr>
                      <td><?= htmlspecialchars($user->getIdUser()) ?></td>
                      <td><?= number_format($user->getCredit(),0,',',' ') ?> MGA</td>
                      <td><?= number_format($user->getDebit(),0,',',' ') ?> MGA</td>
                      <td><?= htmlspecialchars($user->getMois()) ?></td>
                      <td><?= htmlspecialchars($user->getAnnee()) ?></td>
                      <td><?= htmlspecialchars($user->getEvolution()) ?> %</td>
                      <td>
                        <?php
                        $eval = strtolower($user->getEvaluation());
                        if ($eval === 'benefice' || $eval === 'bénéfice') {
                          echo "<span class='pill income'>Bénéfice</span>";
                        } elseif ($eval === 'perte') {
                          echo "<span class='pill expense'>Perte</span>";
                        } else {
                          echo "<span class='pill neutral'>" . htmlspecialchars($eval) . "</span>";
                        }
                        ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <div class="empty">
                <h2>Aucune transaction effectuée</h2>
                <p>Effectuez une transaction pour commencer !</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="card" style="display:flex; justify-content:space-between; align-items:center;">
          <div class="muted">Affichage 1–10 de <?= count($tabData) ?></div>
          <div style="display:flex; gap:8px;">
            <button style="border:0;padding:8px 12px;border-radius:8px;background:#f1f5f9;">← Préc</button>
            <button style="border:0;padding:8px 12px;border-radius:8px;background:linear-gradient(90deg,#198754,#14532d);color:white;">Suiv →</button>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>
