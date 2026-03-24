# Project "Forge de Héros"

## Installation :
- You need to create a file in the project called ".env.local". Then, you must add this line to the file : DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
- To be able to upload an image for your characters, you need to remove the ";" at the beginning of the following line in your php.ini file.<br>
";extension=fileinfo"
- You must run the command "composer install" to install the required dependencies of the project.
- To generate entries in the database, run the following command : "php bin/console doctrine:fixtures:load"
- Apply the migration to create the database with this command : "php bin/console doctrine:migrations:migrate"
