## Installation avec docker

- docker-compose build --no-cache
- docker-compose up -d 

Pour Windows : 
```
$ cd docker/nginx/
$ find . -name "*.sh" | xargs dos2unix
```

##### Debug docker 

- docker-compose ps
- docker-compose logs -f [CONTAINER(php|node|nginx|db)]

## Commandes utiles

##### Maker
```
docker-compose exec php bin/console make:controller
docker-compose exec php bin/console make:entity
docker-compose exec php bin/console make:form
docker-compose exec php bin/console make:crud
```

## Doctrine
##### Mise à jour de votre BDD avec Doctrine:Schema:Update
```
// Voir les réquètes préparées
docker-compose exec php bin/console doctrine:schema:update --dump-sql
// Jouer les requètes préparées
docker-compose exec php bin/console doctrine:schema:update --force
```
##### Relation
https://symfony.com/doc/current/doctrine/associations.html 

##### Custom query avec DQL (repository)
https://symfony.com/doc/current/doctrine.html#querying-with-the-query-builder
https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/query-builder.html

##### MAJ BDD avec les migrations
https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html
```
docker-compose exec php bin/console make:migration
```

## DataFixtures
##### Installation et utilisation
https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html 
```
composer require --dev doctrine/doctrine-fixtures-bundle
docker-compose exec php bin/console make:fixtures
php bin/console doctrine:fixtures:load
```
##### Utilisation avec FakerBundle 
https://github.com/fzaninotto/Faker

## Creation du système d'authentification

##### Création de l'entity User qui implement UserInterface (utiliser par le système Auth de SF5)
``` 
docker-compose exec php bin/console make:user 

// pensez à changer au sein de l'entity user les règles de votre table si vous utilisez PostgreSQL
@ORM\Table(name="user_account", schema="PROJECT_NAME") 
```

##### Installation du système d'authentification via maker
```
docker-compose exec php bin/console make:auth 
```

##### Encodage via commande du MDP (avec hash configuré dans votre projet)
```
docker-compose exec php bin/console security:encode-password 
```
