<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des Transactions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e9f5e9, #d7f0ff);
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
    }

    .page-title {
      font-weight: 700;
      color: #2b6777;
    }

    .btn-add {
      background: linear-gradient(45deg, #2ecc71, #27ae60);
      border: none;
      color: white;
      transition: all 0.3s;
    }

    .btn-add:hover {
      transform: scale(1.05);
      background: linear-gradient(45deg, #27ae60, #1e8449);
    }

    .card-custom {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      background-color: white;
    }

    .table th {
      background-color: #2b6777 !important;
      color: #fff;
      text-transform: uppercase;
      font-size: 0.9rem;
      letter-spacing: 1px;
    }

    .table tbody tr:hover {
      background-color: #f1f7f1;
      transform: scale(1.01);
      transition: all 0.2s;
    }

    .btn-action {
      border: none;
      padding: 5px 10px;
      border-radius: 8px;
      transition: all 0.2s;
    }

    .btn-edit {
      background-color: #f1c40f;
      color: white;
    }

    .btn-edit:hover {
      background-color: #d4ac0d;
    }

    .btn-delete {
      background-color: #e74c3c;
      color: white;
    }

    .btn-delete:hover {
      background-color: #c0392b;
    }

    .empty-message {
      color: #888;
      font-style: italic;
    }

    .header-bar {
      background: white;
      padding: 15px 25px;
      border-radius: 15px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .header-bar h2 {
      margin: 0;
      color: #2b6777;
    }

    .table-responsive {
      border-radius: 15px;
      overflow: hidden;
    }
  </style>
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
