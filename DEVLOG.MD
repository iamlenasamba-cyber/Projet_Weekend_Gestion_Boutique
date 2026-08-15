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