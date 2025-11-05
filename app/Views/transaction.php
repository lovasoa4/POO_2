<?php
$user_name = $_SESSION["nom"] ?? "Invité";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Transactions - CashTrack</title>

  <!-- Liens CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f7f9f8;
      margin: 0;
      display: flex;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
      width: 240px;
      background: #198754;
      color: #fff;
      height: 100vh;
      padding: 25px 20px;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .navbar-custom h3 {
      font-weight: 700;
      font-size: 1.3rem;
      margin-bottom: 30px;
      text-align: center;
    }

    .nav-links a {
      display: block;
      color: #fff;
      text-decoration: none;
      padding: 10px 15px;
      margin-bottom: 10px;
      border-radius: 8px;
      transition: all 0.3s;
      font-size: 0.95rem;
    }

    .nav-links a:hover, .nav-links a.active {
      background: #157347;
    }

    .user-info {
      text-align: center;
      border-top: 1px solid rgba(255,255,255,0.3);
      padding-top: 15px;
      font-size: 0.95rem;
    }

    /* ===== TOP BAR ===== */
    .topbar {
      position: fixed;
      top: 0;
      left: 240px;
      height: 60px;
      width: calc(100% - 240px);
      background: #47915dff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 0 25px;
      z-index: 10;
    }

    .topbar .user {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 500;
      color: #ffffffff;
    }

    .topbar .user i {
      font-size: 1.6rem;
    }

    /* ===== MAIN CONTENT ===== */
    .main-content {
      margin-left: 260px;
      margin-top: 80px; /* pour laisser la place à la topbar */
      padding: 25px;
      width: calc(100% - 260px);
      overflow: hidden;
    }

    .page-title {
      font-weight: 600;
      color: #198754;
      margin-bottom: 25px;
    }

    /* ===== SEARCH BAR ===== */
    .search-bar {
      display: flex;
      gap: 10px;
      align-items: center;
      background: #fff;
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-bottom: 25px;
    }

    .search-bar input {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 8px 12px;
      flex: 1;
    }

    .btn-search {
      background: #198754;
      color: #fff;
      border: none;
      padding: 8px 15px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-search:hover {
      background: #157347;
    }

    /* ===== TABLE ===== */
    .table-container {
      background: #fff;
      border-radius: 12px;
      padding: 0;
      box-shadow: 0 3px 8px rgba(0,0,0,0.08);
      overflow: hidden;
    }

    .table-scroll {
      max-height: 400px; /* limite de hauteur du tableau */
      overflow-y: auto;
      overflow-x: auto;
    }

    table {
      width: 100%;
      min-width: 900px;
      border-collapse: collapse;
    }

    th {
      background-color: #20a567ff;
      color: #fff;
      padding: 12px;
      text-align: center;
      font-weight: 600;
      position: sticky;
      top: 0;
      z-index: 2;
    }

    td {
      text-align: center;
      padding: 10px;
      border-bottom: 1px solid #eee;
    }

    .text-credit {
      color: #198754;
      font-weight: 600;
    }

    .text-debit {
      color: #dc3545;
      font-weight: 600;
    }

    tr:hover {
      background-color: #f8fdf8;
    }

    /* ===== TOTAUX ===== */
    .totaux {
      display: flex;
      justify-content: space-around;
      margin-top: 30px;
    }

    .card-total {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.08);
      width: 45%;
      padding: 20px;
      text-align: center;
    }

    .card-credit h5 {
      color: #198754;
    }

    .card-debit h5 {
      color: #dc3545;
    }

    .value {
      font-size: 1.5rem;
      font-weight: 700;
    }
  </style>
</head>

<body>

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <nav class="navbar-custom">
      <h3><i class="bi bi-wallet2"></i> CashTrack</h3>
      <div class="nav-links">
        <a href="/dashboard"><i class="bi bi-house-door"></i> Tableau de bord</a>
        <a href="/afficher" class="active"><i class="bi bi-arrow-left-right"></i> Transactions</a>
        <a href="/transaction_Credit"><i class="bi bi-arrow-up-right-circle"></i> Crédit</a>
        <a href="/transaction_Debit"><i class="bi bi-arrow-down-right-circle"></i> Débit</a>
        <a href="/ajout"><i class="bi bi-plus-circle"></i> Ajouter transaction</a>
           <a href="/logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      </div>
     
    </nav>
  </aside>

  <!-- ===== TOP BAR ===== -->
  <div class="topbar">
    <div class="user">
      <i class="bi bi-person-circle"></i>
      <span><?= htmlspecialchars($user_name) ?></span>
    </div>
  </div>

  <!-- ===== MAIN CONTENT ===== -->
  <main class="main-content">
    <h2 class="page-title">Historique des Transactions</h2>

    <!-- Barre de recherche -->
    <form method="GET" class="search-bar">
      <input type="text" id="date_debut" name="date_debut" placeholder="Date début" value="<?= $_GET['date_debut'] ?? '' ?>">
      <span>à</span>
      <input type="text" id="date_fin" name="date_fin" placeholder="Date fin" value="<?= $_GET['date_fin'] ?? '' ?>">
      <button type="submit" class="btn-search"><i class="bi bi-search"></i> Filtrer</button>
    </form>

    <!-- Tableau -->
    <div class="table-container">
      <div class="table-scroll">
        <table class="table table-hover align-middle mb-0">
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
                $credit = ($t['type'] === 'Crédit') ? floatval($t['montant']) : 0;
                $debit = ($t['type'] === 'Débit') ? floatval($t['montant']) : 0;
                $totalCredit += $credit;
                $totalDebit += $debit;
            ?>
                <tr>
                  <td><?= htmlspecialchars($t['id']) ?></td>
                  <td><?= htmlspecialchars($t['description']) ?></td>
                  <td class="text-credit"><?= $credit ? number_format($credit, 0, ',', ' ') : '—' ?></td>
                  <td class="text-debit"><?= $debit ? number_format($debit, 0, ',', ' ') : '—' ?></td>
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

    <!-- Totaux -->
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
  </main>

  <!-- Flatpickr -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#date_debut", { enableTime: true, dateFormat: "Y-m-d H:i", time_24hr: true });
    flatpickr("#date_fin", { enableTime: true, dateFormat: "Y-m-d H:i", time_24hr: true });
  </script>
</body>
</html>
