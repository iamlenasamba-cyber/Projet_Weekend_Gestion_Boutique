<?php
class VenteRepository{
    private PDO $pdo;
    public function __construct (?PDO $pdo=null){
        $this->pdo=$pdo ?? Database::getInstance()->getConnexion();
    
    }
    public function getAllVentes():array{
        $sql="SELECT v.*, c.nom AS client_nom, c.prenom AS client_prenom, 
            c.telephone AS client_telephone, 
            c.email AS client_email, 
            c.adresse AS client_adresse
            FROM ventes v
            INNER JOIN clients c ON v.client_id = c.id
            ORDER BY v.id ASC";
        $prepare=$this->pdo->query($sql);
        $ventes=[];
        while($ligne=$prepare->fetch(PDO::FETCH_ASSOC)){
            $ventes[]=$this->hydrate($ligne);
        }
        return $ventes;
    }
    public function getVentesRecentes(int $limit=5){
        $sql="SELECT v.*, 
              c.nom AS client_nom, 
              c.prenom AS client_prenom, 
              c.telephone AS client_telephone, 
              c.email AS client_email, 
              c.adresse AS client_adresse
              FROM ventes v
              JOIN clients c ON v.client_id = c.id
              ORDER BY v.id DESC
              LIMIT :limit";
        $prepare= $this->pdo->prepare($sql);
        $prepare->bindValue(':limit',$limit,PDO::PARAM_INT) ;
        $prepare->execute();
        $venteRecentes=[];   
          while($ligne=$prepare->fetch(PDO::FETCH_ASSOC)){
            $venteRecentes[]=$this->hydrate($ligne);
        }
        return $venteRecentes; 
    }
    public function getTotalVentesEncaisse(): float
    {
        $sql = "SELECT SUM(montantTotal) AS montantTotal FROM ventes";
        return (float) ($this->pdo->query($sql)->fetchColumn() ?? 0.0);
    }
   
    public function getVenteById(int $id): ?Vente
    {
        $sql = "SELECT v.*, 
        c.nom AS client_nom, 
        c.prenom AS client_prenom, 
        c.telephone AS client_telephone, 
        c.email AS client_email,c.adresse AS client_adresse
        FROM ventes v
        INNER JOIN clients c ON v.client_id = c.id
        WHERE v.id = :id";

        $prepare = $this->pdo->prepare($sql);
        $prepare->execute(['id' => $id]);
        $ligne = $prepare->fetch(PDO::FETCH_ASSOC);

        return $ligne ? $this->hydrate($ligne) : null;
    }
    public function saveVente(Vente $vente , array $ligneVentes=[]):bool{
        try {
            $this->pdo->beginTransaction();
            $sqlVente = "INSERT INTO ventes (date, montantTotal, statut, client_id) 
            VALUES (:date, :montantTotal, :statut, :client_id)";

            $prepare= $this->pdo->prepare($sqlVente);
            $prepare->execute([
                'date'=>$vente->getDate(),
                'montantTotal'=>$vente->getMontantTotal(),
                'statut'=>$vente->getStatut(),
                'client_id'=>$vente->getClient()->getId()
            ]);

            $lastId= (int) $this->pdo->lastInsertId();
            $vente->setId($lastId);
            $sqlLigne="INSERT INTO ligne_ventes (quantite, prix, produit_id, vente_id) 
                       VALUES (:quantite, :prix, :produit_id, :vente_id)";
            $prepareLigne=$this->pdo->prepare($sqlLigne);
            $sqlUpdate="UPDATE produits SET quantiteDisponible=quantiteDisponible-:qte WHERE id=:produit_id";
            $prepareUpdate=$this->pdo->prepare($sqlUpdate);
            foreach($ligneVentes as $ligne){
                    $prepareLigne->execute([
                    'quantite'=>$ligne->getQuantite(),
                    'prix'=>$ligne->getPrixUnitaire(),
                    'produit_id'=>$ligne->getProduit()->getId(),
                    'vente_id'=>$lastId
                   ]);
                    $prepareUpdate->execute([
                        'qte'=>$ligne->getQuantite(),
                        'produit_id'=>$ligne->getProduit()->getId()
                    ]);
                   
                 
            }

            $this->pdo->commit();
            return true;
           
        } catch (\Throwable $th) {
            $this->pdo->rollBack();
            return false;
        }
    }
     public function hydrate(array $vente): Vente
    {
        $client = new Client(
            (int) $vente['client_id'],
            $vente['client_nom'],
            $vente['client_prenom'] ?? null,
            $vente['client_telephone'] ?? null,
            $vente['client_email'] ?? null,
            $vente['client_adresse'] ?? null
        );
        return new Vente(
            (int) $vente['id'],
            $vente['date'],
            (float) $vente['montantTotal'],
            $vente['statut'],
            $client
        );
    }

}