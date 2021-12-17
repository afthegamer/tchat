<?php

/** Retourne tous les clients
 * @param PDO $dbh
 * 
 * @return array jeu de résultat
 */
function messageFindAll(PDO $dbh) : array
{
    $sql = 'SELECT *
            FROM message 
            ORDER BY m_create_at ASC';
    return dbSelectAll($dbh, $sql);
}


/** Retourne tous les clients
 * @param PDO $dbh
 * @param DateTime $date la date à partir d'où rechercher les nouveaux message
 * @return array jeu de résultat
 */
function messageFindLast(PDO $dbh, DateTime $date) : array
{
    //echo $date->format('Y-m-d H:i');exit();
    $sql = 'SELECT *
            FROM message
            WHERE m_create_at > :date
            ORDER BY m_create_at ASC';
    return dbSelectAll($dbh, $sql, ['date'=>$date->format('Y-m-d H:i:s')]);
}


/** Enregistre un message dans la base de données
 * @param PDO $dbh
 * @param string $username
 * @param string $content
 * @return string dernier identifiant enregistré dans la base ou false
 */
function messageInsert(PDO $dbh, string $username, string $content)
{
    $sql = 'INSERT INTO message (m_content, m_create_at, m_username) 
            VALUES (:content, NOW(), :username);';
    return dbExecute($dbh, $sql,['content'=>$content,'username'=>$username]);

}