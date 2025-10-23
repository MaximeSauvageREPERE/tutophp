<?php

class Client {
    private $id;
    private $nom;
    private $prenom;
    private $titre;
    private $ville;

    public function __construct($id = null, $nom = null, $prenom = null, $titre = null, $ville = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->titre = $titre;
        $this->ville = $ville;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }
    
    public function getTitre() {
        return $this->titre;
    }

    public function getVille() {
        return $this->ville;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setVille($ville) {
        $this->ville = $ville;
    }

    
}