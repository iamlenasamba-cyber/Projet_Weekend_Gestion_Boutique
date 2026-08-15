<?php

class LigneVente {
    private ?int $id;
    private int $quantite;
    private float $prixUnitaire;
    private float $sousTotal;
    private Vente $vente;
    private Produit $produit;

    public function __construct( ?int $id = null, int $quantite = 0, float $prixUnitaire = 0.00, float $sousTotal = 0.00, ?Vente $vente = null, ?Produit $produit = null ) {
        $this->id = $id;
        $this->quantite = $quantite;
        $this->prixUnitaire = $prixUnitaire;
        $this->vente = $vente;
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

    public function setQuantite(int $quantite): void 
    {
        $this->quantite = $quantite;
        $this->recalculerSousTotal();
    }

    public function getPrixUnitaire(): float 
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): void 
    {
        $this->prixUnitaire = $prixUnitaire;
        $this->recalculerSousTotal();
    }

    public function getSousTotal(): float 
    {
        return $this->sousTotal;
    }

    public function setSousTotal(float $sousTotal): void 
    {
        $this->sousTotal = $sousTotal;
    }

    public function getVente(): ?Vente 
    {
        return $this->vente;
    }

    public function setVente(?Vente $vente): void 
    {
        $this->vente = $vente;
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

// CREATE TABLE ligneVentes (
//     id INTEGER PRIMARY KEY AUTOINCREMENT,
//     quantite INT NOT NULL,
//     prixUnitaire NUMERIC(10, 2) NOT NULL,
//     sousTotal NUMERIC(10, 2) NOT NULL,
//     vente_id INT NOT NULL REFERENCES ventes(id) ON DELETE CASCADE,
//     produit_id INT NOT NULL REFERENCES produits(id)
// );