<?php

class Produit {
    private ?int $id;
    private string $nom;
    private float $prix;
    private int $seuilAlerte;
    private int $quantiteDisponible;

    public function __construct( ?int $id = null, string $nom = '', float $prix = 0.00, int $seuilAlerte = 0, int $quantiteDisponible = 0) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->seuilAlerte = $seuilAlerte;
        $this->quantiteDisponible = $quantiteDisponible;
    }
    public function setId(int $id): void 
{
    $this->id = $id;
}
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getNom(): string 
    {
        return $this->nom;
    }

    public function setNom(string $nom): void 
    {
        $this->nom = $nom;
    }

    public function getPrix(): float 
    {
        return $this->prix;
    }

    public function setPrix(float $prix): void  {
        $this->prix = $prix;
    }

    public function getSeuilAlerte(): int  {
        return $this->seuilAlerte;
    }

    public function setSeuilAlerte(int $seuilAlerte): void  {
        $this->seuilAlerte = $seuilAlerte;
    }

    public function getQuantiteDisponible(): int  {
        return $this->quantiteDisponible;
    }

    public function setQuantiteDisponible(int $quantiteDisponible): void {
        $this->quantiteDisponible = $quantiteDisponible;
    }
    public function estEnAlerte(): bool  {
        return $this->quantiteDisponible <= $this->seuilAlerte;
    }
}
