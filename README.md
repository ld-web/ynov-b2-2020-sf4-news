# B2 - Symfony

- [Composer](#composer)
  - [Dépendances](#dépendances)
  - [Autoloading](#autoloading)
  - [Versioning](#versioning)
- [Symfony](#symfony)
  - [Versions](#versions)
  - [Installation v4.4](#installation-en-version-44-lts)
  - [Environnements](#environnements)
  - [Arborescence](#arborescence)
    - [/bin](#bin)
    - [/config](#config)
    - [/migrations](#migrations)
    - [/public](#public)
    - [/src](#src)
    - [/templates](#templates)
    - [/tests](#tests)
    - [/translations](#translations)
    - [/var](#var)
    - [/vendor](#vendor)
    - [.env](#env)
    - [.env.test](#envtest)
    - [.gitignore](#gitignore)
    - [composer.json](#composerjson)
    - [composer.lock](#composerlock)
    - [phpunit.xml.dist](#phpunitxmldist)
    - [symfony.lock](#symfonylock)
  - [Web Server Bundle](#web-server-bundle)
  - [Console](#console)
  - [Contrôleurs](#contrôleurs)
  - [Templates](#templates-vues---twig---introduction)
  - [Entités](#entités---modèles)
  - [Mettre à jour la base de données](#mise-à-jour-de-la-base-de-données)
    - [Migrations](#migrations-1)
    - [Mise à jour à la volée](#mise-à-jour-à-la-volée)
  - [Ajout d'une relation ManyToMany](#ajout-dune-relation-manytomany)
  - [Fixtures](#fixtures---les-données-de-tests)
  - [La persistance des entités](#la-persistance-des-entités)
  - [Générer des données aléatoires](#générer-des-données-aléatoires)
  - [Afficher des données](#afficher-des-données)
    - [Les repositories](#les-repositories)
  - [Introduction à l'injection de dépendances](#introduction-à-linjection-de-dépendances)
    - [Le container](#le-container)
  - [Afficher une collection avec Twig](#afficher-les-éléments-dune-collection-dans-une-vue-twig)
  - [Importer des CSS et des images](#afficher-des-css-et-des-images-statiques)
  - [Récupérer et afficher un élément de la BDD](#récupérer-et-afficher-un-élément-de-la-base-de-données)
    1. [Injecter la requête](#première-piste---injecter-la-requête-dans-le-contrôleur)
    2. [Solution : le ParamConverter](#solution---le-paramconverter)
  - [Séparation & inclusion de templates](#séparation-des-templates-et-inclusion)
  - [Introduction au QueryBuilder](#introduction-au-querybuilder)
  - [Formulaires](#formulaires)
    - [Construction](#construction-du-formulaire)
    - [Création](#création-du-formulaire)
    - [Gestion](#gestion-du-formulaire)
    - [Validation des données](#validation-des-données)
    - [Parenthèse sur la persistance : autowiring](#au-sujet-de-la-persistance-des-données)
    - [Affichage](#affichage-du-formulaire-dans-un-template-twig)
    - [Appliquer un thème](#appliquer-un-thème-au-formulaire)
    - [Relier deux entités](#relier-deux-entités)
  - [Les messages flash](#les-messages-flash)
  - [Utilisateurs](#utilisateurs)
    - [Authentification](#authentification)
    - [Contrôle d'accès](#contrôle-daccès)
  - [CRUD](#crud)

## Composer

### Dépendances

Composer est un gestionnaire de dépendances nous permettant de déclarer les packages que l'on souhaite utiliser.

On va utiliser Composer pour créer notre application Symfony, par exemple.

On peut également utiliser Composer pour importer une dépendance isolée (composant Symfony seul par exemple).

### Autoloading

Composer peut également nous permettre de gérer la manière dont on va charger les classes de notre application.

Par exemple, si on souhaite utiliser [`PSR-4`](https://www.php-fig.org/psr/psr-4/), on peut lui indiquer.

> composer.json

On vient fixer ici le fait que le namespace "App" correspond au dossier "src/" de notre application.

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/"
    }
  }
}
```

### Versioning

On trouvera une stratégie de versioning [`semver`](https://devhints.io/semver) pour les packages en PHP.

Le versioning `semver` est divisé en 3 parties. De gauche à droite :

- Version majeure (_Cette version introduit des changements significatifs par rapport à la version précédente, certaines fonctionnalités qui précédaient sont supprimées par exemple_)
- Version mineure (_On peut introduire de nouvelles choses dans une version mineure par exemple, en s'assurant que tout ce qui existe déjà continue de fonctionner_)
- Version de patch (_Correctifs de bugs et sécurité_)

Les packages Composer se trouvent pour leur grande majorité sur [packagist.org](https://packagist.org/).

## Symfony

Comme indiqué sur [la page d'accueil](https://symfony.com/), Symfony est avant tout **un ensemble de composants PHP réutilisables**.

Le framework Symfony en lui-même vient rassembler plusieurs dizaines de ces composants, dans une structure (arborescence) précise. On construit ensuite notre application dans cette structure.

### Versions

Symfony adopte également le système de versioning `semver`, et présente une nouvelle version majeure tous les 2 ans.

Pendant ces 2 années, on aura 5 versions mineures : de 0 à 4.

La version mineure n°4 sera donc la dernière sous-version d'une version majeure (3.4, 4.4, etc...), et elle sortira en même temps que la version majeure suivante (La version 5.4 devrait sortir en même temps que Symfony 6.0, probablement en Novembre 2021).

Ainsi, les versions 3.4, 4.4, etc...sont appelées des versions **LTS** ou Long-Term Support : un support sur la correction de bug et de failles de sécurité est assuré sur ces versions pendant 3 ans pour les corrections de bugs et 4 ans pour les failles de sécurité.

### Installation en version 4.4 LTS

Pour installer un projet Symfony avec la version 4.4, donc la LTS, on va exécuter la commande suivante :

```bash
composer create-project symfony/website-skeleton:"^4.4" nom_de_mon_projet
```

A l'exécution de cette commande, on verra défiler les différents composants issus de packagist.org, qui sont intégrés automatiquement par le framework dans nos dépendances.

### Environnements

Dans une application Symfony, l'environnement par défaut dans lequel nous allons travailler est `dev`, par défaut.

L'environnement se présentera sous forme d'une variable d'environnement `APP_ENV`.

Il y a 3 environnements prévus par Symfony par défaut : `dev`, pour la phase de développement, `test` pour les tests unitaires, fonctionnels, etc... et `prod` pour le déploiement en production, qui nous permet d'optimiser la configuration de l'application pour qu'elle soit plus rapide.

### Arborescence

#### `/bin`

Ce dossier va contenir 2 fichiers qui nous intéressent : `console` et `phpunit`. Nous verrons la console plus tard car nous allons beaucoup nous en servir, et si nous avons le temps nous introduirons phpunit.

#### `/config`

Ce dossier, comme son nom le laisse facilement deviner, contient les fichiers de configuration des différents packages utilisés dans l'application.

On trouvera des dossiers `dev`, `test` et `prod` pour avoir des configurations spécifiques selon l'environnement de l'application.

Se trouvent également 3 fichiers `bootstrap.php`, pour l'initialisation de notre application, `bundles.php` regroupant les packages ou dépendances installées dans notre application, à charger selon l'environnement, et `preload.php` pour le preloading introduit par PHP 7.4 pour le pré-chargement de scripts.

#### `/migrations`

Les migrations contiendront les changements de structure de notre base de données, quand nous travaillerons avec une BDD.

#### `/public`

Ce dossier contient uniquement un fichier `index.php`, qui va être le point d'entrée de notre application.

#### `/src`

Dans ce dossier, on retrouvera les classes de notre application.

On va avoir par exemple le dossier `Controllers` dans lequel se trouveront toutes les classes de contrôleurs permettant de gérer la navigation et le routage dans notre application.

Les entités (donc le modèle) se trouveront elles dans le dossier `Entity`.

Les repositories, dans le dossier `Repository`, seront notre couche de services, permettant de requêter nos modèles.

#### `/templates`

Ce dossier contiendra tous nos templates, écrits avec `Twig`, un moteur de template que nous verrons plus tard.

#### `/tests`

Dans ce dossier, on reproduira généralement l'arborescence de classes présentes dans `/src` pour écrire les tests associés.

#### `/translations`

Ce dossier contiendra des fichiers de traduction, si nous voulons travailler sur une application présentant des libellés multilingues, ou encore chaînes localisées.

#### `/var`

Ce dossier est destiné à recevoir des données de caches et de logs, il n'est pas intégré au gestionnaire de versions si on en utilise un.

On trouvera par exemple les fichiers issus de la compilation du conteneur applicatif, dans le dossier `cache`.

#### `/vendor`

Le dossier `/vendor` est géré par Composer, pour y inscrire la méthode d'autoloading ainsi que les sources des dépendances utilisées dans l'application. On remarquera qu'il n'est pas versionné.

#### `.env`

Ce fichier contient les variables d'environnement de l'application.

> Attention, ce fichier est versionné. Nous pouvons, si nous le voulons, écraser ces variables avec un fichier `.env.local` par exemple. Cela peut être utile dans le cas où nous définissons des variables avec des données confidentielles (URL d'accès à une BDD, clé privée d'API, etc...)

Il contient en premier lieu la définition de l'environnement (`APP_ENV`).

Nous verrons plus tard l'utilité de définir plusieurs fichiers contenant des variables d'environnement et les stratégies de versioning associées.

#### `.env.test`

Une réécriture de variables d'environnement pour les besoins des tests.

#### `.gitignore`

Tous les fichiers à ne pas intégrer au gestionnaire de versions.

#### `composer.json`

Le fichier Composer principal, qui contient toutes nos dépendances, et la méthode d'autoloading, entre autres.

On trouvera des dépendances dans 2 catégories : `require` et `require-dev`.

`require` regroupe les dépendances utilisées tout le temps.

Dans `require-dev`, on placera ce qu'on va appeler **des dépendances de développement**. Cela va concerner essentiellement les tests unitaires, ou utilitaires que l'on peut mettre en oeuvre lors de la phase de développement d'une application.

> En production par exemple, on ne voudra pas des dépendances de développement. On pourra ainsi demander à Composer de ne pas les intégrer au projet : `composer install --no-dev`

#### `composer.lock`

Ce fichier est celui consulté par Composer lorsque vous effectuez un `composer install`, pour installer toutes les dépendances préalablement définies.

On peut le voir comme l'équivalent du `package-lock.json` avec npm, qui permet de regrouper les versions installées.

Ainsi, n'importe qui de nouveau sur le projet peut faire un `composer install` après avoir clôné ou forké le projet : il aura exactement les mêmes versions que nous.

#### `phpunit.xml.dist`

Le fichier de configuration de PHPUnit.

#### `symfony.lock`

Ce fichier sert à un outil intégré avec la version 4 de Symfony : Symfony Flex.

Symfony Flex est un outil construit au-dessus de Composer. Il permet, dans un projet Symfony, en plus d'installer une dépendance, d'exécuter des **recettes**, comme des scripts de pré-configuration d'un package.

Ce fichier garde, en plus de la version du package, la version de la recette exécutée.

### Web Server Bundle

Nous utilisons dans ce module la version 4.4 (LTS) de Symfony.

Dans cette version, nous pouvons encore utiliser le `WebServerBundle` pour mettre en route notre serveur.

Ceci dit, attention aux prochaines créations d'applications Symfony : à partir de la version 5, le `WebServerBundle` est déprécié en faveur de l'outil Symfony en ligne de commande ([Changelog 5.0, feature #31217](https://github.com/symfony/symfony/blob/5.x/CHANGELOG-5.0.md)).

Vu que nous en avons besoin lors de la phase de développement uniquement (en phase de tests et production, nous aurons un serveur web frontal type Apache ou Nginx), nous pouvons installer le bundle avec Composer en ajoutant l'option `--dev` :

```bash
# server est un alias (voir sur flex.symfony.com)
composer require server --dev
```

> Une recette Symfony Flex permet d'ajouter automatiquement ce package à la liste des bundles chargés dans `config/bundles.php`, et ajoute un fichier au fichier `.gitignore`.

### Console

La console Symfony est un exécutable PHP contenant de nombreux outils dont on va tirer partie lors des développements.

Par exemple, la console nous permettra de :

- Créer un contrôleur
- Créer une entité
- Mettre à jour notre base de données
- Mettre en route notre serveur
- etc...

Par exemple, pour mettre en route notre serveur, on utilisera la commande : `php bin/console server:run`.

> On écrira toujours les appels à la console de la façon suivante, depuis la racine du projet : `php bin/console commande`. Une commande peut se présenter sous la forme `theme_commande:action_a_exectuer`

### Contrôleurs

Si on lance le serveur juste après l'installation de l'application, nous constatons que nous n'avons aucune page d'accueil.

En utilisant la console et le `MakerBundle`, nous allons créer le premier contrôleur de notre application, qui sera configuré pour s'exécuter sur la page d'accueil.

```bash
php bin/console make:controller
```

On va nommer la classe `IndexController`, puis consulter le contenu du fichier `src/Controller/IndexController.php` créé par le maker.

> Un point sur la classe de contrôleurs : cette classe étend une classe abstraite `AbstractController`, c'est cette classe abstraite qui lui fournit les capacités d'un contrôleur. On pourra consulter diverses méthodes utilitaires dans le `ControllerTrait`, également intégré à Symfony.

Dans la classe créée par le maker, on trouve une fonction `index`, qui va renvoyer une `Response`. C'est le principe de base de Symfony : le modèle Requête/Réponse.

Au-dessus de la signature de cette fonction, on trouvera une **annotation** `@Route`. C'est grâce à cette annotation que nous pourrons définir l'URL associée à notre route, le nom de la route, les méthodes HTTP autorisées, etc...

Le rôle de base d'un contrôleur étant de communiquer avec les modèles puis de demander le rendu d'une vue, on trouve l'instruction `$this->render('...', [...]);`.

Ce contrôleur va déclencher le rendu d'un template.

### Templates (Vues) - Twig - Introduction

Dans ce module, on utilisera Twig comme moteur de templates.

Les 3 éléments de syntaxe Twig à retenir sont les suivants :

- Structure de contrôle ou de langage Twig : `{% %}`
- Evaluer une expression et afficher le résultat à l'écran : `{{ }}`
- Inscrire un commentaire dans un template : `{# #}`

Exemple d'un fichier Twig :

```twig
{# base.html.twig #}
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>{% block title %}SuperNews{% endblock %}</title>
    {% block stylesheets %}{% endblock %}
  </head>
  <body>
    {% block body %}{% endblock %}
    {% block javascripts %}{% endblock %}
  </body>
</html>
```

Dans tout fichier de template, on pourra inclure des instructions Twig pour la compilation du template.

Dans ce premier extrait par exemple, on construit un squelette HTML de base.

Le but est d'avoir un template de base commun pour toutes les pages de notre application.

On définit donc dans notre squelette de base différents **blocs**, que nous allons mettre à disposition des templates enfants pour qu'ils définissent chacun leur propre contenu :

```twig
{# index/index.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}
  {# Il est possible de rappeler le contenu du bloc parent avec la fonction parent() #}
  {{ parent() }} - Hello TestController!
{% endblock %}

{% block body %}

<div class="example-wrapper">
  {# On peut afficher la valeur de variables passées par le contrôleur à la vue #}
  <h1>Hello {{ controller_name }}! ✅</h1>
</div>
{% endblock %}
```

> Les différents blocs définis dans le template parent vont donc prendre le contenu défini dans le template enfant. On pourra donc définir les contenus de chaque page séparément, en gardant une base d'affichage commune (utilisation de Bootstrap, etc...)

### Entités - Modèles

Pour créer des entités dans notre application, nous allons utiliser le Maker : `php bin/console make:entity`.

L'assistant ligne de commande est plutôt clair et simple à utiliser. Choisissez pour chaque propriété que vous voulez créer son type, sa taille, nullable ou non, etc...

Une fois notre entité terminée, le Maker nous a créé une classe d'entité dans `src/Entity`.

Cette classe contient différents attributs qui deviendront plus tard les colonnes de nos tables. Par ailleurs, l'encapsulation est respectée puisque pour chaque attribut on peut trouver un **getter** et un **setter** associés.

### Mise à jour de la base de données

Nous allons voir 2 manières de mettre à jour la base de données : les migrations et les mises à jour à la volée.

Dans tous les cas, les mises à jour de base de données se font en **2 étapes** : **préparation & revue** du code SQL qui va être exécuté, puis **exécution** de la mise à jour.

> Avant de pouvoir effectuer des mises à jour dans la base de données, il faut renseigner l'URL d'accès à la base de données dans le fichier .env.local, qui n'est pas intégré au gestionnaire de versions

#### Migrations

Pour générer une migration, on va simplement exécuter la commande suivante du Maker : `php bin/console make:migration`.

Cette commande va comparer le contenu de nos classes d'entités avec le contenu de la structure de la base de données, puis générer une classe de migration dans le dossier `migrations`, contenant le code SQL nécessaire à la synchronisation des 2 côtés.

Une fois la migration générée, on peut aller vérifier dans le fichier généré que le code SQL correspond aux mises à jour que l'on souhaite effectuer.

Une fois le code SQL passé en revue, on peut exécuter la mise à jour, donc exécuter la migration : `php bin/console doctrine:migrations:migrate`.

Dans ce cas, Doctrine prend le relais : il va vérifier les migrations déjà éventuellement exécutées, pour éviter d'exécuter la même 2 fois, et exécuter celles qui doivent l'être.

> L'approche avec migrations pour la base de données est la manière recommandée pour gérer les évolutions de structures. Elle présente l'avantage principal d'être rigoureuse, avec la génération de classes de migrations permettant de cibler précisément et rigoureusement les mises à jour effectuées. Cependant, il faut bien veiller à ne pas s'emmêler les pinceaux dans les différentes mises à jour de structures, et que l'outil de migration s'y retrouve également

#### Mise à jour à la volée

Le fonctionnement est similaire, mais ne génère aucun fichier de migration.

Revue du code qui va être exécuté : `php bin/console doctrine:schema:update --dump-sql`.

Exécution à la volée des mises à jour nécessaires : `php bin/console doctrine:schema:update --force`.

### Ajout d'une relation ManyToMany

Avec un ORM, nous allons réfléchir notre base de données sous forme Objet.

Cela signifie que dans l'exemple que nous réalisons, c'est-à-dire un site d'actualités, nous avons créé une entité `Article`, correspondant à la table `article` de notre base de données.

Nous souhaitons que nos articles aient une ou plusieurs catégories.

En base de données, on sait que ce type de besoin correspond à une relation multi-valuée, avec création d'une table pivot pour assurer les associations multiples.

Avec Doctrine, on va donc créer une entité `Category`, mais le but est de pouvoir manipuler nos instances de classes de la manière suivante par exemple : `$category->getArticles();`.

On va donc créer un attribut `articles` dans notre entite `Category`. Mais dans le maker, nous allons pouvoir définir cette propriété comme étant une **relation**, et plus précisément une relation **ManyToMany**.

L'assistant également va nous demander si on souhaite créer un nouvel attribut dans `Article`, afin de créer une relation **bi-directionnelle**, nous permettant de récupérer les articles d'une catégorie, et les catégories d'un article. On confirme la création d'un attribut `categories` dans l'entité `Article`.

```php
class Article
{
  //...

  /**
   * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="articles")
   */
  private $categories;

  //...

  /**
   * @return Collection|Category[]
   */
  public function getCategories(): Collection
  {
      return $this->categories;
  }
}
```

```php
class Category
{
  //...

  /**
   * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="categories")
   */
  private $articles;

  //...

  /**
   * @return Collection|Article[]
   */
  public function getArticles(): Collection
  {
      return $this->articles;
  }
}
```

> Note : les attributs créés sont représentés et gérés du point de vue de Doctrine comme des `ArrayCollection`, une collection d'objets à laquelle on peut enlever/ajouter des éléments

### Fixtures - Les données de tests

Une fois qu'on a nos entités, qu'on a créé notre base de données, on aimerait pouvoir insérer des données de test pour travailler sur un ensemble initial de données lors du développement de notre application.

On va pour cela utiliser les **fixtures**.

On installe la dépendance de développement suivante : `orm-fixtures` (il s'agit de l'alias Flex).

La recette exécutée lors de l'installation a créé un fichier `src/DataFixtures/AppFixtures.php`.

C'est dans ce fichier qu'on va créer nos objets et les enregistrer en base de données.

Notre fichier de fixtures, à la base, ressemble à quelque chose comme ça :

```php
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    //...

    $manager->flush();
  }
}
```

Dans la méthode `load` de notre classe, on va donc vouloir instancier toutes les entités qu'on souhaite enregistrer en base de données.

Par exemple :

```php
<?php
//...
public function load(ObjectManager $manager)
{
  $article = new Article();
  $article
    ->setTitle('Mon titre')
    ->setSubtitle('Mon sous-titre')
    ->setCover('mon-image.jpg')
    ->setContent('Mon contenu super long ^^');
  $manager->persist($article);

  $manager->flush();
}
//...
```

On peut ensuite générer notre base de tests avec la commande suivante : `php bin/console doctrine:fixtures:load`

### La persistance des entités

Dans l'extrait de code ci-dessus, reprenons les différentes étapes empruntées afin de pouvoir sauvegarder une entité en base de données :

- On instancie un nouvel objet de type `Article`
- On utilise l'interface fluide pour assigner des valeurs à ses différents attributs, via les setters
- On **persiste** l'entité
- On `flush` les changements effectués pour qu'ils soient exécutés en base de données

Lorsqu'on va vouloir créer un nouvel enregistrement en base de données, on va devoir passer par ces étapes. Et particulièrement l'étape de **persistance**.

> L'étape de persistance, c'est-à-dire l'appel à la méthode `persist` de votre gestionnaire d'entités, est indispensable. Il permet tout simplement, après la création d'un objet, de **dire à votre gestionnaire que vous souhaitez qu'il gère cette entité**. Vu qu'elle n'existe pas encore (on vient de la créer manuellement, dans le code, on ne l'a pas récupérée d'une source de données existante), elle sera donc persistée, c'est-à-dire créée en base de données, lorsque vous exécuterez la méthode `flush` du gestionnaire

---

> L'appel à la méthode `flush` permet de **pousser** vers la base de données tous les changements que vous avez demandés à votre gestionnaire d'entités. Pour notre exemple, il s'agit, après avoir demandé à notre gestionnaire de gérer l'entité, de l'insérer de manière concrète dans la base de données, donc d'exécuter le code SQL nécessaire à son insertion. Ceci nous permet de pouvoir demander plusieurs opérations à notre gestionnaire (insertion, modification, suppression), puis d'effectuer un seul appel à `flush` pour regrouper toutes les requêtes. Ce serait trop lourd si on devait exécuter une requête à chaque fois qu'on demandait quelque chose au gestionnaire

Ainsi, nous pouvons donc créer plusieurs articles, les persister, puis demander à Doctrine de les insérer :

```php
<?php
//...
public function load(ObjectManager $manager)
{
  for ($i = 0; $i < 25; $i++) {
    $article = new Article();
    $article
      ->setTitle('Mon titre')
      ->setSubtitle('Mon sous-titre')
      ->setCover('mon-image.jpg')
      ->setContent('Mon contenu super long ^^');
    $manager->persist($article);
  }

  $manager->flush();
}
//...
```

### Générer des données aléatoires

Nous pouvons générer avec succès 25 articles, à l'heure actuelle.

Mais le souci principal est qu'ils ont un contenu absolument **identique**.

Il serait plus utile de disposer de données plus _réalistes_.

Pour ce faire, nous allons ajouter un package aux dépendances de développement de notre application : [`Faker`](https://github.com/fzaninotto/Faker) :

```bash
composer require fzaninotto/faker --dev
```

Nous pouvons ensuite suivre la [documentation](https://github.com/fzaninotto/Faker#table-of-contents), qui paraît suffisamment claire, afin de disposer d'un objet capable de nous fournir des données aléatoires.

On se trouve donc avec une méthode de chargement de nos fixtures ressemblant à ça :

```php
<?php
//...
use Faker;
//...
public function load(ObjectManager $manager)
{
  $faker = Faker\Factory::create();

  for ($i = 0; $i < 25; $i++) {
    $article = new Article();
    $article
      ->setTitle($faker->sentence(7))
      ->setSubtitle($faker->text(70))
      ->setCover($faker->imageUrl())
      ->setContent($faker->paragraph(24));
    $manager->persist($article);
  }

  $manager->flush();
}
//...
```

### Afficher des données

Nous disposons à présent de données aléatoires générées automatiquement dans notre base de données.

Nous allons donc pouvoir les afficher à l'écran !

Pour les afficher, il faut donc que notre **vue** dispose d'une collection d'articles à afficher.

> Dans le pattern MVC, le contrôleur est chargé d'agir en tant que "_glue_" entre le modèle et la vue. Dans Symfony, il va donc se charger de récupérer les articles auprès d'une couche de service (les repositories), puis transmettre le résultat obtenu à la vue

#### Les repositories

Dans Symfony, les repositories agissent comme une **couche de service**.

Un service, de manière générale dans une application, fournit des fonctionnalités que nous pouvons consommer depuis un autre endroit de l'application. Un service sera généralement représenté par une classe, et les fonctionnalités fournies, par des méthodes.

Dans notre cas, **un repository peut donc être qualifié de service applicatif nous permettant de discuter avec notre base de données, à propos d'un sujet particulier (une entité)**.

On retrouve cette "sectorisation" sur une entité dans le constructeur, par exemple :

```php
// src/Repository/ArticleRepository.php
//...
public function __construct(ManagerRegistry $registry)
{
    parent::__construct($registry, Article::class);
}
//...
```

Si on explore un peu plus cette classe, on remarque qu'elle hérite d'une classe `ServiceEntityRepository`, qui elle-même hérite d'une classe `EntityRepository`. Ces 2 derniers fichiers appartiennent au package Doctrine, nous ne devons donc **absolument pas** tenter de les modifier (ils se trouvent quelque part dans les vendors).

Une rapide revue de la classe `EntityRepository` nous indique donc que notre `ArticleRepository`, par exemple, hérite de méthodes publiques telles que `find`, `findAll`, `findBy`, etc...

> Ce sont ces méthodes que nous voulons utiliser dans notre contrôleur afin de pouvoir récupérer nos articles sans écrire nous-mêmes le SQL. C'est Doctrine qui va se charger de ça pour nous

### Introduction à l'injection de dépendances

La problématique principale réside donc dans la nécessité pour le contrôleur de disposer d'une instance de notre `ArticleRepository`, afin d'exploiter les méthodes offertes par ce service.

![MVC avec un repository en tant que service](docs/MVC_Service.png "MVC avec un repository en tant que service")

Le premier moyen que nous pourrions utiliser est l'instanciation d'un repository dans notre contrôleur :

```php
//...
class IndexController extends AbstractController
{
  /**
   * @Route("/", name="index")
   */
  public function index(): Response
  {
    $articleRepository = new ArticleRepository();
  }
  //...
}
```

Le souci est que **la signature du constructeur attend un paramètre** !
Nous devrions donc nous poser une seconde problématique pour instancier ce paramètre. Mais celui-ci est de type `ManagerRegistry`, qui est une interface ! Nous ne pouvons pas instancier une interface...

Il existe un moyen plus simple pour disposer d'une instance de notre `ArticleRepository` : nous allons **l'injecter** directement dans notre contrôleur. Pour gérer l'injection de l'instance, nous allons simplement nous reposer sur le **container** de Symfony.

#### Le container

Le container Symfony est un ensemble de classes compilées dans le dossier `var/cache` de notre application. Il est compilé automatiquement par Symfony.

Il va contenir diverses informations sur notre application, et notamment la liste des services de notre application.

Pour les découvrir, il va explorer notre dossier `src/` à la recherche des classes utilisables en tant que services.

Le fait qu'il aille chercher dans le dossier `src/` n'est pas magique, et est issu de la configuration par défaut de Symfony :

```yaml
# config/services.yaml

#...

services:
  # ...

  # makes classes in src/ available to be used as services
  # this creates a service per class whose id is the fully-qualified class name
  App\:
    resource: "../src/"
    exclude:
      - "../src/DependencyInjection/"
      - "../src/Entity/"
      - "../src/Kernel.php"
      - "../src/Tests/"

  # controllers are imported separately to make sure services can be injected
  # as action arguments even if you don't extend any base controller class
  App\Controller\:
    resource: "../src/Controller/"
    tags: ["controller.service_arguments"]
#...
```

> Attention au format des fichiers Yaml : il s'agit d'un format permettant de déclarer des éléments de configuration. Ces éléments peuvent être regroupés en **sections**. Dans une section seront regroupés tous les éléments **avec un niveau d'indentation supplémentaire**. **Une erreur dans la gestion de vos niveaux d'indentation peut tout simplement rendre votre fichier invalide** !

Ici, dans la section `services`, le container va pouvoir aller explorer l'ensemble des classes présentes dans `src/`, à l'exception de certains fichiers et dossiers que nous ne voulons pas enregistrer dans le container en tant que services (directive `exclude`).

Par ailleurs, la dernière section concernant les contrôleurs va nous permettre d'**injecter directement un service en tant qu'argument du contrôleur**.

Ainsi, nous pouvons en déduire que notre container connaît l'ensemble de nos repositories en tant que services applicatifs, utilisables là où on en a besoin.

Par exemple, si je souhaite communiquer avec ma base de données à propos d'articles dans mon contrôleur, je peux donc injecter un argument de type `ArticleRepository` afin de consommer les méthodes que ce service nous offre :

```php
class IndexController extends AbstractController
{
  //...
  public function index(ArticleRepository $articleRepository): Response
  {
    // 1 - Je récupère les articles en discutant avec ma couche de service
    $articles = $articleRepository->findAll();

    // 2 - Je transmets les articles à la vue que je souhaite afficher
    return $this->render('index/index.html.twig', [
      'articles' => $articles,
    ]);
  }
  //...
}
```

> Cette méthode s'appelle le `type-hinting` : il s'agit de spécifier le type attendu pour un argument de méthode. Ensuite, le container reconnaît ce type, vu qu'il l'a déjà découvert en explorant nos fichiers dans `src/`, et est donc capable d'injecter le service correspondant à ce type, s'il le connaît

Pour résumer, nous pouvons donc dire que `ArticleRepository` est une **dépendance** de notre contrôleur, puisque ce dernier a besoin de ce service pour pouvoir fonctionner correctement, c'est-à-dire pour pouvoir récupérer les articles qu'il va transmettre à la vue.

Nous venons donc d'**injecter cette dépendance** dans notre contrôleur.

![MVC avec Container](docs/MVC_Service_Container.png "MVC avec Container")

### Afficher les éléments d'une collection dans une vue Twig

Notre contrôleur dispose d'un moyen de récupérer la collection d'articles, et peut la transmettre à la vue.

Dans notre template Twig correspondant, nous allons itérer sur la collection afin d'afficher chaque élément. Pour ce faire, nous allons utiliser une boucle [for](https://twig.symfony.com/doc/3.x/tags/for.html) :

```twig
<ul class="list-group">
  {% for article in articles %}
    <li class="list-group-item">
      <p>{{ article.title }}</p>
      <img src="{{ article.cover }}" alt="{{ article.subtitle }}" />
    </li>
  {% endfor %}
</ul>
```

> Attention, la syntaxe d'une boucle `for` avec Twig ressemble à celle d'un `foreach` en PHP, mais la collection sur laquelle itérer et la variable d'itération à utiliser sont dans le sens inverse ! Sans compter évidemment que le mot `as` change en `in` avec Twig

On remarque que pour afficher un champ d'un objet `Article`, Twig nous permet d'accéder à l'attribut d'un objet à l'aide d'un point `.`

En réalité, il faut bien avoir en tête le mécanisme mis en oeuvre par Twig pour arriver à afficher l'attribut correspondant. En effet, dans notre exemple, l'attribut `title` est marqué comme `private` par exemple. Comment Twig peut-il donc deviner comment accéder à sa valeur ?

La réponse se trouve derrière [ce lien](https://twig.symfony.com/doc/3.x/templates.html#variables) : Twig dispose de plusieurs possibilités à explorer sur une variable lorsqu'on tente d'accéder à un attribut de celle-ci.

Dans notre cas, il s'arrête sur le cas "if foo is an object, check that getBar is a valid method", où `foo` est notre variable `article` et `getBar` notre méthode `getTitle`.

### Afficher des CSS et des images statiques

Le composant `Asset` de Symfony peut nous permettre d'afficher nos ressources statiques.

En installant le `website-skeleton`, nous avons installé ce composant.

Il nous fournit une méthode d'extension Twig : [`asset`](https://symfony.com/doc/current/reference/twig_reference.html#asset).

Cette méthode permet d'aller chercher directement le chemin de ressources statiques.

Par exemple, pour une feuille de styles CSS :

```twig
<link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
```

Le fichier sera directement récupéré dans le dossier `public/`.

Par ailleurs, il est ensuite possible de configurer une stratégie de versioning de nos assets par exemple, pour l'invalidation du cache utilisateur. L'utilisation de la méthode `asset` délègue le chargement de nos ressources au composant.

### Récupérer et afficher un élément de la base de données

Si nous souhaitons réaliser la page d'un article par exemple, la première problématique va être la suivante : comment récupérer le bon article ?

#### Première piste - Injecter la requête dans le contrôleur

Symfony possède une classe `Request` que nous pouvons type-hinter dans n'importe quel contrôleur. Une fois que nous disposons d'une instance de la classe `Request`, nous pouvons accéder à diverses informations concernant la requête effectuée.

Par exemple, ici, nous aimerions récupérer un paramètre GET `id` :

```php
/**
  * @Route("/article", name="article")
  */
public function index(Request $request): Response
{
  return $this->render('article/index.html.twig', [
    'controller_name' => 'ArticleController',
    'id' => $request->query->getInt('id')
  ]);
}
```

On utilise l'attribut `query`, qui contient tous les paramètres GET de la requête.

On pourrait donc, une fois qu'on a récupéré l'ID de l'article qu'on souhaite afficher, injecter notre `ArticleRepository` dans notre contrôleur afin de récupérer l'entité en question :

```php
/**
  * @Route("/article", name="article")
  */
public function index(Request $request, ArticleRepository $repo): Response
{
  $id = $request->query->getInt('id');
  $article = $repo->find($id);

  return $this->render('article/index.html.twig', [
    'controller_name' => 'ArticleController',
    'article' => $article
  ]);
}
```

Bien que cette solution soit valide techniquement, elle ne sera pas convenable. En effet, nous aimerions par exemple disposer d'URL mieux formées, type `/article/56` au lieu de `/article?id=56`.

Pour ce faire, nous allons commencer par modifier l'URL de notre route, dans l'annotation, pour lui ajouter un **paramètre d'URL** :

```php
/**
  * @Route("/article/{id}", name="article")
  */
public function index(ArticleRepository $repo, int $id = 0): Response
{
  $article = $repo->find($id);

  return $this->render('article/index.html.twig', [
    'controller_name' => 'ArticleController',
    'article' => $article
  ]);
}
```

Ici, nous avons ajouté dans l'annotation de route un paramètre d'URL : id.

Mais nous voyons que tout paramètre d'URL peut être mappé en tant que paramètre de notre contrôleur. Nous avons également ajouté un paramètre à notre méthode, de type `int`.

Nous n'avons donc plus besoin de l'objet `Request` pour récupérer notre ID passé en paramètre d'URL, et nous pouvons directement utiliser notre repository pour récupérer l'article.

Ceci dit, Symfony nous donne la possibilité de faire encore plus simple et plus efficace.

#### Solution - le ParamConverter

En réalité, avec Symfony, il est possible de déclarer notre route, y intégrer un paramètre d'URL comme `id`, puis de **type-hinter** directement le type de l'entité attendue pour que l'objet correspondant soit injecté dans notre contrôleur :

```php
/**
 * @Route("/blog/{id}", name="article")
 */
public function index(Article $article): Response
{
  return $this->render('article/index.html.twig', [
    'controller_name' => 'ArticleController',
    'article' => $article
  ]);
}
```

> Nous avons également changé le format de la route de `/article` à `/blog`

Ici, que se passe-t-il concrètement ?

- Symfony est capable, avec le routeur, d'identifier le paramètre d'URL `id`
- A la lecture du type-hint `Article`, il comprend que nous souhaitons récupérer un élément de la base de données
- Il exécute donc le ParamConverter de Doctrine, qui permet de récupérer un élément de la base de données à partir d'un paramètre d'URL
- Notre paramètre d'URL s'appelle `id` : Doctrine va donc chercher un `Article` qui a cet `id` (note : on aurait également pu passer un paramètre dont le nom correspond à un autre champ de `Article`, c'est comme ça que ça fonctionne)
- Si un enregistrement est trouvé, alors il est injecté dans le contrôleur
- Sinon, une erreur 404 est générée

Nous avons donc considérablement réduit la quantité de code nécessaire pour récupérer notre article, rendu notre contrôleur plus clair, notre URL plus lisible, et nous générons à présent une erreur 404 lorsque l'enregistrement n'est pas trouvé, ce qui est plus rigoureux que le comportement précédent qui pouvait transmettre un article `null` à notre template.

> Le ParamConverter permet de récupérer un élément automatiquement, selon une certaine logique, à partir d'un paramètre d'URL, et de l'injecter automatiquement dans le contrôleur

### Séparation des templates et inclusion

Revenons à nos templates Twig.

Au lieu d'écrire tout le contenu dans un seul template, nous pouvons séparer des bouts de templates et les importer (inclure) dans d'autres templates.

Exemple pour notre liste d'articles en page d'accueil. Nous pouvons tout à fait séparer le code qui génère la "card" Bootstrap :

```twig
{# templates/index/article_list_item.html.twig #}
<div class="card mb-5" style="width: 18rem;">
  <img src="{{ article.cover }}" class="card-img-top" alt="{{ article.subtitle }}">
  <div class="card-body">
    <h5 class="card-title">{{ article.title }}</h5>
    <p class="card-text">{{ article.subtitle }}</p>
    <a href="{{ path('article', { id: article.id }) }}" class="btn btn-primary">Lire</a>
  </div>
</div>
```

Et ensuite, l'inclure pour chaque article qu'on souhaite afficher, dans la page d'accueil. Pour ce faire, on va utiliser la méthode `include` de Twig :

```twig
{# templates/index/index.html.twig #}
{# ... #}
<div class="d-flex flex-wrap justify-content-around">
  {% for article in articles %}
    {{ include('index/article_list_item.html.twig', { article: article }) }}
  {% endfor %}
</div>
{# ... #}
```

> Attention au chemin vers le template, il est toujours relatif à votre dossier racine de templates, défini dans la configuration du package Twig (ici `templates/`)

Nous injectons dans le template inclus la variable `article` qui y sera consommée.

Nous pouvons donc réaliser notre barre de navigation de la même façon.

### Introduction au QueryBuilder

Pour l'instant, notre page d'accueil récupère et affiche tous les articles.

Mais j'aimerais qu'elle en affiche uniquement 12.

Je pourrais, si je le souhaitais, utiliser la méthode `findBy` de mon repository, mais je devrais dans ce cas ignorer les 2 premiers paramètres : je n'ai aucun critère à passer pour le moment, ni d'ordre à appliquer à la collection trouvée.

Nous allons donc pouvoir définir une méthode dans notre couche de service, notre `ArticleRepository`.

Notre repository hérite d'une fonction `createQueryBuilder`. C'est cette méthode qui nous permettra de récupérer un constructeur de requêtes.

A partir de ce constructeur de requêtes, nous allons pouvoir reproduire des éléments de syntaxe SQL et indiquer quelle requête nous voulons faire, et comment nous souhaitons la personnaliser.

#### 1ère version de notre méthode

```php
public function findTopTwelve()
{
  $qb = $this->createQueryBuilder('a')
    ->setMaxResults(12);

  return $qb->getQuery()->getResult();
}
```

Nous pouvons ensuite consommer cette méthode dans notre contrôleur :

```php
$articles = $articleRepository->findTopTwelve();
```

Un problème se pose dans l'écriture de cette méthode : que se passe-t-il si, à l'avenir, je ne souhaite plus afficher 12 articles mais 9, ou bien 15 ?

Ma méthode est trop spécifique et conçue de manière incorrecte. Il faut qu'elle soit plus évolutive.

Pour ce faire, je vais la renommer `findTop` et définit qu'elle devra prendre un paramètre `number` en entrée, de type `int`.

```php
/**
 * Finds top number of articles
 *
 * @param integer $number
 * @return Article[]
 */
public function findTop(int $number)
{
  $qb = $this->createQueryBuilder('a')
    ->setMaxResults($number);

  return $qb->getQuery()->getResult();
}
```

Ensuite, je vais externaliser le nombre d'articles que je souhaite afficher en page d'accueil dans une **constante** de la classe `Article` :

```php
//...

class Article
{
  public const NB_HOME = 12;
  //...
}
```

Puis, dans mon contrôleur, je vais à présent consommer ma méthode, en m'appuyant sur l'information de nombre fournie par ma classe `Article` :

```php
$articles = $articleRepository->findTop(Article::NB_HOME);
```

Mon code est ainsi mieux **séparé** et plus **lisible**. L'utilisation de la constante, nommée, me permet d'identifier à quoi ce nombre est relatif. Ici, il s'agit du nombre d'articles qu'on souhaite afficher sur la page d'accueil. Mais cela pourrait aussi être le nombre d'articles qu'on souhaite afficher par page, lorsqu'on dispose d'une collection d'articles, par exemple. Quelque chose comme `NB_PER_PAGE`.

### Formulaires

La construction et la gestion d'un formulaire avec Symfony s'effectue en plusieurs étapes :

- Construction du formulaire à partir d'une classe
- Création du formulaire dans le contrôleur
- Gestion du formulaire dans le contrôleur
- Validation des données du formulaire
- Passage d'un objet `FormView` à la vue, avec lequel Twig pourra afficher les champs du formulaire

#### Construction du formulaire

Le premier exemple que nous avons pris concernait la création d'une newsletter.

Le but est de pouvoir présenter un formulaire simple, contenant un seul champ `email`, et permettant d'enregistrer une adresse dans une table `Newsletter`.

> On va donc prendre soin de créer en premier lieu l'entité chargée de recevoir ces données, puis de mettre à jour le schéma de la base de données comme vu précédemment

Pour créer un formulaire dans notre projet, on peut utiliser le `MakerBundle` :

```bash
php bin/console make:form
```

> On peut lier notre formulaire à une entité ou non, le maker nous demande si on souhaite le faire. Dans notre exemple, c'est le cas, il s'agit de l'entité `Newsletter`

Le maker nous génère une classe dans le dossier `src/Form`. On constate donc que nos classes de formulaires seront bien séparées du reste du code, dans un namespace `App\Form`.

> On suffixe les noms des classes de formulaire par `Type`. Ce n'est pas obligatoire mais on peut considérer ça comme une convention avec Symfony

Dans cette classe, on retrouve une méthode essentielle : `buildForm`. C'est dans cette méthode que nous allons déclarer les différents champs de notre formulaire, et leurs propriétés :

```php
//...
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//...

class NewsletterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder
          ->add('email', EmailType::class)
          ->add("S'inscrire", SubmitType::class)
      ;
  }
  // ...configureOptions, liaison du formulaire à la classe d'entité
}
```

On peut noter plusieurs choses dans la méthode `buildForm` :

- On peut utiliser l'interface fluide du type `FormBuilderInterface` pour chaîner les appels à la méthode `add`
- Chaque champ déclaré possède un `Type` lui-même : `EmailType`, `SubmitType` dans ce cas
- Les classes `EmailType`, `SubmitType` sont bien issues du composant `Form` de Symfony, il faut veiller à `use` les classes du bon namespace
- On constate que par défaut, un formulaire ne va pas générer lui-même un bouton de soumission. C'est à nous, à la construction du formulaire, d'ajouter un champ de type `SubmitType`

Les classes `***Type` appliquées aux différents champs de notre formulaire vont permettre d'afficher correctement les champs dans le rendu Twig !

#### Création du formulaire

Une fois que nous disposons de notre classe `NewsletterType`, qui représente la structure de notre formulaire, nous pouvons alors construire notre formulaire dans notre contrôleur :

```php
// Dans la méthode de contrôleur
$newsletter = new Newsletter();
$form = $this->createForm(NewsletterType::class, $newsletter);
```

La méthode `createForm` est utilisable dans toute méthode d'une classe héritant de la classe abstraite `AbstractController`.

Le but ici est de créer une entité vide, ainsi que le formulaire qui va être relié à cette entité.

Avec la méthode `createForm`, nous spécifions le type de formulaire que nous souhaitons récupérer, et l'entité qu'il faut lier à ce formulaire.

#### Gestion du formulaire

Une fois le formulaire créé, on peut gérer les données éventuellement saisies :

```diff
$newsletter = new Newsletter();
$form = $this->createForm(NewsletterType::class, $newsletter);

+$form->handleRequest($request);
```

Pour assurer la gestion du formulaire, on va exécuter une méthode `handleRequest` et lui passer en paramètre la **requête entrante**.

> Pour récupérer la requête entrante, on peut type-hinter le type `Request` du composant `HttpFoundation` de Symfony dans les paramètres de notre contrôleur

Cette méthode `handleRequest` va explorer toute seule le contenu des variables POST. Si elle trouve des informations correspondant à la structure de notre formulaire, elle va alors être capable de les récupérer et les mapper directement dans l'entité !

#### Validation des données

Une fois les données récupérées et mappées, il faut s'assurer qu'elles sont **valides**.

Cette responsabilité ne relève pas du composant `Form` de Symfony mais du composant `Validator`.

On va pouvoir simplement appeler, depuis le formulaire, 2 méthodes : `isSubmitted` et `isValid`, pour s'assurer que le formulaire a bien été soumis par l'utilisateur, puis que les données sont valides :

```php
//...
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
  // Si tout va bien, alors on peut persister l'entité et valider les modifications en BDD
  $em->persist($newsletter);
  $em->flush();
}
```

Mais pour pouvoir valider les données correctement, il faut qu'on spécifie un format de validation sur nos différents champs.

Par exemple, comment signifier à mon composant `Validator` que le champ `email` de mon entité `Newsletter` doit accepter des chaînes de caractère qui ont le format d'un email ?

On peut poser des **contraintes de validation** directement au niveau de l'entité :

```php
//...
use Symfony\Component\Validator\Constraints as Assert;
//...
class Newsletter
{
  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\Email()
   */
  private $email;

  //...
}
```

> Les contraintes de validation peuvent s'appliquer sous forme d'annotation au niveau des attributs de l'entité

Pour retrouver toutes les containres de validation disponibles dans Symfony, on peut consulter [cette page](https://symfony.com/doc/current/reference/constraints.html).

> Attention à sélectionner la bonne version de Symfony quand vous consultez la documentation. Je vous rappelle que nous utilisons ici la version 4.4, mais la dernière version majeure de Symfony est la version 5. Cela signifie que certaines choses peuvent avoir changé entre la version 4 et la version 5. Par défaut la documentation s'affiche dans la dernière version

Avec l'application de contraintes de validation dans les champs de nos entités, le composant `Validator` peut les erreurs de format dans le formulaire.

#### Au sujet de la persistance des données

Nous avons vu dans le point précédent qu'une fois qu'un formulaire a été validé, nous pouvons persister l'entité puis `flush`.

Pour faire ça, nous avons utilisé une variable `$em`.

Cette variable est en fait injectée directement dans le contrôleur sous forme de paramètre.

Pour expliquer sommairement le fonctionnement de cette injection, nous devons parler de nouveau du système d'injection de dépendances dans Symfony.

Pour injecter un service dans un contrôleur par exemple, nous avons vu que nous pouvions utiliser les **type-hints**.

Quand on utilise un type-hint, Symfony recherche le service correspondant (la classe) dans le **container de services**.

Ainsi, s'il trouve un service, il peut injecter une instance de celui-ci là où nous en avons besoin.

Cependant, les services qui peuvent être injectés par un type-hint doivent être **autowirés**.

> Pour résumer, un service **autowiré**, qui utilise donc l'**autowiring** de Symfony, peut donc être type-hinté dans une méthode de contrôleur, pour notre exemple. Nous verrons plus tard que nous pouvons également type-hinter un service dans le constructeur d'une classe

La question à se poser est donc la suivante : pour pouvoir communiquer avec ma base de données, quel type de classe vais-je pouvoir type-hinter dans les paramètres de mon contrôleur ?

Avec la console de Symfony, nous pouvons explorer les services autowirés.

Ici, nous voulons un `entity manager`, un gestionnaire d'entités.

Nous allons utiliser la commande `debug:autowiring`. Nous pouvons lui passer un argument de recherche pour qu'il affiche le ou les types correspondants :

```bash
php bin/console debug:autowiring entitymanager
```

Et en sortie, Symfony nous affiche :

```bash
Autowirable Types
=================

 The following classes & interfaces can be used as type-hints when autowiring:
 (only showing classes/interfaces matching entitymanager)

 EntityManager interface
 Doctrine\ORM\EntityManagerInterface (doctrine.orm.default_entity_manager)
```

Nous allons donc pouvoir type-hinter l'interface `EntityManagerInterface` du package Doctrine :

```php
public function index(
  Request $request,
  ArticleRepository $articleRepository,
  EntityManagerInterface $em
): Response {
  $newsletter = new Newsletter();
  $form = $this->createForm(NewsletterType::class, $newsletter);

  $form->handleRequest($request);

  if ($form->isSubmitted() && $form->isValid()) {
    $em->persist($newsletter);
    $em->flush();
  }
  //...
}
```

Au passage, nous retrouvons nos autres type-hints, `Request` et `ArticleRepository`.

Le rôle du container de services est donc d'identifier nos type-hints et nous fournir les services correspondants.

> Nous ne détaillerons pas dans ce module la raison pour laquelle nous devons injecter une interface et non une classe pour l'entity manager

Dans notre application, la configuration par défaut rend tous nos services autowirés. C'est pourquoi nous pouvons injecter nos repositories directement dans nos contrôleurs, sans configurer manuellement quoi que ce soit.

#### Affichage du formulaire dans un template Twig

Pour afficher notre formulaire, il faut que notre contrôleur transmette un objet `FormView` à notre vue :

```diff
public function index(Request $request, ArticleRepository $articleRepository, EntityManagerInterface $em): Response
{
  $newsletter = new Newsletter();
  $form = $this->createForm(NewsletterType::class, $newsletter);

  $form->handleRequest($request);

  if ($form->isSubmitted() && $form->isValid()) {
    $em->persist($newsletter);
    $em->flush();
  }

  // 1 - Je récupère les articles en discutant avec ma couche de service
  $articles = $articleRepository->findTop(Article::NB_HOME);

  // 2 - Je transmets les articles à la vue que je souhaite afficher
+  return $this->render('index/index.html.twig', [
+    'articles' => $articles,
+    'newsletterForm' => $form->createView()
+  ]);
}
```

> On utilise la méthode `createView` de notre objet de formulaire pour créer l'instance de `FormView` dont le template a besoin

Ensuite, dans la vue, on peut afficher le formulaire avec les méthodes Twig disponibles.

La plus basique est la méthode `form` :

```twig
{{ form(newsletterForm) }}
```

Cette méthode va simplement générer le code HTML pour **tout** le formulaire.

Si on veut avoir plus de contrôle sur la manière d'afficher notre formulaire, on peut utiliser les [méthodes personnalisées](https://symfony.com/doc/current/form/form_customization.html) également à disposition.

#### Appliquer un thème au formulaire

On peut utiliser différents thèmes fournis par Symfony. Dans notre cas, vu qu'on utilise Bootstrap, on peut indiquer à Twig d'utiliser le thème correspondant.

Ainsi, dans la configuration du package Twig (`config/packages/twig.yaml`) :

```yaml
twig:
  # ...
  form_themes: ["bootstrap_4_layout.html.twig"]
```

#### Relier deux entités

Lors de la construction du formulaire, comment déclarer le champ qui va servir à relier une entité à une autre ?

Il suffit d'utiliser le type [`EntityType`](https://symfony.com/doc/current/reference/forms/types/entity.html) :

```php
// src/Form/ArticleType.php
$builder
  // ...
  ->add('categories', EntityType::class, [
    'class' => Category::class,
    'choice_label' => 'name',
    'multiple' => true,
    'expanded' => true
  ])
```

Ici, on fait en sorte qu'un article puisse être relié à plusieurs catégories, avec les différentes options disponibles (utilisation de `multiple` et `expanded`).

La documentation nous informe qu'il est également possible d'utiliser le type `EntityType` dans le cadre d'une relation `ManyToOne`.

Dans tous les cas, ce qu'il faut en retenir, c'est que ce type de champ va chercher les éléments de la `class` indiquée (ici `Category::class`), et affichera sous forme de libellé le champ de la classe indiqué (ici `name`).

### Les messages flash

Lors de la réalisation d'un formulaire, il est toujours utile d'assurer un retour à l'utilisateur, sous forme de message.

Un système mis à disposition par Symfony, et largement utilisé dans le cas des formulaires, est celui des **messages flash**.

Les messages flash ont un fonctionnement très simple :

- Lorsqu'on ajoute un message flash depuis un contrôleur, celui-ci s'ajoute en session dans `FlashBag`
- Si on souhaite afficher un message flash dans un template, on peut utiliser la variable globale `app` fournie par Symfony
- Une fois le message affiché, il est **automatiquement** supprimé du FlashBag. C'est donc idéal pour l'affichage de notifications, qui n'ont besoin d'être consommées qu'une fois

Le `FlashBag` est en réalité intégré à la session PHP courante.

On peut ajouter un message avec n'importe quel type, pour le classer dans une catégorie ou une autre.

Exemple complet issu de notre formulaire de contact :

> `src/Controller/ContactController.php`

```php
public function index(Request $request, EntityManagerInterface $em): Response
{
  $contact = new Contact();
  $form = $this->createForm(ContactType::class, $contact);

  $form->handleRequest($request);

  if ($form->isSubmitted() && $form->isValid()) {
    try {
      $em->persist($contact);
      $em->flush();

      // Ajout d'un message flash de type 'success'
      $this->addFlash(
        'success',
        'Votre demande a bien été enregistrée !'
      );
    } catch (Exception $e) {
      // Ajout d'un message flash de type 'danger'
      $this->addFlash(
        'danger',
        'Une erreur est survenue pendant l\'enregistrement de votre demande'
      );
    }
  }

  return $this->render('contact/index.html.twig', [
    'contact_form' => $form->createView()
  ]);
}
```

> `templates/contact/index.html.twig`

```twig
{% for label, messages in app.flashes(['success', 'danger']) %}
  {% for message in messages %}
    <div class="alert alert-{{ label }}" role="alert">
      {{ message }}
    </div>
  {% endfor %}
{% endfor %}
```

Plus de détails pour les messages flash [ici](https://symfony.com/doc/current/controller.html#flash-messages).

Plus de détails sur la variable `app` [ici](https://symfony.com/doc/current/templates.html#twig-app-variable).

### Utilisateurs

Pour ajouter des utilisateurs à notre application, rien de plus simple :

```bash
php bin/console make:user
```

Cette commande crée une entité spéciale, car elle implémente l'interface `UserInterface`, avec laquelle travaille le `Security component` de Symfony.

D'ailleurs, cette commande met également à jour le fichier de configuration du composant `Security`, en ajoutant notamment un **provider**, un fournisseur d'utilisateurs à notre application :

> Fichier : config/packages/security.yaml

```yaml
providers:
  app_user_provider:
    entity:
      class: App\Entity\User
      property: email
```

Ici, la propriété `email` sera celle utilisée pour identifier un utilisateur de manière unique.

Le fichier de configuration du composant `Security` inscrit également ce fournisseur en tant que fournisseur du **pare-feu principal** :

> Fichier : config/packages/security.yaml

```yaml
firewalls:
  main:
    anonymous: lazy
    provider: app_user_provider
```

> Le **provider** est ce qui permettra au composant de sécurité de récupérer l'utilisateur depuis la session PHP, une fois qu'on est authentifié

#### Authentification

Une fois l'entité `User` créée, le fournisseur d'utilisateurs enregistré, il faut encore ajouter un système **d'authentification** dans l'application.

Symfony nous permet également de réaliser ce système de manière extrêment simple. Nous allons créer un "form login" :

```bash
php bin/console make:auth
```

Cette commande permet de créer un `Authenticator`, qui va être chargé d'authentifier les utilisateurs dans notre application.

> Il faut donc faire la différence entre un **Authenticator**, qui permet d'identifier l'utilisateur à partir des valeurs fournies (nom d'utilisateur / mot de passe), et un **provider** qui lui entre en scène une fois que l'on est déjà authentifié, pour "rafraîchir" les données de l'utilisateur

Le fichier de configuration du package de sécurité est également mis à jour automatiquement pour référencer l'`Authenticator` :

> Fichier : config/packages/security.yaml

```yaml
main:
  anonymous: lazy
  provider: app_user_provider
  guard:
    authenticators:
      - App\Security\AppAuthenticator
  logout:
    path: app_logout
```

L'`Authenticator` se trouve donc dans le dossier `src/Security/AppAuthenticator.php` dans cet exemple. Tout dépend de comment vous l'avez nommé.

Enfin, on retrouvera dans l'application tous les autres fichiers qui permettent de gérer un login dans l'application :

- src/Controller/SecurityController.php
- src/Form/CategoryType.php
- templates/security/login.html.twig

#### Contrôle d'accès

Créer une entité `User` et un système d'authentification ne permet pas de limiter l'accès à certaines sections du site.

Par défaut, nous pouvons toujours naviguer dans l'intégralité du site, sans avoir besoin de s'authentifier.

Pour pouvoir limiter l'accès à certaines sections du site, nous pouvons agir sur la configuration du package `Security`, dans la section `access_control` :

```yaml
access_control:
  - { path: ^/admin, roles: ROLE_ADMIN }
```

On peut renseigner un format d'URL (ici : tout ce qui commence par "/admin"), et indiquer à quel rôle d'utilisateurs cette catégorie d'URL est réservée.

### CRUD

Pour créer un CRUD sur une entité, on peut aussi utiliser la console :

```bash
php bin/console make:crud
```

On retrouvera la classe de contrôleur contenant toutes les méthodes nécessaires à la création, l'affichage, l'édition et la suppression d'enregistrements de cette entité, ainsi que les templates d'affichages nécessaires.

Egalement, un formulaire sera créé automatiquement dans le dossier `src/Form` pour pouvoir générer les champs d'édition.
