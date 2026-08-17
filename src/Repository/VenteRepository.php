<?php

class VenteRepository 
{
    public static function getAllVentes(): array 
    {
        $sql = "SELECT v.*, c.nom AS client_nom, c.prenom AS client_prenom, 
            c.telephone AS client_telephone, 
            c.email AS client_email, 
            c.adresse AS client_adresse
            FROM ventes v
            INNER JOIN clients c ON v.client_id = c.id
            ORDER BY v.id ASC";

        $prepare = Database::getConnexion()->query($sql);
        $ventes = [];

        while ($ligne = $prepare->fetch(PDO::FETCH_ASSOC)) {
            $ventes[] = self::hydrate($ligne);
        }

        return $ventes;
    }

    public static function getVentesRecentes(int $limit = 5): array 
    {
        $sql = "SELECT v.*, 
              c.nom AS client_nom, 
              c.prenom AS client_prenom, 
              c.telephone AS client_telephone, 
              c.email AS client_email, 
              c.adresse AS client_adresse
              FROM ventes v
              JOIN clients c ON v.client_id = c.id
              ORDER BY v.id DESC
              LIMIT :limit";

        $prepare = Database::getConnexion()->prepare($sql);
        $prepare->bindValue(':limit', $limit, PDO::PARAM_INT);
        $prepare->execute();

        $venteRecentes = [];   
        while ($ligne = $prepare->fetch(PDO::FETCH_ASSOC)) {
            $venteRecentes[] = self::hydrate($ligne);
        }

        return $venteRecentes; 
    }

    public static function getTotalVentesEncaisse(): float 
    {
        $sql = "SELECT SUM(montantTotal) AS montantTotal FROM ventes";
        return (float) (Database::getConnexion()->query($sql)->fetchColumn() ?? 0.0);
    }

    public static function getVenteById(int $id): ?Vente 
    {
        $sql = "SELECT v.*, 
        c.nom AS client_nom, 
        c.prenom AS client_prenom, 
        c.telephone AS client_telephone, 
        c.email AS client_email, c.adresse AS client_adresse
        FROM ventes v
        INNER JOIN clients c ON v.client_id = c.id
        WHERE v.id = :id";

        $prepare = Database::getConnexion()->prepare($sql);
        $prepare->execute(['id' => $id]);
        $ligne = $prepare->fetch(PDO::FETCH_ASSOC);

        return $ligne ? self::hydrate($ligne) : null;
    }

    public static function saveVente(Vente $vente, array $ligneVentes = []): bool 
    {
        $pdo = Database::getConnexion();

        try {
            $pdo->beginTransaction();

            $sqlVente = "INSERT INTO ventes (date, montantTotal, statut, client_id) 
            VALUES (:date, :montantTotal, :statut, :client_id)";

            $prepare = $pdo->prepare($sqlVente);
            $prepare->execute([
                'date'=> $vente->getDate(),
                'montantTotal'=> $vente->getMontantTotal(),
                'statut'=> $vente->getStatut(),
                'client_id'=> $vente->getClient()->getId()
            ]);

            $lastId = (int) $pdo->lastInsertId();
            $vente->setId($lastId);

            $sqlLigne = "INSERT INTO ligne_ventes (quantite, prix, produit_id, vente_id) 
                       VALUES (:quantite, :prix, :produit_id, :vente_id)";
            $prepareLigne = $pdo->prepare($sqlLigne);

            $sqlUpdate = "UPDATE produits SET quantiteDisponible = quantiteDisponible - :qte WHERE id = :produit_id";
            $prepareUpdate = $pdo->prepare($sqlUpdate);

            foreach ($ligneVentes as $ligne) {
                $prepareLigne->execute([
                    'quantite'=> $ligne->getQuantite(),
                    'prix'=> $ligne->getPrixUnitaire(),
                    'produit_id'=> $ligne->getProduit()->getId(),
                    'vente_id'=> $lastId
                ]);

                $prepareUpdate->execute([
                    'qte'=> $ligne->getQuantite(),
                    'produit_id'=> $ligne->getProduit()->getId()
                ]);
            }

            $pdo->commit();
            return true;

        } catch (\Throwable $th) {
            $pdo->rollBack();
            return false;
        }
    }

    public static function hydrate(array $vente): Vente 
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