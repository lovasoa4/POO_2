<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Transaction</title>

    <!--  Lien Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--  Icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="card p-4">
                <h3 class="text-center text-primary mb-4">
                    <i class="bi bi-plus-circle"></i> Ajout d'une Transaction
                </h3>

                <form action="/ajout_Transaction" method="POST">

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="">-- Sélectionnez un type --</option>
                            <option value="credit">Crédit</option>
                            <option value="debit">Débit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Ex: Achat matériel" required>
                    </div>

                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" step="0.01" class="form-control" id="montant" name="montant" placeholder="Ex: 50000" required>
                    </div>

                    <div class="mb-3">
                        <label for="date_transaction" class="form-label">Date de transaction</label>
                        <input type="date" class="form-control" id="date_transaction" name="date_transaction" required>
                    </div>

                    <input type="hidden" name="id_user" value="1">

                    <div class="d-flex justify-content-between">
                        <a href="./ListeTransaction.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Enregistrer
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>