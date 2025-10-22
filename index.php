<?php

include('Voiture.php');

$voiture1 = new Voiture("Peugeot", "3008", 100); // Création du premier objet Voiture
$voiture2 = new Voiture("Renault", "Clio", 90); // Création du deuxième objet Voiture

$voiture1->setVitesse(150); // Met à jour la vitesse de la voiture
$voiture2->setVitesse(110); // Met à jour la vitesse de la voiture

// Ajoutons des retours à la ligne pour plus de lisibilité
echo "Marque : " . $voiture1->getMarque() . "\n"; // Affiche la marque de la voiture
echo "Vitesse : " . $voiture1->getVitesse() . "\n"; // Affiche la vitesse actuelle de la voiture

echo "Marque : " . $voiture2->getMarque() . "\n"; // Affiche la marque de la voiture
echo "Vitesse : " . $voiture2->getVitesse() . "\n"; // Affiche la vitesse actuelle de la voiture         

$voiture1->avancer(); // Affichera : "La voiture Peugeot 3008 avance à une vitesse de 150 km/h."
$voiture2->avancer(); // Affichera : "La voiture Peugeot 3008 avance à une vitesse de 150 km/h."