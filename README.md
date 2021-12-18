# tchat
 Pour lancer le projet si il est lancer en local il faudras un outil tel que WAMP,MAMP,LARAGON... 
 Si c'est déployer sur un serveur ne préter pas attation a l'étape précédente.

Une fois l'environement préparer, il faut configurer le chemein d'accèes vers votre base de donnée MySql qui ce fait dans config/config.php, si vous faite en local vous n'avais rien as modifier dans 
ce fichier.
A l'inverse, si votre base de donnée n'ai pas en local il vous faudra modifier dans le fichier config.php la constente DB_DSN le mot localhost par l'addresse qui permet l'accèe a votre base de donnée

Biensure si néssaire le nom d'utilisateur et le mot de passe qui permet la connection a votre base de donner sont a modifier (DB_USER & DB_PASS).

Quand la connection est faite il ne reste plus que a créer unbe base de donner avec comme nom: tchat.

```sql
CREATE DATABASE `tchat` CHARACTER SET utf8 COLLATE utf8_general_ci;
```

selctionner tchat puis créer la table :

```sql
CREATE TABLE IF NOT EXISTS `message` (
   `m_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
   `m_content` TEXT NOT NULL,
   `m_create_at` DATETIME NULL,
   `m_username` VARCHAR(45) NULL,
   PRIMARY KEY (`m_id`))
 ENGINE = InnoDB;
 ```
 il se peux que le tout premier message du premier utilisateur qui sera envoyer puis enregistre dans la base de donnée, ne s'affichera pas automatiquement ainsi que les autres message qu'il ne verra pas , 
 il faudra juste actualiser la page et cela fonctionnera pour de bon ( ce bug n'as effect que sur le tout premier message qui serra en registre dans la base de donnée )
