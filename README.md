# Projet Laravel - Site de Généalogie

## Présentation

Ce projet est un site de généalogie développé en **Laravel 8+** avec une base de données **MySQL**. 
Il permet aux utilisateurs de créer des fiches personnes, de les relier entre elles par des liens familiaux, et de gérer les modifications de manière communautaire.

## Installation
1. Cloner le dépôt :

   ```bash
   git clone https://github.com/ShiroAlaFraise/Test_O-CD_Victor_Floquet
   cd genealogie
   ```

2. Installer les dépendances :

   ```bash
   composer install
   ```

3. Copier le fichier `.env.example` en `.env` puis configurer les accès à la base de données :

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Créer la base de données MySQL localement (par exemple `genealogy_db`) et mettre à jour `.env` :

   ```
   DB_DATABASE=genealogy_db
   DB_USERNAME=ton_utilisateur
   DB_PASSWORD=ton_mot_de_passe
   ```

5. Lancer les migrations et importer les données fournies

6. Lancer le serveur local :

   ```bash
   php artisan serve
   ```

---

## Partie 1 – Création des fiches et relations

* Accès à la liste des personnes :
  [http://localhost:8000/people](http://localhost:8000/people)

* Voir le détail d'une personne (avec parents/enfants) :
  [http://localhost:8000/people/{id}](http://localhost:8000/people/{id})

* Créer une personne (authentification requise) :
  [http://localhost:8000/people/create](http://localhost:8000/people/create)

> Utilisateur test :
>
> * Email : `test@test.fr`
> * Mot de passe : `testtest`

---

## Partie 2 – Degré de parenté

Cette fonctionnalité permet de calculer le **degré de parenté** entre deux personnes (nombre de relations à traverser pour les relier).

* Tester l'algorithme :
  [http://localhost:8000/degre](http://localhost:8000/degre)

Vous pouvez essayer avec 84 et 1265 qui donne comme résultat 13.

---

## Partie 3 – Validation communautaire

Cette partie introduit un système de **proposition et validation communautaire** pour éviter les modifications non fiables.

### Schéma de la base de données :

* Diagramme accessible ici :
  [dbdiagram.io](https://dbdiagram.io/d/682250fa5b2fc4582f461da0)

### Fonctionnement :

#### 1. Proposition de modification

Lorsqu’un utilisateur souhaite modifier une fiche ou ajouter une relation :

* Une entrée est créée dans `modification_requests` (type, cible, contenu, auteur).
* Exemple de payload :

  ```json
  {
    "type": "edit_person",
    "target_type": "person",
    "target_id": 5,
    "payload": {
      "birth_date": "1902-05-12"
    }
  }
  ```

#### 2. Validation

Les autres utilisateurs votent (`modification_votes`).

* Acceptée si 3 votes positifs.
* Rejetée si 3 votes négatifs.

#### 3. Application

* Si acceptée : modification appliquée à `people` ou `relationships`.
* Statut mis à jour (archivage).

| Étape | Action                         | Table concernée        | Résultat                     |
| ----- | ------------------------------ | ---------------------- | ---------------------------- |
| 1     | Proposition ajout relation     | modification\_requests | `INSERT` (status = pending)  |
| 2     | 3 utilisateurs votent          | modification\_votes    | 3 `INSERT`                   |
| 3     | Acceptation par majorité       | modification\_requests | `UPDATE` (status = accepted) |
| 4     | Application (relation ajoutée) | relationships          | `INSERT`                     |

---

Je souhaite vivement rejoinde O'CD et j'espère que ma candidature vous aura intéressé :)
