<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Utilisateur</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #667eea;
        }
        .error-box {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        .error-box ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .error-box li {
            margin-bottom: 5px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
            font-weight: 600;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .debug {
            background: #fff3cd;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ffc107;
            border-radius: 4px;
            font-size: 12px;
        }
        .info-box {
            background: #d1ecf1;
            color: #0c5460;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
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