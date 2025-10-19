<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/transaction.css">
</head>
<body>
<div class="container-page">

  <div class="d-flex justify-content-between align-items-center mb-4 header-bar">
    <h2 class="page-title"><a href="/dashboard1">Cash Track</a></h2>

    <!-- Barre de recherche -->
    <form action="/recherche" method="post" class="d-flex align-items-center search-bar">
      <input 
        type="date" 
        name="date"
        class="form-control search-input"
        value="<?= htmlspecialchars($_POST['date'] ?? '') ?>"
      >
      <button type="submit" class="btn-search">
        <i class="bi bi-search"></i>
      </button>
    </form>

    <a href="/ajout" class="btn btn-add shadow-sm">
      <i class="bi bi-plus-circle me-1"></i> Ajouter une transaction
    </a>
  </div>

  <div class="card card-custom">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Type</th>
              <th>Date</th>
              <th>Montant (Ar)</th>
              <th>Description</th>
              <th>ID Utilisateur</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  if (!empty($tableau)) : ?>
              <?php foreach ($tableau as $transaction): 
                    $id = \App\Models\Transaction::getValue($transaction, 'id');
                    $type = \App\Models\Transaction::getValue($transaction, 'type');
                    $date_transaction = \App\Models\Transaction::getValue($transaction, 'date_transaction');
                    $montant = \App\Models\Transaction::getValue($transaction, 'montant');
                    $description = \App\Models\Transaction::getValue($transaction, 'description');
                    $id_user = \App\Models\Transaction::getValue($transaction, 'id_user');
              ?>
                <tr>
                  <td><?= htmlspecialchars($id) ?></td>
                  <td><?= htmlspecialchars($type) ?></td>
                  <td><?= $date_transaction ? date('d/m/Y', strtotime($date_transaction)) : '' ?></td>
                  <td class="fw-semibold text-success"><?= is_numeric($montant) ? number_format($montant, 0, ',', ' ') : htmlspecialchars($montant) ?></td>
                  <td><?= htmlspecialchars($description) ?></td>
                  <td><?= htmlspecialchars($id_user) ?></td>
                  <td>
                    <form action="/delete" method="post" class="d-inline">
                      <input type="hidden" name="id_delete" value="<?= htmlspecialchars($id) ?>">
                      <button type="submit" class="btn-action btn-delete"
                              onclick="return confirm('Supprimer cette transaction ?')">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="py-4 empty-message">
                  <?= isset($_POST['date']) && !empty($_POST['date']) ? "Aucune transaction pour cette date." : "Aucune transaction trouvée." ?>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
