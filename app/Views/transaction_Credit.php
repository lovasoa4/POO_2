<?php
// ----------------------
// Variables par défaut
// ----------------------
$search = $_GET['search'] ?? '';
$user_name = $_SESSION['nom'] ?? 'Invité'; // nom de l'utilisateur

// Récupérer les transactions Crédit depuis ton modèle Transaction
$tableau = App\Models\Transaction::getCredit($search);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Crédit</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles personnalisés -->
    <link rel="stylesheet" href="./assets/css/transaction_credit.css">

    <style>
        body {
            background-color: #f5f6f7;
            font-family: "Segoe UI", sans-serif;
        }

        .page-title {
            color: #198754;
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
            background-color: #2d744ba7;
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

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background: linear-gradient(180deg,#198754,#14532d);
            padding-top: 80px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #d1e8dc;
            text-decoration: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            padding-left: 25px;
        }

        .sidebar a i {
            font-size: 1.2rem;
            min-width: 22px;
        }

        /* ===== TOP NAVBAR ===== */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            height: 60px;
            background: linear-gradient(90deg,#0f5132,#198754);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 100;
        }

        .top-navbar .brand {
            font-weight: 700;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-navbar .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .top-navbar .user-info a {
            color: white;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,0.5);
            padding: 6px 12px;
            border-radius: 8px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .top-navbar .user-info a:hover {
            background: rgba(255,255,255,0.2);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 220px;
            padding-top: 80px;
            padding: 30px 40px;
        }

        @media(max-width:768px){
            .sidebar{width:200px;}
            .top-navbar {left:200px;}
            .main-content{margin-left:200px;}
        }
    </style>
</head>

<body>
    <!-- Navbar + Sidebar -->
    <header class="top-navbar">
        <div class="brand"><i class="bi bi-wallet2"></i> CashTrack</div>
        <div class="user-info">
            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($user_name) ?>
            <a href="/logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>
    </header>

    <aside class="sidebar">
        <h2>Navigation</h2>
        <a href="/dashboard"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
        <a href="/afficher"><i class="bi bi-transfer"></i> Transactions</a>
        <a href="/transaction_Credit"  class="active" ><i class="bi bi-plus-circle"></i> Crédit</a>
        <a href="/transaction_Debit"><i class="bi bi-dash-circle"></i> Débit</a>
        <a href="/ajout"><i class="bi bi-plus-square"></i> Ajouter transaction</a>
        <a href="/profil"><i class="bi bi-person"></i> Profil</a>
        <a href="/logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </aside>

    <!-- Contenu principal -->
    <main class="main-content">
        <div class="container py-4">
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
    </main>
</body>
</html>
