# CVTHEQUE WEMOOV
Gestion des CV (Symfony 4)




## Prérequis
- apache2.4
- mysql5.7
- php7.3

Exemple de virtual host :
```
<VirtualHost *:80 *:443>
        DocumentRoot "/chemin/projet/cvtheque/back/public"
        ServerName cvtheque.local
        ServerAlias www.cvtheque.local
        ErrorLog "/private/var/log/apache2/cvtheque.local-error_log"
        CustomLog "/private/var/log/apache2/cvtheque.local-access_log" common

        <Directory "/chemin/projet/cvtheque/back/public">
            AllowOverride All
            Order Allow,Deny
            Allow from All
            FallbackResource /index.php
        </Directory>
</VirtualHost>
```

## Docker
Structure prête à l'emploi
Non opérationnel sur le poste utilisé -> si vous trouvez la solution, c'est good !
/!\ Penser à mapper les volumes pour sauvegarder vos développements



## Installation
Backend / Frontend
- Mettre à jour le fichier `.env` avec les variables nécessaires
- Mettre à jour les dépendances via le terminal
```
composer update
```
- Créer la base de données via le terminal
```
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```
- Injecter 2 utilisateurs (administrateur & ressources humaines)
```
bin/console doctrine:fixtures:load
```

## Utilisateurs pré-injectés dans les scripts
| login | password | role |
| ------ | ------ | ------ |
| admin@admin.fr | 0000 | administrateur |
| hr@hr.fr | 0000 | ressources_humaines |



## Fonctionnalités mises en oeuvre

#### Générale :
* S'authentifier
* Créer un compte (... Création implicite du candidat ...Nécessité de se logger ensuite)
* Se déconnecter

#### Administrateur :
* Lister les utilisateurs
* Modifier le rôle d'un utilisateur
* Supprimer un utilisateur

#### Ressources humaines :
* Lister les candidats
* Afficher un candidat
* Modifier un candidat
* Afficher le cv d'un candidat
* Imprimer le cv d'un candidat

#### Candidat :
- Editer le profil
- Lister les formations (CRUD)



## TODO :
> Finaliser les fonctionnalités du candidat (expériences professionnelles, centre d'intérêts, compétences)
> FrontEnd dans un langage JS 


Bon courage !!
