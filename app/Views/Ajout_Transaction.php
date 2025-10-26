<?php
// Démarrer la session si non déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Veuillez vous connecter avant d’ajouter une transaction.'); window.location.href='/login';</script>";
    exit;
}

$user_name = htmlspecialchars($_SESSION['nom'] ?? 'Utilisateur');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une transaction</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS séparé -->
    <link rel="stylesheet" href="./assets/css/Ajout_Transaction.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="app-navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="brand">
            <i class="bi bi-wallet2"></i> <span>CashTrack</span>
        </div>
        <div class="nav-right d-flex align-items-center gap-3">
            <div class="user-badge">
                <i class="bi bi-person-circle"></i>
                <span class="username"><?= $user_name ?></span>
            </div>
            <a href="/logout" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
    </div>
</nav>

<!-- MAIN -->
<main class="page-wrapper">
    <div class="container">
        <div class="card transaction-card">
            <div class="card-left">
                <div class="card-illustration">
                    <div class="circle1"></div>
                    <div class="circle2"></div>
                    <div class="icon-wrap">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                </div>
                <h2>Ajouter une transaction</h2>
                <p class="muted">Enregistrez un crédit ou un débit. Les montants seront associés à votre compte.</p>

                <ul class="tips">
                    <li><i class="bi bi-check-circle-fill"></i> Transactions privées — visibles seulement par vous</li>
                    <li><i class="bi bi-clock-history"></i> Date et heure personnalisables</li>
                </ul>
            </div>

            <div class="card-right">
                <form action="/ajout_Transaction" method="POST" id="formTransaction" novalidate>
                    <div class="row gx-2">
                        <div class="col-12 mb-3">
                            <label for="type" class="form-label">Type</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-arrow-repeat"></i></span>
                                <select class="form-select" name="type" id="type" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="Crédit">Crédit</option>
                                    <option value="Débit">Débit</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Ex : Vente, Achat fournitures..." required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="montant" class="form-label">Montant</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                <input type="number" step="0.01" class="form-control" id="montant" name="montant" placeholder="Ex : 50000" required>
                                <span class="input-group-text">Ar</span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_transaction" class="form-label">Date & heure</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <input type="datetime-local" class="form-control" id="date_transaction" name="date_transaction" required>
                            </div>
                        </div>

                        <!-- id_user caché -->
                        <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($_SESSION['id']); ?>">

                        <div class="col-12 d-flex justify-content-between mt-3">
                            <a href="/dashboard" class="btn btn-light-outline">
                                <i class="bi bi-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-success btn-save">
                                <i class="bi bi-save"></i> Enregistrer la transaction
                            </button>
                        </div>
                    </div>
                </form>
            </div> <!-- card-right -->
        </div> <!-- card -->
    </div> <!-- container -->
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Petit script client pour UX -->
<script>
document.getElementById('formTransaction').addEventListener('submit', function(e){
    // simple validation UX
    const type = document.getElementById('type').value.trim();
    const montant = document.getElementById('montant').value.trim();
    const date = document.getElementById('date_transaction').value.trim();
    if (!type || !montant || !date) {
        e.preventDefault();
        alert('Veuillez remplir correctement le type, le montant et la date.');
    }
});
</script>

</body>
</html>
