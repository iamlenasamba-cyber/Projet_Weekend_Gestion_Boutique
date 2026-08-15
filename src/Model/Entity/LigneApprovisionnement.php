<?php

class LigneApprovisionnement {
    private ?int $id;
    private int $quantite;
    private float $prixUnitaire;
    private float $sousTotal;
    private Approvisionnement $approvisionnement;
    private Produit $produit;

    public function __construct( ?int $id = null, int $quantite = 0, float $prixUnitaire = 0.00, float $sousTotal = 0.00, ?Approvisionnement $approvisionnement = null, ?Produit $produit = null) {
        $this->id = $id;
        $this->quantite = $quantite;
        $this->prixUnitaire = $prixUnitaire;
        $this->approvisionnement = $approvisionnement;
        $this->produit = $produit;
        $this->sousTotal = ($sousTotal > 0.00) ? $sousTotal : ($this->quantite * $this->prixUnitaire);
    }
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getQuantite(): int 
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): void  {
        $this->quantite = $quantite;

    }

    public function getPrixUnitaire(): float 
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): void 
    {
        $this->prixUnitaire = $prixUnitaire;
    }

    public function getSousTotal(): float 
    {
        return $this->sousTotal;
    }

    public function setSousTotal(float $sousTotal): void 
    {
        $this->sousTotal = $sousTotal;
    }

    public function getApprovisionnement(): ?Approvisionnement 
    {
        return $this->approvisionnement;
    }

    public function setApprovisionnement(?Approvisionnement $approvisionnement): void 
    {
        $this->approvisionnement = $approvisionnement;
    }

    public function getProduit(): ?Produit 
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): void 
    {
        $this->produit = $produit;
    }
}

