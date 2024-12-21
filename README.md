**Français**
# Bienvenue sur le repository du site de recettes !

## Qu'est-ce que c'est ?

Un site de recherche paginée ou aléatoire de recettes selon critères, d'ajout, de like et de gestion de ces recettes par les auteurs de celles-ci s'ils sont identifiés. L'application propose également une API sécurisée à un seul utilisateur ayant les droits, créée avec API Platform et Lexik JWT-Authentication.  

Côté développement, l'application propose des fixtures afin de pouvoir avec un jeu de data pour tester le projet et une commande symfony custom permettant de recharger toute la base de données, les migrations et les fixtures en une seule ligne de commande.  

Ce site a été créé avec Symfony 6.4 et PHP 8.2.  

J'ai fait le style (responsive) du site sans framework et en utilisant des variables.

## Installation

Pour installer cette application, voici les étapes à suivre :

1) En premier, assurez-vous d'avoir la version de php 8.2 et la version 6.4 de symfony cli installées.
> Attention : une version trop récente de php (8.4) peut faire échouer certaines étapes.

1) Cloner ou téléchargez ce repository et placez-le dans un dossier sur votre machine.

2) Ouvrez un terminal et placez-vous dans le dossier de ce projet pour lancer ```composer install```.

3) Paramétrez votre environnement : dupliquez le fichier .env dans un nouveau fichier .env.local. Dans ce nouveau fichier, changez la valeur de DATABASE_URL pour matcher avec vos paramètres de serveur de base de données.
   
4) Lancez la commande ```symfony console app:reload-fixtures``` (commande custom qui permet de créer la base de données, exécution les migrations et chargement des fixtures).

5) Pour visualiser l'application, lancez la commande ```symfony serve -d``` et allez sur [ce lien](https://127.0.0.1:8000/)

6) Pour arrêter le server, faites la commande ```symfony server:stop```.

J'espère que mon application vous plaira !

FloryssRu.





**English**
# Welcome in my recipes-website repository !

## What is it ?

A site for paginated or random searches for recipes according to criteria, and for adding, liking and managing these recipes by their authors if they are identified. The application also offers a secure API for a single user with rights, created with API Platform and Lexik JWT-Authentication.  

On the development side, the application offers fixtures so that a set of data can be used to test the project, and a custom symfony command for reloading the entire database, migrations and fixtures in a single command line.  

This site was created using Symfony 6.4 and PHP 8.2.  

I styled the site (responsive) without framework and using variables.

## Installation

To install this application, follow these steps:

1) First, make sure you have php version 8.2 and symfony cli version 6.4 installed.
> Warning: a version of php that is too recent (8.4) may cause certain steps to fail.

1) Clone or download this repository and place it in a folder on your machine.

2) Open a terminal and go to the project folder to run ``composer install``.

3) Set up your environment: duplicate the .env file into a new .env.local file. In this new file, change the value of DATABASE_URL to match your database server settings.
   
4) Run the ``symfony console app:reload-fixtures`` command (a custom command that creates the database, performs migrations and loads fixtures).

5) To view the application, run the command ``symfony serve -d`` and go to [this link](https://127.0.0.1:8000/)

6) To stop the server, run the command ``symfony server:stop``.

I hope you like my application !

FloryssRu.
