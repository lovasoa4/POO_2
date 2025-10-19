<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Crédit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f6f7;
            font-family: "Segoe UI", sans-serif;
        }

        .page-title {
            color: #198754; /* vert Bootstrap */
            font-weight: 700;
            margin-bottom: 30px;
        }

        .content-box {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .table th {
            background-color: #e9f7ef; /* vert très clair */
            color: #333;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .search-bar input {
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .btn-success {
            background-color: #198754;
            border: none;
        }

        .btn-success:hover {
            background-color: #146c43;
        }

        .alert {
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h2 class="text-center page-title">Transactions Crédit</h2>

        <!-- Barre retour + recherche -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/transactions" class="btn btn-outline-secondary btn-sm">⬅ Retour</a>

            <form method="GET" class="d-flex search-bar" style="max-width: 350px;">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Rechercher par description..."
                    value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit" class="btn btn-success">Rechercher</button>
            </form>
        </div>

        <!-- Tableau -->
        <div class="content-box">
            <?php if (!empty($tableau)): ?>
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Description</th>
                                <th>ID Utilisateur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tableau as $trans): ?>
                                <tr>
                                    <td><?= htmlspecialchars($trans->getId()); ?></td>
                                    <td><?= htmlspecialchars($trans->getType()); ?></td>
                                    <td><?= htmlspecialchars($trans->getDateTransaction()); ?></td>
                                    <td><strong><?= number_format($trans->getMontant(), 0, ',', ' '); ?> Ar</strong></td>
                                    <td><?= htmlspecialchars($trans->getDescription()); ?></td>
                                    <td><?= htmlspecialchars($trans->getIdUser()); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-secondary text-center">
                    Aucune transaction de type <strong>Crédit</strong> trouvée.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
