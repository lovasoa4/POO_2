<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/assets/css/form.css">
    <title>Formulaire Utilisateur</title>
   
</head>
<body>
    <div class="form-container">
        <!-- Debug info -->
        <div class="debug">
            <strong>🔍 Debug Info:</strong><br>
            Fichier: <?= __FILE__ ?><br>
            Méthode: <?= $_SERVER['REQUEST_METHOD'] ?><br>
            Action du formulaire: /users/store
        </div>

        <h1>📝 Ajouter un Utilisateur</h1>
        <p class="subtitle">Remplissez le formulaire ci-dessous</p>
        
        <div class="info-box">
            ℹ️ Les données seront ajoutées en mémoire et perdues au rechargement
        </div>
        
        <?php
        // Afficher les erreurs s'il y en a
        if (isset($_SESSION['errors'])) {
            echo '<div class="error-box">';
            echo '<strong>⚠️ Erreurs :</strong>';
            echo '<ul>';
            foreach ($_SESSION['errors'] as $error) {
                echo '<li>' . htmlspecialchars($error) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
            unset($_SESSION['errors']);
        }
        
        // Récupérer les anciennes valeurs
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
        ?>
        sss   <?php echo $vola ?>
        <form action="/users/store" method="POST">
            <div class="form-group">
                <label for="name">👤 Nom complet *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                    placeholder="Ex: Jean Dupont"
                    required
                    autofocus
                >
            </div>
            
            <div class="form-group">
                <label for="email">📧 Adresse email *</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    placeholder="Ex: jean.dupont@example.com"
                    required
                >
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    ✅ Créer
                </button>
                <a href="/users" class="btn btn-secondary">
                    ❌ Annuler
                </a>
            </div>
        </form>
        
        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
        
        <div style="text-align: center; color: #999; font-size: 12px;">
            <p>🧪 Mode Test - Données statiques</p>
        </div>
    </div>
</body>
</html>