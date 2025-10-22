<?php
// Balise d'ouverture PHP

// Déclaration de la classe Voiture
class Voiture {
    // Attributs privés
    private $marque;    // Marque de la voiture
    private $modele;    // Modèle de la voiture
    private $vitesse;   // Vitesse actuelle de la voiture

    // Constructeur
    public function __construct($marque, $modele, $vitesse) { // Initialisation des attributs
        $this->marque = $marque; // Marque de la voiture
        $this->modele = $modele; // Modèle de la voiture
        $this->vitesse = $vitesse; //   Vitesse initiale de la voiture
    }

    // Getters
    public function getMarque() { // Retourne la marque de la voiture
        return $this->marque; // Marque de la voiture
    }

    public function getModele() { // Retourne le modèle de la voiture
        return $this->modele; // Modèle de la voiture
    }

    public function getVitesse() { // Retourne la vitesse actuelle de la voiture
        return $this->vitesse; // Vitesse actuelle de la voiture
    }

    // Setters
    public function setVitesse($vitesse) { // Définit la vitesse actuelle de la voiture
        $this->vitesse = $vitesse; // Nouvelle vitesse de la voiture
    }
    
    public function avancer() { // Affiche la vitesse actuelle de la voiture
        echo "La voiture " . $this->marque . " " . $this->modele . // Marque et modèle de la voiture
             " avance à une vitesse de " . $this->vitesse . " km/h." . PHP_EOL; // Vitesse actuelle de la voiture
    }
}

?>