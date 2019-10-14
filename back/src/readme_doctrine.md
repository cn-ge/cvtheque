

bin/console doctrine:database:create
bin/console make:entity NomObjet => génére bo (/Entity) + dal (/Repository)
bin/console make:migration  => génére le script (/Migrations)
bin/console doctrine:migrations:migrate  => transfère à la base données