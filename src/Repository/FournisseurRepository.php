<?php

class FournisseurRepository{
    private PDO $pdo;

    public function __construct (?PDO $pdo=null)
    {
        $this->pdo=$pdo ?? Database::getInstance()->getConnexion();
    }

    public function getAllFournisseurs(): array{
        $result=$this->pdo->query("SELECT * FROM fournisseurs");
        $fournisseurs=[];
        while($ligne=$result->fetch(PDO::FETCH_ASSOC)){
            $fournisseurs[]=$this->hydrate($ligne);
        }
        return $fournisseurs;
    }
    public function getFournisseurById(int $id): ?Fournisseur{
        $prepare=$this->pdo->prepare("SELECT * FROM fournisseurs WHERE id=:id");
        $prepare->execute(['id'=>$id]);
        $ligne= $prepare->fetch(PDO::FETCH_ASSOC);
        return $ligne ? $this->hydrate($ligne) : null;

    }

    public function saveFournisseur(Fournisseur $fournisseur){
        $prepare= $this->pdo->prepare("INSERT INTO fournisseurs (nom,telephone,email,adresse) VALUES 
                                        (:nom,:telephone,:email,:adresse)");
        $result =  $prepare->execute([
            'nom'=>$fournisseur->getNom(),
            'telephone'=>$fournisseur->getTelephone(),
            'email'=>$fournisseur->getEmail(),
            'adresse'=>$fournisseur->getAdresse()
        ]);
        if ($result) {
            $fournisseur->setId((int) $this->pdo->lastInsertId());
        }

        return $result;
    }
    public function hydrate( array $fournisseur):Fournisseur{
            return new Fournisseur (
                     (int)$fournisseur['id'], 
                      $fournisseur['nom'], 
                       $fournisseur['telephone'],
                        $fournisseur['email'], 
                       $fournisseur['adresse']
            );
    }


}