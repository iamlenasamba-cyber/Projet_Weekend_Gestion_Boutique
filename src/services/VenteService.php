<?php

class VenteService 
{
    public static function enregistrerVente(Client $client, array $panier): bool 
    {
        if (empty($panier)) {
            throw new Exception("Le panier est vide.");
        }

        $montantTotal = 0;
        $ligneVentes = [];

        foreach ($panier as $item) {
            $produit = $item['produit'];
            $quantite = $item['quantite'];
            $prixUnitaire = $item['prix'];

            if ($produit->getQuantiteDisponible() < $quantite) {
                throw new Exception("Quantité insuffisante pour le produit : " . $produit->getNom());
            }

            $montantTotal =  $montantTotal +($prixUnitaire * $quantite);

            $ligneVentes[] = new LigneVente($quantite, $prixUnitaire, $produit);
        }

        $vente = new Vente(date('Y-m-d'), $montantTotal, $client);
        
        $resultat = VenteRepository::saveVente($vente, $ligneVentes);

        if (!$resultat) {
            throw new Exception("Une erreur est survenue lors de l'enregistrement.");
        }

        if (isset($_SESSION['panier'])) {
            unset($_SESSION['panier']);
        }

        return true;
    }
}