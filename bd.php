<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">📋 Liste des Clients</h1>
        
        <?php
        INCLUDE 'Client.php';

        $user = "root";
        $pass = "";
        $host = "localhost";
        $dbname = "expernetcda9";

        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

        $requete = $db->query("SELECT * FROM client");
        $requete->setFetchMode(PDO::FETCH_ASSOC);
        $data = $requete->fetchAll();
        
        // Création des objets Client
        $clients = [];
        foreach ($data as $row) {
            $clients[] = new Client($row['id'], $row['nom'], $row['prenom'], $row['titre'], $row['ville']);
        }
        ?>
        
        <div class="table-responsive">
            <table id="clientsTable" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Ville</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client->getId() ?? '') ?></td>
                        <td><?= htmlspecialchars($client->getNom() ?? '') ?></td>
                        <td><?= htmlspecialchars($client->getPrenom() ?? '') ?></td>
                        <td><?= htmlspecialchars($client->getTitre() ?? '') ?></td>
                        <td><?= htmlspecialchars($client->getVille() ?? '') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="text-center mt-3">
            <p class="text-muted">Total : <?= count($clients) ?> client(s)</p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#clientsTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Tous"]],
                order: [[1, 'asc']], // Tri par nom par défaut
                columnDefs: [
                    { orderable: false, targets: 0 } // Désactive le tri sur la colonne ID
                ]
            });
        });
    </script>
    
</body>
</html>