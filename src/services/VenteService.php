<?php

class VenteService {

    private PDO $pdo;
    private VenteRepository $venteRepository;

    public function __construct(?PDO $pdo=null, ?VenteRepository $venteRepository=null){
        $this->pdo= $pdo ?? Database::getInstance()->getConnexion();
        $this->venteRepository= $venteRepository ?? new VenteRepository($this->pdo);
    }
    public function enregistrerVente(Client $client, array $panier):bool{
        if(empty($panier)){
            throw new Exception("Le panier est vide.");
        }


        $montantTotal=0;
        $ligneVentes=[];

        foreach($panier as $item){
            $produit=$item['produit'];
            $quantite=$item['quantite'];
            $prixUnitaire=$item['prix'];

            if($produit->getQuantiteDisponible()<=$quantite){
                throw new Exception("Quantité insuffisante.");
            }

            $montantTotal=$montantTotal + ($prixUnitaire*$quantite);

            $ligneVentes= new LigneVente ($quantite,$prixUnitaire,$produit);
        }
        $vente=new Vente(date(),$montantTotal,$client );
        $resultat=$this->venteRepository->saveVente($vente,$ligneVentes);

        if(!$resultat){
            throw new Exception("Une erreur est survenue lors de l'enregistrement.");
        }

        if(isset($_SESSION['panier'])){
            unset($_SESSION['panier']);
        }
        return true;
    }
}