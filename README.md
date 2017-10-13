#CMS simple de Portfolio sous Codeigniter 3.1.5

## Table des matières

* [Introduction](#markdown-header-introduction)
    * [Pourquoi un CMS pour créer et gérer des portfolios ?](#markdown-header-pourquoi-un-cms-pour-créer-et-gérer-des-portfolios-?)
    * [Pourquoi Codeigniter ?](#markdown-header-pourquoi-codeigniter-?)
    * [Fonctionnalités](markdown-header-fonctionnalités)
* [Prérequis](#markdown-header-prérequis)
* [Installation](#markdown-header-installation)
    * [Au commencement](#markdown-header-au-commencement)
    * [Les fichiers à modifier](#markdown-header-les-fichiers-à-modifier)
    * [Vos paramètres](#markdown-header-vos-paramètrest)
* [Flux de travail](#markdown-header-flux-de-travail)
* [Personnalisation](#markdown-header-personnalisation)
    * [Le template](#markdown-header-le-template)
    * [Les styles](#markdown-header-les-styles)
    * [Les scripts](#markdown-header-les-scripts)
    * [Le contenu](#markdown-header-le-contenu)
* [Utilisation](#markdown-header-utilisation)
    * [Cycle standard](#markdown-header-cycle-standard)
    * [Gestion des utilisateurs](#markdown-header-gestion-des-utilisateurs)
* [Crédits](#markdown-header-crédits)
* [Licence](#markdown-header-licence)

## Introduction

### Pourquoi un CMS pour créer et gérer des portfolios ?
Parce que tout le monde a besoin d'un portfolio ! Plus sérieusement, je cherchais à me créer mon propre portfolio, mais je ne souhaitais ni une solution clé en main ni utiliser un CMS déjà existant. Je voulais "expérimenter", apprendre et créer quelque chose de simple, mais efficace. 

Au fur et a mesure de mon travail de réflexion sur la conceptualisation de ce projet, je me suis dit que ça pourrait être intéressant de ne pas seulement construire un "objet" à usage unique, mais créer une base saine pour de futurs travaux. 

### Pourquoi Codeigniter ?

Le framework PHP Codeigniter présente l'avantage d'être extrêmement léger et avec une courbe d'apprentissage rapide. Sa documentation est complète, il possède une communauté active, et sa syntaxe ainsi que son fonctionnement MVC sont clairs et simples d'accès. Je voulais un environnement de travail souple, mais qui m'obligerait à vraiment mettre les mains dans le cambouis tout en évitant les packages tiers. Je souhaitais vraiment pouvoir créer du sur-mesure, mais tout en conservant un cadre qui permettrait de réutiliser ultérieurement le produit créé.

### Fonctionnalités

* Partie publique
    * Page d'accueil personnalisable et permettant de trier et d'accéder aux projets du portfolio ;
    * Pages projet retournant de l'information et une galerie de visuels.
* Administration
    * Création et gestion d'utilisateurs et d'administrateurs ;
    * Création et gestion de catégories de projets ;
    * Création et gestion de projets ;
    * Gestion de galeries liées aux projets créés :
        * Ajout, modification et affichage de visuels ;
        * Création automatisée de miniatures ;
        * Gestion de l'ordre d'affichage des visuels enregistrés.

## Prérequis 

Pour fonctionner, le projet a besoin de :
* PHP 7 ;
* Base de données MySql ; 
* Node.js et gestionnaire de paquets (NPM ou Yarn) pour la gestion des dépendances ;
* Utilisation de SASS ;
* Gestion des assets via Webpack ;


## Installation

### Au commencement

1. Clonez ou copiez le répertoire.

2. Lancez une installation des dépendances via votre gestionnaire de paquets.

    
    yarn install
    
ou
    
    npm install
    

**Utilisant Yarn, je continuerais mes explications avec sa syntaxe.**

### Les fichiers à modifier

Pour assurer le fonctionnement de votre projet, il y a 3 fichiers à modifier.

1. à la racine du projet : webpack.config.js ligne 94

    new webpack.DefinePlugin({
      BaseURL: '\'[adresse de votre projet sur votre serveur local ou distant - ex: http://localhost:8080/mon-portfolio/]\'',
    }),

2. dans : application/config/config.php ligne 26

    $config['base_url'] = '[adresse de votre projet sur votre serveur local ou distant - ex: http://localhost:8080/mon-portfolio/]';

3. dans : application/config/database.php
  * Ici, il faut créer la connexion avec votre base de données. Vous trouverez le script d'installation de la base dans le dossier script_database à la racine du projet. 

4. Vous pouvez maintenant lancer la construction webpack de votre projet (voir [Flux de travail](#markdown-header-flux-de-travail))

### Vos paramètres

Une fois le projet correctement installé, vous pouvez vous rendre dans l'administration du site afin de personnaliser quelques paramètres.

* Pour cela, rendez-vous à l'adresse "www.mon-site/login". Les données de connexion de base sont :
  * Nom d'utilisateur : administrator
  * E-mail : admin@example.com
  * Mot de passe : password

**Bien entendu il vous est fortement conseillé de modifier ces données depuis votre profil une fois connecté.**

Vous pouvez à présent accéder à la partie "paramètres du site" et gérer quelques informations standards.

## Flux de travail

La gestion des assets étant déléguée Webpack, vous devrez passer par ce dernier pour construire le dossier *build* dans le dossier *public*.
Pour cela, il y a deux commandes à connaître et utiliser dans depuis le terminal dans le dossier du projet.

La première :

    yarn run build

va construire une fois le fichier build puis s'arrêter.

La seconde :

    yarn run watch

Va se lancer en tâche de fond et surveiller le dossier *src*. Elle mettra à jour le dossier *build* dès qu'une modification sera détectée. C'est cette commande que je conseille en phase de développement.

## Personnalisation

Il est tout à fait possible de modifier et personnaliser le projet. Cependant il est nécessaire de connaître HTML5, SASS, et jQuery pour certaines opérations.

### Le template

Le template et les différentes vues du projet son accessibles dans le dossier application/views/. 

Dans le dossier *template* vous trouverez la structure des parties front et admin du projet. C'est ici que vous pourrez modifier le menu de la partie publique du site par exemple.

Les vues à proprement parler se trouveront dans les dossiers *front* et *admin*. 

### Les styles

Pour modifier les styles css, rendez-vous dans le dossier *src* à la racine du projet. Si vous souhaitez, par exemple, modifier les couleurs principales de la partie publique du site :

* Allez dans *front/scss*
* Ouvrez le fichier *general.scss*
* Changez le contenu des variables $primary-color et $secondary-color par vos propres données.

### Les scripts

Les scripts JavaScript et jQuery utilisés par le projet sont accessible depuis le dossier *src*. Si vous désirez modifier ou ajouter un plug-in par exemple, c'est ici que ça se passe. Soit vous importez le plug-in globalement depuis les fichiers *front.js* et *back.js*, soit vous pouvez cibler une page précise.

### Le contenu

De base, le contenu de la page d'accueil est un peu "pauvre". Pour ajouter vos textes, sections, etc. ouvrez le fichier *application/views/front/homepage_view.php*.

Le projet utilise [Boostrap 4](http://getbootstrap.com/), consultez sa documentation pour apportez vos modifications à la page d'accueil.

La page d'accueil fonctionne avec le plug-in [Fullpage.js](https://alvarotrigo.com/fullPage/). Si vous souhaitez ajouter des sections, modifier les couleurs, etc., vous devrez modifier dans *src/front/js/parts/homepage-script.js*.

Veuillez à conserver la section projets intacte, c'est elle qui permet l'affichage automatisé des projets du portfolio.

## Utilisation

### Cycle standard

Le projet est installé, configuré, personnalisé, vous souhaitez maintenant créer votre premier projet de portfolio.

1. Rendez-vous dans l'administration du site et regardez du côté de la gestion du portfolio
2. Les catégories
  * De base une catégorie est créée. Elle est masquée et ne peut-être ni supprimée ni publiée.
  * Pour ajouter une catégorie, saisis son nom.
  * Vous pourrez ensuite la modifier, la supprimer, et bien entendu la publier.
3. Les projets
  * La liste est vide au début, c'est normal. Cliquez sur le bouton "Créer un nouveau projet".
  * L'ensemble des champs est obligatoire, à l'exception du lien externe.
  * N'oubliez pas d'associer le projet à une catégorie.
  * C'est bon ? Il n'y a plus qu'à enregistrer.
  * Vous pouvez maintenant publier, modifier ou supprimer votre nouveau projet.
  * Une galerie associée à ce projet a automatiquement été créée.
4. Les galeries
  * Vous retrouvez la galerie, vide, de votre projet nouvellement créé. Vous ne pouvez pas supprimer cette galerie, juste la vider.
  * Allez dans la galerie de votre projet. 
  * Vous pouvez ajouter autant de visuels que vous le souhaitez.
  * Vous pouvez évidemment modifier, masquer ou supprimer ces visuels.
  * Vous pouvez également gérer leur ordre d'affichage.
    * Pour cela, il suffit de cliquer sur le projet et de leur faire glisser dans la liste à sa nouvelle position.
    * **Le premier visuel de la liste est celui qui apparaîtra en couverture de la galerie et du projet**
  * Vous pouvez prévisualiser votre projet, même s'il n'est pas publié.
5. Admirez le travail en vous rendant sur la page d'accueil du site !

**Seul un administrateur peut gérer la suppression et l'affichage des éléments du portfolio !**

### Gestion des utilisateurs

En tant qu'administrateur, vous pouvez créer d'autres administrateurs et utilisateurs.

Pour cela, rendez-vous dans "Gestion des utilisateurs" et créez-le ! C'est à vous définir les données de l'utilisateur nouvellement créé et de lui communiquer ces informations. Il sera libre de les modifier depuis son profil une fois connecté.

## Credits

J'ai utilisé de nombreux outils très pratiques pour la réalisation de ce projet, laissez-moi vous les présenter.

* [Webpack 3](https://webpack.js.org/)
* [Bootstrap 4](http://getbootstrap.com/)
* [jQuery](http://jquery.com/)
* [jQuery UI](http://jqueryui.com/)
* [Open Iconic](https://useiconic.com/open/)
* [Fullpage.js](https://alvarotrigo.com/fullPage/)
* [Filterizr](http://yiotis.net/filterizr/)
* [Fancybox by FancyApps](http://fancyapps.com/fancybox/3/)
* [Datatables](https://datatables.net/)
* [Chart.js](http://www.chartjs.org/)

## License

Ce projet est sous licence MIT.