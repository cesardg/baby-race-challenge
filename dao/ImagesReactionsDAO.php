<?php

require_once __DIR__ . '/DAO.php';

class ImagesReactionsDAO extends DAO
{


    // selecteert reactie uit database
    public function selectReactionsForPost($comment_id, $reaction_id)
    {
        $sql = "SELECT * FROM `int2_images_reactions` WHERE `image_id` = :id AND `reaction_id` = :reaction_id " ;
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $comment_id);
        $statement->bindValue(':reaction_id', $reaction_id);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // selecteert reacties per id
    public function selectReactionById($id)
    {
        $sql = "SELECT * FROM `int2_images_reactions` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    //insert reacties in de database
    public function insertReactions($reactionsData)
    {
        $errorsReactions = $this->validate($reactionsData);

        if (empty($errorsReactions)) {
            $sql = "INSERT INTO `int2_images_reactions` (`image_id`, `reaction_id`) VALUES (:image_id, :reaction_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':image_id', $reactionsData['image_id']);
            $stmt->bindValue(':reaction_id', $reactionsData['reactie']);
   
            if ($stmt->execute()) {
               return  $this->selectReactionById($this->pdo->lastInsertId());
            }
        }
        return false;
    }

    public function validate($data)
    {
        $errorsReactions = [];
        if (empty($data['image_id'])) {
            $errorsReactions['image_id'] = 'id is not valid';
        }
        if (empty($data['reactie'])) {
            $errorsReactions['reactie'] = 'Gelieve een reactie aan te duiden';
        }
      
        return $errorsReactions;
    }
}
