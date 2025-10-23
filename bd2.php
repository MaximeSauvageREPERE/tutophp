<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Recherche de clients</title>
	<style>
		body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 24px; }
		h1 { margin-bottom: 16px; }
		form { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
		input[type="text"] { padding: 8px 10px; min-width: 260px; }
		button { padding: 8px 14px; cursor: pointer; }
		.hint { color: #666; margin-top: 6px; }
		.counter { color: #333; margin: 12px 0; }
		table { width: 100%; border-collapse: collapse; margin-top: 8px; }
		th, td { border: 1px solid #ddd; padding: 8px; }
		th { background: #f5f5f5; text-align: left; }
		tr:nth-child(even) { background: #fafafa; }
		.empty { color: #666; padding: 12px 0; }
		.error { color: #b00020; background: #fde7eb; padding: 10px; border: 1px solid #f5c2c7; }
	</style>
		<?php
		// 1) On récupère le terme de recherche saisi dans le formulaire (GET)
		// Si l'utilisateur a tapé dans le champ "recherche", on prend cette valeur, sinon on regarde si "q" existe (compatibilité)
		$termeRecherche = isset($_GET['recherche']) ? trim($_GET['recherche']) : (isset($_GET['q']) ? trim($_GET['q']) : '');

		// 2) On prépare les variables pour stocker la liste des clients et un éventuel message d'erreur
		$listeClients = [];
		$messageErreur = null;

	   try {
		   // On définit les informations de connexion à la base de données
		   $utilisateurSql = 'root'; // Nom d'utilisateur MySQL
		   $motDePasseSql = '';      // Mot de passe MySQL (vide par défaut sous WAMP)
		   $hoteSql = 'localhost';   // Adresse du serveur MySQL (localhost = local)
		   $nomBase = 'expernetcda9';// Nom de la base de données

		   // On crée la connexion PDO à la base de données
		   $connexion = new PDO(
			   "mysql:host=$hoteSql;dbname=$nomBase;charset=utf8", // Chaîne de connexion
			   $utilisateurSql, // Utilisateur
			   $motDePasseSql,  // Mot de passe
			   [
				   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // On veut des exceptions en cas d'erreur
				   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // On veut des tableaux associatifs
			   ]
		   );

		   // 3) On choisit la requête SQL à exécuter selon la présence d'une recherche
		   if ($termeRecherche === '') {
			   // Si aucun terme de recherche, on sélectionne tous les clients
			   $requeteSql = "SELECT id, nom, prenom, titre, ville FROM client ORDER BY nom, prenom";
			   $instruction = $connexion->query($requeteSql); // On exécute la requête directement
		   } else {
			   // Sinon, on prépare une requête avec filtre sur nom ou prénom
			   $requeteSql = "SELECT id, nom, prenom, titre, ville
						   FROM client
						   WHERE nom LIKE :q OR prenom LIKE :q
						   ORDER BY nom, prenom";
			   $instruction = $connexion->prepare($requeteSql); // On prépare la requête
			   $patternRecherche = "%" . $termeRecherche . "%"; // On ajoute les % pour le LIKE
			   $instruction->bindParam(':q', $patternRecherche, PDO::PARAM_STR); // On lie le paramètre
			   $instruction->execute(); // On exécute la requête préparée
		   }

		   // On récupère tous les résultats dans un tableau
		   $listeClients = $instruction->fetchAll();
	   } catch (Throwable $e) {
		   // En cas d'erreur (connexion ou requête), on stocke le message d'erreur
		   $messageErreur = $e->getMessage();
	   }
	?>
</head>
<body>
	<h1>Recherche de clients</h1>

	   <!-- Formulaire de recherche -->
	   <form method="get" action="bd2.php">
		   <!-- Champ texte pour saisir le nom ou prénom à rechercher -->
		   <input type="text" name="recherche" placeholder="Rechercher par nom ou prénom" value="<?= htmlspecialchars($termeRecherche ?? '') ?>" />
		   <!-- Bouton pour lancer la recherche -->
		   <button type="submit">Rechercher</button>
		   <!-- Message d'aide si aucun terme n'est saisi -->
		   <?php if ($termeRecherche === ''): ?>
			   <div class="hint">Entrez un nom ou un prénom puis validez.</div>
		   <?php endif; ?>
	   </form>

	   <?php if ($messageErreur): ?>
		   <!-- Affichage du message d'erreur s'il y a eu un souci -->
		   <div class="error">Erreur: <?= htmlspecialchars($messageErreur) ?></div>
	   <?php endif; ?>

	   <?php if (!$messageErreur): ?>
		   <!-- Affichage du compteur de résultats -->
		   <div class="counter">
			   <?php if ($termeRecherche === ''): ?>
				   <!-- Si pas de recherche, on affiche le nombre total de clients -->
				   Tous les clients (<?= count($listeClients) ?>)
			   <?php else: ?>
				   <!-- Sinon, on affiche le nombre de résultats pour la recherche -->
				   <?= count($listeClients) ?> résultat(s) pour « <?= htmlspecialchars($termeRecherche) ?> »
			   <?php endif; ?>
		   </div>

		   <?php if (count($listeClients) === 0): ?>
			   <!-- Message si aucun client trouvé -->
			   <div class="empty">Aucun client trouvé.</div>
		   <?php else: ?>
			   <!-- Tableau des clients trouvés -->
			   <table>
				   <thead>
					   <tr>
						   <th>#</th> <!-- Identifiant du client -->
						   <th>Nom</th>
						   <th>Prénom</th>
						   <th>Titre</th>
						   <th>Ville</th>
					   </tr>
				   </thead>
				   <tbody>
					   <?php foreach ($listeClients as $client): ?>
						   <tr>
							   <!-- Affichage de chaque champ du client -->
							   <td><?= htmlspecialchars($client['id'] ?? '') ?></td>
							   <td><?= htmlspecialchars($client['nom'] ?? '') ?></td>
							   <td><?= htmlspecialchars($client['prenom'] ?? '') ?></td>
							   <td><?= htmlspecialchars($client['titre'] ?? '') ?></td>
							   <td><?= htmlspecialchars($client['ville'] ?? '') ?></td>
						   </tr>
					   <?php endforeach; ?>
				   </tbody>
			   </table>
		   <?php endif; ?>
	   <?php endif; ?>

</body>
</html>