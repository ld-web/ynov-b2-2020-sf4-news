# B2 - Symfony

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

> En production par exemple, on ne voudra pas des des dépendances de développement. On pourra ainsi demander à Composer de ne pas les intégrer au projet : `composer install --no-dev`

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
