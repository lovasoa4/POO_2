<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des Transactions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  ><link rel="stylesheet" href="./assets/css/transaction.css">
</head>

<body>

<div class="container py-5">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4 header-bar">
    <h2 class="page-title">📋 Liste des Transactions</h2>
    <a href="/ajout" class="btn btn-add shadow-sm">
      <i class="bi bi-plus-circle me-1"></i> Ajouter une transaction
    </a>
  </div>

  <!-- Tableau -->
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
            <?php if (!empty($tableau)) : ?>
              <?php foreach ($tableau as $transaction): ?>
                <tr>
                  <td><?= htmlspecialchars($transaction->getId()) ?></td>
                  <td><?= htmlspecialchars($transaction->getType()) ?></td>
                  <td><?= date('d/m/Y', strtotime($transaction->getDateTransaction())) ?></td>
                  <td class="fw-semibold text-success"><?= number_format($transaction->getMontant(), 0, ',', ' ') ?></td>
                  <td><?= htmlspecialchars($transaction->getDescription()) ?></td>
                  <td><?= htmlspecialchars($transaction->getIdUser()) ?></td>
                  <td>
                    <form action="/delete" method="post" class="d-inline">
                      <input type="hidden" name="id_delete" value="<?= $transaction->getId() ?>">
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
                <td colspan="7" class="py-4 empty-message">Aucune transaction trouvée.</td>
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
