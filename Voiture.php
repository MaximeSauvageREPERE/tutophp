<?php
// Balise d'ouverture PHP

// Déclaration de la classe Voiture
class Voiture {
    // Attibuts
    public $marque;    // Stocke la marque de la voiture
    public $modele;    // Stocke le modele de la voiture
    public $vitesse;    // Stocke la vitesse de la voiture

    // Constructeur
    public function __construct($marque, $modele, $vitesse) {
        $this->marque = $marque;
        $this->modele = $modele;
        $this->vitesse = $vitesse;
    }
    
    public function avancer () {
        echo "La voiture avance à une vitesse de " . $this->vitesse . " km/h.";
    }
}