<?php

require_once __DIR__ . '/DAO.php';

class CommentDAO extends DAO
{


    // selecteert comments uit database
    public function selectCommentsForPost($image_id)
    {
        $sql = "SELECT * FROM `int2_comments` WHERE `image_id` = :id ORDER BY `id` DESC";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $image_id);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function selectCommentById($id)
    {
        $sql = "SELECT * FROM `int2_comments` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //insert comments in de database
    public function insert($data)
    {
        $errors = $this->validate($data);

        if (empty($errors)) {
            $sql = "INSERT INTO `int2_comments` (`image_id`, `comment`, `parent`) VALUES (:image_id, :comment, :parent)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':image_id', $data['image_id']);
            $stmt->bindValue(':comment', $data['text']);
            $stmt->bindValue(':parent', $data['parent']);
            if ($stmt->execute()) {
                return $this->selectCommentById($this->pdo->lastInsertId());
            }
        }
        return false;
    }

  

    // valideerd de waarden van comments
    public function validate($data)
    {
        $errors = [];
       if (empty($data['image_id'])) {
          $errors['image_id'] = 'id not valid';
       }
        if (empty($data['text'])) {
            $errors['text'] = 'Vul aub een comment in';
        }
       if (empty($data['parent'])) {
           $errors['parent'] = 'parent';
       }
        return $errors;
    }
}
