    <?php

class ClientRepository {
    private PDO $pdo;
    public function __construct(?PDO $pdo=null){
        $this->pdo=$pdo ?? Database::getInstance()->getConnexion();
    } 
    public function getAllClients():array{
        $query=$this->pdo->query("SELECT * FROM clients");
        $clients=[];
        while($ligne=$query->fetch(PDO::FETCH_ASSOC)){
            $clients[]=$this->hydrate($ligne);
        }
        return $clients;
    }
    public function getClientById(int $id):?Client{
        $prepare=$this->pdo->prepare("SELECT * FROM clients WHERE id=:id");
        $prepare->execute(['id'=>$id]);
        $execute=$prepare->fetch(PDO::FETCH_ASSOC);
        return $execute? $this->hydrate($execute):null;
    }
    public function saveClient(Client $client):bool{
        $prepare=$this->pdo->prepare("INSERT INTO clients (nom,prenom,telephone,email,adresse)
                VALUES (:nom,:prenom,:telephone,:email,:adresse)");
        $result=$prepare->execute([
            'nom'=>$client->getNom(),
            'prenom'=>$client->getPrenom(),
            'telephone'=>$client->getTelephone(),
            'email'=>$client->getEmail(),
            'adresse'=>$client->getAdresse()
        ]);
        if($result){
            $client->setId((int)$this->pdo->lastInsertId());
        }
        return $result;
    }
    public function hydrate(array $client):Client{
        return new Client(
           (int) $client['id'],$client['nom'], $client['prenom'],$client['telephone'],$client['email'],$client['adresse']
        );
    
        
    }

}