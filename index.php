<?php

include('Voiture.php'); // Inclusion du fichier contenant la classe Voiture

$voiture1 = new Voiture("Peugeot", "3008", 120); // Création d'un nouvel objet Voiture
$voiture1->avancer(); // Affichera : "La voiture avance à une vitesse de 120 km/h."