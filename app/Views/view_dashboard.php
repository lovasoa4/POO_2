<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cash Track - Tableau de bord</title>
  <link rel="stylesheet" href="./assets/css/transaction.css">
  <link rel="stylesheet" href="./assets/css/dashboard.css">

  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

  <!-- Sidebar -->

  <!-- Contenu principal à droite -->
  <div class="main-content" style="margin-left:  240px;">
    <!-- Barre du haut -->
    <header class="topbar">
      <div class="user-info">
        <i class='bx bx-user-circle'></i>
        <a href="/deconnection"><span><?php echo htmlspecialchars($_SESSION['email']) ?></span></a>
      </div>
    </header>

    <!-- Contenu du tableau de bord -->
    <section class="dashboard-content" style="margin: 0 auto; width:100%">
      <h1 style="text-align:center; margin-bottom:4vh;margin-top: -3vh;">Bienvenue sur le tableau de bord</h1>
      <p style="text-align:center;"></p>
      <div class="wrap">
        <div class="card">
          <div class="header">
            <div>
              <div class="title"><a href=""></a></div>
              <div class="subtitle"></div>
            </div>
            <div class="controls">
              <form action="" method="post" style="display:flex;flex-direction:row;">
                <div class="search">
                  <input type="search" name="nom" placeholder="Chercher par nom, description..." style="width:40vh;" />
                </div>
                <button class="badge" style="border: none;">Exporter</button>
              </form>
            </div>
          </div>

          <div class="table-wrap">
            <?php if (isset($tabData) && !empty($tabData)) : ?>
              <table style="text-align: center;">
                <thead>
                  <tr style="text-align: center;">
                    <th style="text-align: center;">Utilisateur</th>
                    <th style="text-align: center;background-color: green;color:#f1f5f9;">Total credit</th>
                    <th style="text-align: center;background-color: red;color:#f1f5f9;">Total debit</th>
                    <th style="text-align: center;background-color: orange;color:#f1f5f9;">Mois</th>
                    <th style="text-align: center;background-color: greenyellow;color:#f1f5f9;">Annee</th>
                    <th style="text-align: center;background-color: blue;color:#f1f5f9;">evolution</th>
                    <th style="text-align: center;background-color: black;color:#f1f5f9;">evaluation</th>

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($tabData as $user) : ?>
                    <tr>
                      <td><?= htmlspecialchars($user->getIdUser()) ?></td>
                      <td><?= htmlspecialchars($user->getCredit()) ?> MGA</td>
                      <td><?= htmlspecialchars($user->getDebit()) ?> MGA</td>
                      <td><?= htmlspecialchars($user->getMois()) ?></td>
                      <td><?= htmlspecialchars($user->getAnnee()) ?></td>
                      <td><?= htmlspecialchars($user->getEvolution()) ?> %</td>
                      <td>
                        <?php
                        if ($user->getEvaluation() == 'benefice') {
                          echo "<span class='pill income'>" . $user->getEvaluation() . "</span>";
                        } elseif ($user->getEvaluation() == 'perte') {
                          echo "<span class='pill expense'>" . $user->getEvaluation() . "</span>";
                        }
                        ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <div class="empty">
                <h2>Aucune transaction effectuer</h2>
                <p>effectuer une transaction !</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="card">
          <div style="display:flex;justify-content:space-between;align-items:center">
            <div class="muted">Affichage 1–10 de 234</div>
            <div style="display:flex;gap:8px">
              <button style="border:0;padding:8px 12px;border-radius:8px;background:#f1f5f9">← Préc</button>
              <button style="border:0;padding:8px 12px;border-radius:8px;background:linear-gradient(90deg,var(--accent),var(--accent-2));color:white">Suiv →</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

</body>

</html>