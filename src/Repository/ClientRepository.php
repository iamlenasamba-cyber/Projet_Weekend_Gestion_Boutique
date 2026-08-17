<?php

class ClientRepository {

    public static function getAllClients(): array {
        $query = Database::getConnexion()->query("SELECT * FROM clients");
        $clients = [];
        while ($ligne = $query->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = self::hydrate($ligne);
        }
        return $clients;
    }

    public static function getClientById(int $id): ?Client {
        $prepare = Database::getConnexion()->prepare("SELECT * FROM clients WHERE id = :id");
        $prepare->execute(['id' => $id]);
        $execute = $prepare->fetch(PDO::FETCH_ASSOC);
        return $execute ? self::hydrate($execute) : null;
    }

    public static function saveClient(Client $client): bool {
        $pdo = Database::getConnexion();
        $prepare = $pdo->prepare("INSERT INTO clients (nom, prenom, telephone, email, adresse)
                VALUES (:nom, :prenom, :telephone, :email, :adresse)");
        
        $result = $prepare->execute([
            'nom'       => $client->getNom(),
            'prenom'    => $client->getPrenom(),
            'telephone' => $client->getTelephone(),
            'email'     => $client->getEmail(),
            'adresse'   => $client->getAdresse()
        ]);

        if ($result) {
            $client->setId((int) $pdo->lastInsertId());
        }
        
        return $result;
    }

    public static function hydrate(array $client): Client {
        return new Client(
            (int) $client['id'],
            $client['nom'],
            $client['prenom'],
            $client['telephone'],
            $client['email'],
            $client['adresse']
        );
    }
}