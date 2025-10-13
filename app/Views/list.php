<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/assets/css/list.css">
    <title>Liste des Utilisateurs</title>

</head>
<body>
    <div class="container">
        <!-- Debug info -->
        <div class="debug">
            <strong>🔍 Debug Info:</strong><br>
            Fichier: <?= __FILE__ ?><br>
            Nombre d'utilisateurs: <?= isset($users) ? count($users) : 0 ?>
        </div>

        <h1>Liste des Utilisateurs</h1>
        
        <a href="/users/form" class="btn">➕ Ajouter un utilisateur</a>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                ✅ <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>


        xxxxxxxxxxxx =  <?php die($harena ) ?> =vvvvvvvvvvvv



        <?php if (isset($users) && !empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td>
                            <form action="/users/delete" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn-delete" 
                                        onclick="return confirm('Supprimer cet utilisateur ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">
                <h2>Aucun utilisateur trouvé</h2>
                <p>Commencez par en ajouter un !</p>
            </div>
        <?php endif; ?>
        
        <hr style="margin: 30px 0;">
        <p style="color: #666; font-size: 14px;">
            💡 Note : Les données sont en mémoire et seront perdues au rechargement de la page.
        </p>
    </div>
</body>
</html>