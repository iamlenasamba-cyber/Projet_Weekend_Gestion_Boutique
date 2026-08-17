<?php

class FournisseurRepository {
    public static function getAllFournisseurs(): array 
    {
        $result = Database::getConnexion()->query("SELECT * FROM fournisseurs");
        $fournisseurs = [];
        
        while ($ligne = $result->fetch(PDO::FETCH_ASSOC)) {
            $fournisseurs[] = self::hydrate($ligne);
        }
        return $fournisseurs;
    }
    
    public static function getFournisseurById(int $id): ?Fournisseur 
    {
        $prepare = Database::getConnexion()->prepare("SELECT * FROM fournisseurs WHERE id = :id");
        $prepare->execute(['id' => $id]);
        $ligne = $prepare->fetch(PDO::FETCH_ASSOC);
        
        return $ligne ? self::hydrate($ligne) : null;
    }

    public static function saveFournisseur(Fournisseur $fournisseur): bool 
    {
        $pdo = Database::getConnexion();
        $prepare = $pdo->prepare("INSERT INTO fournisseurs (nom, telephone, email, adresse) 
                                 VALUES (:nom, :telephone, :email, :adresse)");
        
        $result = $prepare->execute([
            'nom'=> $fournisseur->getNom(),
            'telephone'=> $fournisseur->getTelephone(),
            'email'=> $fournisseur->getEmail(),
            'adresse'=> $fournisseur->getAdresse()
        ]);

        if ($result) {
            $fournisseur->setId((int) $pdo->lastInsertId());
        }

        return $result;
    }

    public static function hydrate(array $fournisseur): Fournisseur 
    {
        return new Fournisseur(
            (int) $fournisseur['id'], 
            $fournisseur['nom'], 
            $fournisseur['telephone'],
            $fournisseur['email'], 
            $fournisseur['adresse']
        );
    }
}