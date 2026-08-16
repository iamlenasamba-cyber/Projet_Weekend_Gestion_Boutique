# 📓 Journal de Développement (DEVLOG)
**Nom & Prénom** : Lèna Samba 
**Projet** : StoreManager Pro (ERP PHP/POO)  

---

## 1. Suivi Chronologique des Phases

### 🌃 [Vendredi - Phase 1] : Conception & BDD Fallback
 ## A.Conception UML
- **Heure de réalisation** : realisé entre 15h et 20h30
- **Ce qui a été fait** : les diagrammes de usecases pour chaque acteur et le diagramme de classe. Un total de 10 classes:la classe utilisateur pour distinguer les acteurs, la classe approvisionnement et ligneApprovisionnement pour les commandes de produits du magasin, la classe fournisseur, client,reglement,produits,ventes,ligneVente et role.
- **Difficultés / Obstacles** : J'ai eu une petite confusion en faisant le diagramme de classes: L'existence ou non de la classe de dettes 
## B. Modélisation et Création de la Base de Données SQLite

- **Heure de réalisation** : réalisé entre 20h30 et 23h30
- **Ce qui a été fait** :
  - Traduction du diagramme de classes (10 classes métiers) en schéma relationnel: la table dette a ete supprimé considerant qque les dettes sont les ventes ayant un montantrestant >0
  - Rédaction du fichier SQL `schema.sql` puis transformation en SQLite (j'ai telechargé une extension pour le faire)


- **Modifications** :
  - suppression de la classe dette,remboursement
  - modification de la multiplicité entre utilisateur et role

- **Difficultés / Obstacles rencontrés** :
  - SQLite qui est un tout nouveau concept
  - Configuration des extensions vsCode pour visualiser la base SQLite.

### C. Connexion à la base de données 

* **Heure de réalisation :**entre  23h30 et 00h20
* **Ce qui a été fait :**
  * Création de la classe `Database.php` avec un Singleton pour n'avoir une seule instance de connexion ouverte.
  * Mise en place du **fallback automatique** :  l'application essaie d'abord de se connecter à **PostgreSQL**, et si ça échoue, elle bascule automatiquement sur la base **SQLite **.
* **Difficultés / Obstacles rencontrés :**
  * J'ai eu du mal a comprendre le fonctionnement des méthodes `static` et du constructeur `private` pour le Singleton.
  *J'ai eu un peu de mal a comprendre comment foctionnait la connexion avec sqllite.

###  [Samedi - Phase 2] 
  ### A. Entités POO Pure

* **Heure de réalisation :**entre  10h et 14h30
* **Ce qui a été fait :**
  * je me suis rendu compte que l'enonce precisait clairement la table de dette alors je l'ai ajouté dans la base de donné et jai enleve la colonne montant restant de la table ventes
  * creation du dossier model, entity et les fichers Client.php,Dette.php,Prouit.php
  * j'ai cree les classes et j'y ai mis les methodes getter et setter pour pouvoir les manipuler ensuite car ils sont en private et j'ai mis la methode __construct pour l'initialisation a la creation 
* **Difficultés / Obstacles rencontrés :**
* j'ai eu des problemes a comprendre private, a quoi ça sert et son impacte sur la suite du programme
* 
  ### B. Repositories & SQL Sécurisé


* **Heure de réalisation :**entre  15h et 20h
* **Ce qui a été fait :**
  * J'ai realisé ProduitRepository.php: j'ai cree une classe puis j'ai instancier Database et je me suis connecté a la base de donnée. J'ai ensuite ecris les methodes metiers (getAllProduits: pour recuperer tout les produits, getProduitById pour recuperer un produit de par son id, saveProduit pour enregistrer un produit dans la table produits). Vu que la base retourne un tableau associatif, pour la conversion en un objet j'ai ecris la methode hydrate qui transforme le tableau associatif en un objet de type produit.
  
  * J'ai realisé ClientRepository.php: j'ai cree une classe ClientRepository.php, j'ai instancier Database puis je me suis connecté. J'ai realiser les methodes metiers getAllClients: qui par une requete select recupere tout les clients, getClientById: qui recupere un client de par son id, saveClient : qui enregistre un client dans la base de donnee et la methode hydrate qui sert a convertir un tableau associatif a un objet de type Client a defaut d'utiliser FETCH_CLASS

  * J'ai realisé VenteRepository en me connectant comme dans tout les autres repository . J'ai realisé les methodes getAllventes qui recupere toutes les ventes depuis la base de donnes, getVentesRecentes qui recupere les ventes de 0 a 5 avec la contrainte LIMIT dans la requete, getVenteById qui recupere une vente de par son id, saveVente qui enregistre une vente dans la base de donne, par ailleurs, la methode saveVente enregistre les ligne de Ventes de la vente dans la table ligneVente, aussi la methode met a jour la quantite dans la table produits. Pour harmoniser le tout , j'ai utiliser une transaction pour que toutes ces requetes reuississent ensemble ou echouent ensembles.J'ai aussi realiser la methode hydrate pour la conversion des tableaux associatifs en des objet de type Vente
  
  * J'ai assi realisé FournisseurRepository par le meme processus que tout les autres repository. J'ai la methode __construct qui me permet de me connecter a la base de donnes, J'ai les methodes getAllFournisseurs, getFournisseurById,saveFournisseur et hydrate
  
  * J'ai ajouter un setter setId() dans tout les fichers de Entity car je me suis rendu compte que j'avais besoin d'une methode qui enregistre l'id dans les classes

   * J'ai ajouter le ficher router.php et le dossier controllers,views bien qu'ils soient vides pour le moment
  
  
* **Difficultés / Obstacles rencontrés :**
* J'ai eu beaucoup de mal a realiser les fichers repository car j'ai l'habitude de coder en procedural surtout VenteRepository.php .Mais une fois que j'ai realiser l'un les autres ont été un peu plus abordables
   ### B. Repositories & SQL Sécurisé

   **Ce qui a été fait :**
   * J'ai realiser VenteService: Je me suis connecté et j'ai instancier Venterepository. J'ai realiser la methode enregistrerVente.Pour ce faire j'ai d'abord verifier si le panier est vide(Le panier est composer des ligneVentes qui seront enregistrés dans la session dans le controller),sinon je recupere tout les donnes dans panier que je vais utiliser pour creer des objets de type LigneVente. J'ai aussi creer un objet de type vente.Ensuite j'ai appellé la methode saveVente qui se trouv dans repository, pour enregistrer la vente dans la base de donnes. Enfin je verifie si la vente a reussi sinon je capte un message avec throw new exception, je vide le panier pour terminer.
  
  