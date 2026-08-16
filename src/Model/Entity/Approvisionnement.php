<?php

class Approvisionnement {
    private ?int $id;
    private string $date;
    private float $montantTotal;
    private string $statut;
    private Fournisseur $fournisseur;

    public function __construct( ?int $id = null, string $date = '', float $montantTotal = 0.00,  string $statut = 'EN_COURS',  ?Fournisseur $fournisseur = null) {
        $this->id = $id;
        $this->date = $date;
        $this->montantTotal = $montantTotal;
        $this->statut = $statut;
        $this->fournisseur = $fournisseur;
    }
    public function setId(int $id): void 
{
    $this->id = $id;
}
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getDate(): string 
    {
        return $this->date;
    }

    public function setDate(string $date): void 
    {
        $this->date = $date;
    }

    public function getMontantTotal(): float 
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): void 
    {
        $this->montantTotal = $montantTotal;
    }

    public function getStatut(): string 
    {
        return $this->statut;
    }

    public function setStatut(string $statut): void 
    {
        $this->statut = $statut;
    }

    public function getFournisseur(): ?Fournisseur 
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): void 
    {
        $this->fournisseur = $fournisseur;
    }

}
