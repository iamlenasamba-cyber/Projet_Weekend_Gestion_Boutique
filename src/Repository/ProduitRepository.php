<?php

class ProduitRepository {

private ?PDO $pdo;

public function __construct(?PDO $pdo=null){
    $this->pdo= $pdo ?? Database::getInstance()->getConnexion();

}
public function getAllProduits(): array{
   $sql= $this->pdo->query("SELECT * FROM produits");
   $produits=[];
   while($ligne=$sql->fetch(PDO::FETCH_ASSOC)){
        $produits[]= $this->hydrate($ligne);
   }
   return $produits;

}

public function getProduitById(int $id): ?Produit{
    $prepare=$this->pdo->prepare("SELECT * FROM produits WHERE id=:id");
    $prepare->execute(['id'=>$id]);
    $ligne=$prepare->fetch(PDO::FETCH_ASSOC);
   
    return $ligne? $this->hydrate($ligne): null;
}

public function saveProduit (Produit $produit){
    $save=$this->pdo->prepare("INSERT INTO produits (nom,prix,seuilAlerte,quantiteDisponible)
                              VALUES (:nom,:prix,:seuilAlerte,:quantiteDisponible)");
         $result= $save->execute(['nom'=>$produit->getNom(),
                    'prix'=>$produit->getPrix(),
                    'seuilAlerte'=>$produit->getSeuilAlerte(),
                    'quantiteDisponible'=>$produit->getQuantiteDisponible()
                    ]);
        if($result){
                       $produit->setId((int) $this->pdo->lastInsertId()); 
        }
        return $result;
}
public function hydrate(array $ligne):Produit{
    return new Produit( (int) $ligne['id'],
                        $ligne['nom'],
                        (float) $ligne['prix'],
                        (int) $ligne['seuilAlerte'],
                        (int) $ligne['quantiteDisponible']
                        );
}

 
}