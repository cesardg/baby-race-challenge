<?php

require_once __DIR__ . '/DAO.php';

class ReactionsDAO extends DAO
{

    //selecteerd de 3 reacties uit de db
    function selectAllReactions()
    {
        $sql = "SELECT * FROM `int2_reactions`";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
  
}
