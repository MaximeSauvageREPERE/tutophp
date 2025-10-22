<?php
// Balise d'ouverture PHP - début du code PHP

// Inclusion de la classe Voiture depuis le fichier Voiture.php
require_once 'Voiture.php';

// Démarrage d'une nouvelle session ou reprise d'une session existante
session_start();

// Vérification si le tableau 'voitures' existe dans la session
if (!isset($_SESSION['voitures'])) {
    // Si le tableau n'existe pas, on le crée vide
    $_SESSION['voitures'] = [];
}

// Vérification si le bouton "vider" a été cliqué
if (isset($_POST['vider'])) {
    // Réinitialisation du tableau des voitures (le vider complètement)
    $_SESSION['voitures'] = [];
    // Redirection vers la même page pour éviter la resoumission du formulaire
    header('Location: ' . $_SERVER['PHP_SELF']);
    // Arrêt de l'exécution du script après la redirection
    exit();
}

// Vérification si le formulaire a été soumis en POST et que ce n'est pas le bouton "vider"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['vider'])) {
    // Récupération de la valeur 'marque' du formulaire, suppression des espaces, valeur par défaut vide
    $marque = trim($_POST['marque'] ?? '');
    // Récupération de la valeur 'modele' du formulaire, suppression des espaces, valeur par défaut vide
    $modele = trim($_POST['modele'] ?? '');
    // Récupération de la valeur 'vitesse' du formulaire, suppression des espaces, valeur par défaut vide
    $vitesse = trim($_POST['vitesse'] ?? '');

    // Initialisation d'un tableau vide pour stocker les erreurs de validation
    $erreurs = [];
    
    // Validation : vérification si la marque est vide
    if (empty($marque)) $erreurs[] = "La marque est requise";
    // Validation : vérification si le modèle est vide
    if (empty($modele)) $erreurs[] = "Le modèle est requis";
    // Validation : vérification si la vitesse est un nombre et qu'elle est >= 0
    if (!is_numeric($vitesse) || $vitesse < 0) $erreurs[] = "La vitesse doit être un nombre positif";

    // Si aucune erreur n'a été trouvée
    if (empty($erreurs)) {
        // Création d'une nouvelle instance de la classe Voiture avec les données du formulaire
        $voiture = new Voiture($marque, $modele, (int)$vitesse);
        // Ajout de la nouvelle voiture au tableau des voitures en session
        $_SESSION['voitures'][] = $voiture;
        // Redirection vers la même page pour éviter la resoumission
        header('Location: ' . $_SERVER['PHP_SELF']);
        // Arrêt de l'exécution du script
        exit();
    } else {
        // Stockage des erreurs en session pour les afficher après la redirection
        $_SESSION['erreurs'] = $erreurs;
        // Redirection vers la même page
        header('Location: ' . $_SERVER['PHP_SELF']);
        // Arrêt de l'exécution du script
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des voitures</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Gestion des voitures</h1>

        <!-- Affichage des erreurs -->
        <?php if (isset($_SESSION['erreurs'])): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($_SESSION['erreurs'] as $erreur): ?>
                        <li><?= htmlspecialchars($erreur) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['erreurs']); ?>
        <?php endif; ?>

        <!-- Formulaire d'ajout -->
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="needs-validation mb-4" novalidate>
            <div class="mb-3">
                <label for="marque" class="form-label">Marque</label>
                <input type="text" class="form-control" id="marque" name="marque" required>
                <div class="invalid-feedback">La marque est requise</div>
            </div>

            <div class="mb-3">
                <label for="modele" class="form-label">Modèle</label>
                <input type="text" class="form-control" id="modele" name="modele" required>
                <div class="invalid-feedback">Le modèle est requis</div>
            </div>

            <div class="mb-3">
                <label for="vitesse" class="form-label">Vitesse (km/h)</label>
                <input type="number" class="form-control" id="vitesse" name="vitesse" min="0" required>
                <div class="invalid-feedback">Vitesse invalide</div>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>

        <!-- Liste des voitures -->
        <h2 class="mt-4">Liste des voitures</h2>
        
        <?php if (!empty($_SESSION['voitures'])): ?>
            <!-- Bouton pour vider la liste -->
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="mb-3">
                <button type="submit" name="vider" value="1" class="btn btn-danger">Vider la liste</button>
            </form>

            <!-- Tableau DataTables avec id="tableVoitures" -->
            <table id="tableVoitures" class="table table-striped">
                <thead>
                    <tr>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>Vitesse</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['voitures'] as $voiture): ?>
                        <tr>
                            <td><?= htmlspecialchars($voiture->getMarque()) ?></td>
                            <td><?= htmlspecialchars($voiture->getModele()) ?></td>
                            <td><?= htmlspecialchars($voiture->getVitesse()) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">Aucune voiture enregistrée.</p>
        <?php endif; ?>
    </div>

    <!-- jQuery (requis pour DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Initialisation de DataTables -->
    <script>
        $(document).ready(function() {
            // Initialisation du DataTable avec options en français
            $('#tableVoitures').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
                },
                pageLength: 10, // Nombre de lignes par page
                ordering: true,  // Activation du tri
                searching: true  // Activation de la recherche
            });
        });
    </script>
</body>
</html>