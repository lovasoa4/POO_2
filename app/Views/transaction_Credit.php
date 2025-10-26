<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Crédit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/transaction_credit.css">
    
</head>

<body>
    <?php 
           include('navbar.php');
    ?>
    <div class="container py-5">
        <h2 class="text-center page-title">Transactions Crédit</h2>

        <!-- Barre retour + recherche -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/dashboard1" class="btn btn-outline-secondary btn-sm">⬅ Retour</a>

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
