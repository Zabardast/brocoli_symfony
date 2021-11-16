# curly-broccoli
projet 1

# GESTION UTILISATEUR

## login :
input:
* email
* password
* submit

## sign in :
input:
* nom
* prenom
* date de naissance
* adresse mail : unique
* numero de telephone
* Chiffre d’Affaire annuel maximum : afficher en mode a ne pas depasser sinon on passe en entreprise mais pas automatiquement
* taux de charges: en %
* mot de passe
* mot de passe verif

## edit account :
input:
* nom
* prenom
* date de naissance
* adresse mail : unique
* numero de telephone
* Chiffre d’Affaire annuel maximum
* taux de charges: en %
* mot de passe
* mot de passe verif

## logout button :

# GESTION DES CLIENTS

## ajouter :
input:
* type : personne / entreprise
* nom de contact(ssi entreprise)
* prenom (ssi personne)
* nom : d'entreprise ou de famille ducoup
* adress
* numero de telephone
* adress email

## lister :
* lister tous les clients entrer par l'utilisateur

## modifier :
input:
* type : personne / entreprise
* nom de contact(ssi entreprise)
* prenom (ssi personne)
* nom : d'entreprise ou de famille ducoup
* adress
* numero de telephone
* adress email

## rechercher :
* La recherche doit se faire sur le nom, le prénom/nom de contact, la ville, l’email et le téléphone.

## supprimer :
* ssi pas associer a un projet

# GESTION DES PROJETS

## ajouter :
input:
* nom
* client

default:
* status : prospect

extra-data:
* status : prospect, devis envoyé, devis accepté, démarré, terminé, annulé (dans cet ordre lorsqu’un choix de statut est affiché)

## lister :
* par client 
* pour l'utilisateur connecter
* afficher : (démarré : default) puis les autres status par filtre avec spin box

## modifier :

* nom
* client
* status

## supprimer :
* ssi pas de facture associer

# FACTURATION

## ajouter :
* numéro de facture généré séquentiellement
* état de la facture : éditée, envoyée, payée (obligatoire)
* date d’édition (obligatoire) : derniere edition
* date de paiement limite (obligatoire)
* type de paiement (chèque, virement, paypal, autre)
* date de paiement effectif
* note de bas de page : juste du text
* lignes de facturation : lier a un projet par copie {libellé, prix unitaire, quantité} ??michelon??

## lister :
filtre:
* afficher toutes les factures
* afficher facture par projet
* afficher facture par client

info a afficher:
* état
* le numéro
* le projet (sauf la liste des factures d’un projet)
* le client (sauf la liste des factures d’un client)
* le montant total avec un tri par défaut sur les numéros du plus grand au plus petit.

warning:
* retard (envoyées et date limite de paiement dépassées)

## modifier :
condition :
* ssi pas envoyer

input :
* numéro de facture généré séquentiellement
* état de la facture : éditée, envoyée, payée (obligatoire)
* date d’édition (obligatoire) : derniere edition
* date de paiement limite (obligatoire)
* type de paiement (chèque, virement, paypal, autre)
* date de paiement effectif
* note de bas de page : juste du text
* lignes de facturation : lier a un projet par copie {libellé, prix unitaire, quantité} ??michelon??

## contrainte
* Une facture passant à l’état « payé » doit avoir obligatoirement une date de paiement effective.
* On ne peut pas envoyer ou payer une facture avant de l’avoir éditée.
* On ne peut pas non plus envoyer ou payer une facture qui n’a pas de lignes (mais on peut quand même la créer avec un état « Editée »). 

# TABLEAU DE BORD
lien:
* suite au login on vien ici

Après la connexion l’utilisateur aura un tableau de bord affichant l’état de son activité :  

* Résumé  annuel  de  l’activité :  CA  annuel,  somme  des  paiements  en  attente,  somme  des  factures  éditées  non  envoyées, CA annuel max, CA annuel restant à faire.

* Résumé trimestriel : période affichée (premier jour et dernier jour du trimestre), CA payé, CA estimé (estimation basée sur les dates de paiement limites), charges à payer, charges estimées à payer. On doit pouvoir visualisez le trimestre précédent et suivant.

* Un graphique avec des CA mensuels payés.

* Un graphique avec l’évolution du CA annuel payé (par valeurs mensuelles). 

# STRAPI

sudo docker-compose up

email       : hugo.molle@yahoo.fr
password    : Qwerty123


## TABLES

### user
* nom
* prenom
* date de naissance
* adress email
* numero de telephone
* ca
* taux de charge
* password

### client
* id_user
* type : enum
* prenom (contact ou prenom)
* nom
* adress
* numero de telephone
* email

### projet
* nom
* client
* status : enum
* prix

### facture
* numéro facture
* intituler
* état facture : enum {éditée, envoyée, payée} (obligatoire)
* date creation
* date derniere edition (obligatoire)
* date de paiement limite (obligatoire)
* type de paiement :enum {chèque, virement, paypal, autre}
* date de paiement effectif
* note de bas de page
* id ligne de facturation list<ligne>

### ligne
* nom
* prix unitaire
* quantité
* description


1 facture == 1 projet
1 projet == 1 facture