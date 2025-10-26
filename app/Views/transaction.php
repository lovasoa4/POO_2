<?php
$user_name = $_SESSION["nom"] ?? "Invité";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Transactions - Crédit / Débit</title>

  <!-- Liens CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="./assets/css/transaction.css">

  
</head>

<body>

  <!-- ======= NAVBAR ======= -->
  <nav class="navbar-custom">
    <h3><i class="bi bi-wallet2"></i> Cash Track</h3>

    <div class="nav-links">
      <a href="/dashboard"><i class="bi bi-house-door"></i> Tableau de bord</a>
      <a href="/afficher"><i class="bi bi-arrow-left-right"></i> Transactions</a>
      <a href="/transaction_Credit"><i class="bi bi-arrow-up-right-circle"></i> Crédit</a>
      <a href="/transaction_Debit"><i class="bi bi-arrow-down-right-circle"></i> Débit</a>
      <a href="/profil"><i class="bi bi-person-circle"></i> Profil</a>
      <a href="/login"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      <a href="/ajout">ajout transaction</a>
    </div>

    <div class="user-info">
     
      <i class="bi bi-person-circle"></i>
       <span><?= htmlspecialchars($user_name) ?></span>
    </div>
  </nav>

  <!-- ======= CONTENU ======= -->
  <div class="main-content">
    <h2 class="page-title">Historique des Transactions</h2>

    <!-- BARRE DE RECHERCHE PAR DATE -->
    <form method="GET" class="search-bar">
      <input type="text" id="date_debut" name="date_debut" placeholder="Date début" value="<?= $_GET['date_debut'] ?? '' ?>">
      <span>à</span>
      <input type="text" id="date_fin" name="date_fin" placeholder="Date fin" value="<?= $_GET['date_fin'] ?? '' ?>">
      <button type="submit" class="btn-search"><i class="bi bi-search"></i> Filtrer</button>
    </form>

    <!-- TABLEAU -->
    <div class="table-container">
      <div class="table-wrapper">
        <table class="table-fixed table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Description</th>
              <th>Crédit (Ar)</th>
              <th>Débit (Ar)</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $totalCredit = 0;
            $totalDebit = 0;

            $dateDebut = $_GET['date_debut'] ?? null;
            $dateFin = $_GET['date_fin'] ?? null;

            $filteredTableau = array_filter($tableau, function ($t) use ($dateDebut, $dateFin) {
              if (!$dateDebut && !$dateFin) return true;
              $date = strtotime($t['date_transaction']);
              if ($dateDebut && $date < strtotime($dateDebut)) return false;
              if ($dateFin && $date > strtotime($dateFin)) return false;
              return true;
            });

            if (!empty($filteredTableau)):
              foreach ($filteredTableau as $t):
                $totalCredit += $t['credit'] ?? 0;
                $totalDebit += $t['debit'] ?? 0;
            ?>
                <tr>
                  <td><?= htmlspecialchars($t['id']) ?></td>
                  <td><?= htmlspecialchars($t['description']) ?></td>
                  <td class="text-credit"><?= $t['credit'] ? number_format($t['credit'], 0, ',', ' ') : '—' ?></td>
                  <td class="text-debit"><?= $t['debit'] ? number_format($t['debit'], 0, ',', ' ') : '—' ?></td>
                  <td><?= date('d/m/Y H:i', strtotime($t['date_transaction'])) ?></td>
                  <td>
                    <form action="/delete" method="post" class="d-inline">
                      <input type="hidden" name="id_delete" value="<?= htmlspecialchars($t['id']) ?>">
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette transaction ?')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach;
            else: ?>
              <tr>
                <td colspan="6">Aucune transaction trouvée.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- TOTAUX -->
    <div class="totaux">
      <div class="card-total card-credit">
        <h5>Total Crédit</h5>
        <div class="value text-success"><?= number_format($totalCredit, 0, ',', ' ') ?> Ar</div>
      </div>
      <div class="card-total card-debit">
        <h5>Total Débit</h5>
        <div class="value text-danger"><?= number_format($totalDebit, 0, ',', ' ') ?> Ar</div>
      </div>
    </div>
  </div>

  <!-- Flatpickr Script -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#date_debut", {
      enableTime: true,
      dateFormat: "Y-m-d H:i",
      time_24hr: true,
      locale: "fr"
    });

    flatpickr("#date_fin", {
      enableTime: true,
      dateFormat: "Y-m-d H:i",
      time_24hr: true,
      locale: "fr"
    });
  </script>

</body>
</html>
