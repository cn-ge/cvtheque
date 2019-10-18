# CVTHEQUE WEMOOV
Gestion des CV (Symfony 4)




## Prérequis
- apache2.4 (mettre en place un virtual host)
- mysql5.7
- php7.3



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
