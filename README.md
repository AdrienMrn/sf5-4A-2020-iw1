## Installation avec docker

- docker-compose build --no-cache
- docker-compose up -d 

Pour Windows : 
```
$ cd docker/nginx/
$ find . -name "*.sh" | xargs dos2unix
```

## Debug docker 

- docker-compose ps
- docker-compose logs -f [CONTAINER(php|node|nginx|db)]

## Commandes utiles

#####Maker
```
docker-compose exec php bin/console make:controller
docker-compose exec php bin/console make:entity
docker-compose exec php bin/console make:form
```
#####Mise à jour de votre BDD
```
docker-compose exec php bin/console doctrine:schema:update --dump-sql
docker-compose exec php bin/console doctrine:schema:update --force
```
