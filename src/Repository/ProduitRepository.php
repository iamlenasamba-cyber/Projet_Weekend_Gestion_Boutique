<?php

class ProduitRepository 
{
    public static function getAllProduits(): array 
    {
        $sql = Database::getConnexion()->query("SELECT * FROM produits");
        $produits = [];
        
        while ($ligne = $sql->fetch(PDO::FETCH_ASSOC)) {
            $produits[] = self::hydrate($ligne);
        }
        
        return $produits;
    }

    public static function getProduitById(int $id): ?Produit 
    {
        $prepare = Database::getConnexion()->prepare("SELECT * FROM produits WHERE id = :id");
        $prepare->execute(['id' => $id]);
        $ligne = $prepare->fetch(PDO::FETCH_ASSOC);

        return $ligne ? self::hydrate($ligne) : null;
    }

    public static function saveProduit(Produit $produit): bool 
    {
        $pdo = Database::getConnexion();
        $save = $pdo->prepare("INSERT INTO produits (nom, prix, seuilAlerte, quantiteDisponible)
                              VALUES (:nom, :prix, :seuilAlerte, :quantiteDisponible)");
        
        $result = $save->execute([
            'nom'                => $produit->getNom(),
            'prix'               => $produit->getPrix(),
            'seuilAlerte'        => $produit->getSeuilAlerte(),
            'quantiteDisponible' => $produit->getQuantiteDisponible()
        ]);

        if ($result) {
            $produit->setId((int) $pdo->lastInsertId());
        }

        return $result;
    }

    public static function hydrate(array $ligne): Produit 
    {
        return new Produit(
            (int) $ligne['id'],
            $ligne['nom'],
            (float) $ligne['prix'],
            (int) $ligne['seuilAlerte'],
            (int) $ligne['quantiteDisponible']
        );
    }
}