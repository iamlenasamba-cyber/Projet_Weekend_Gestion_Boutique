<?php

class Dette {
    private ?int $id;
    private float $montant;
    private float $montantRestant;
    private string $date;
    private string $statut;
    private Vente $vente;
    private Client $client;
public function __construct(  ?int $id = null, float $montant = 0.00, float $montantRestant = 0.00, string $date = '', string $statut = 'EN_COURS', ?Vente $vente = null, ?Client $client = null ) {
        $this->id = $id;
        $this->montant = $montant;
        $this->montantRestant = $montantRestant;
        $this->date = $date;
        $this->statut = $statut;
        $this->vente = $vente;
        $this->client = $client;
    }

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getMontant(): float 
    {
        return $this->montant;
    }

    public function setMontant(float $montant): void 
    {
        $this->montant = $montant;
    }

    public function getMontantRestant(): float 
    {
        return $this->montantRestant;
    }

    public function setMontantRestant(float $montantRestant): void 
    {
        $this->montantRestant = $montantRestant;
    }

    public function getDate(): string 
    {
        return $this->date;
    }

    public function setDate(string $date): void 
    {
        $this->date = $date;
    }

    public function getStatut(): string 
    {
        return $this->statut;
    }

    public function setStatut(string $statut): void 
    {
        $this->statut = $statut;
    }

    public function getVente(): ?Vente 
    {
        return $this->vente;
    }

    public function setVente(?Vente $vente): void 
    {
        $this->vente = $vente;
    }

    public function getClient(): ?Client 
    {
        return $this->client;
    }

    public function setClient(?Client $client): void 
    {
        $this->client = $client;
    }

    public function estSoldee(): bool 
    {
        return $this->montantRestant <= 0.00;
    }

  
    public function enregistrerPaiement(float $montant): void 
    {
        $this->montantRestant -= $montant;
        
        if ($this->estSoldee()) {
            $this->montantRestant = 0.00;
            $this->statut = "SOLDEE";
        }
    }
}