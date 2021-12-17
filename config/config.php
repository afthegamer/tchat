<?php

/**
 * @var string chaine de caractère correspondant à un DSN pour PDO
 */
const DB_DSN = 'mysql:host=localhost;dbname=tchat;charset=utf8';

/**
 * @var string user Mysql
 */
const DB_USER = 'root';

/**
 * @var string mot de passe Mysql
 */
const DB_PASS = 'root';

/**
 * @var string le nom du layout utilisé. Un fichier LAYOUT.phtml doit exister dans le dossier tpl/
 */
const LAYOUT = 'layout';

/**
 * @var bool si on est en mode developpeur ou non - UTILISE comme exemple dans la page index.php
 */
const MODE_DEV = false;