## Mise en place du projet

Installation des dépendances PHP
```shell
composer install
```

Copier le fichier .env à la racine du projet, renommer la copie en .env.local
Mettre à jour la connexion à la base de données :
```dotenv
DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony_base_2?serverVersion=5.7"
```

Créer la base de données :
```shell
symfony console doctrine:database:create
```

Installer les assets :
```shell
yarn install
```

Lancer le serveur et le watch des assets :
```shell
symfony serve
```
```shell
yarn watch
```

## La boutique (Front Office)

### Diagramme de classe
Diagramme de classe de l'application

![](C:\dev\formation\symfony-bases-2\ressources-enonce\diagram-classes.png)

### ProductController

Faire le ProductController avec deux routes principales :

- [ ] l'index `/products` qui liste les produits disponibles.
- [ ] la page détails d'un produit : `/products/{slug}`

Les templates associés :

![](C:\dev\formation\symfony-bases-2\ressources-enonce\front-products-index.png)

![](C:\dev\formation\symfony-bases-2\ressources-enonce\front-products-details.png)



### CategoryController

Faire le CategoryController avec deux routes principales :

- [ ] l'index `/categories` qui liste les catégories disponibles.
- [ ] la page d'une catégorie qui liste ses produits : `/categories/{slug}`

Les templates associés :

![](C:\dev\formation\symfony-bases-2\ressources-enonce\front-categories-index.png)
![](C:\dev\formation\symfony-bases-2\ressources-enonce\front-categories-details.png)

### CartController

- [ ] Une simple route `/cart` qui affiche le contenu du panier de l'utilisateur courent

![](C:\dev\formation\symfony-bases-2\ressources-enonce\front-cart-details.png)

### L'administration (Back Office)

Exemple avec les utilisateurs, à reproduite pour toutes les entités :

- Une route index `/users`
- Une route de création `/users/new`
- Une route d'édition `/users/{id}/edit`
- Une route d'affichage `/users/{id}/`

Templates associés :
![](C:\dev\formation\symfony-bases-2\ressources-enonce\admin-users-index.png)

![](C:\dev\formation\symfony-bases-2\ressources-enonce\admin-users-new.png)

