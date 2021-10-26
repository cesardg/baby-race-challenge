<?php

require_once __DIR__ . '/DAO.php';

class PostDAO extends DAO
{

    //selecteerd de meest nieuwe posts en telt aantal reactions op
    function selectAllPostsRecent()
    {
        $sql = "SELECT * from `int2_images` ORDER BY `id` DESC LIMIT 100";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    //selecteerd de meest nieuwe posts en telt aantal reactions op
    function selectAllPostsSpeed()
    {
        $sql = "SELECT * from `int2_images` ORDER BY `time` ASC LIMIT 100";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    function selectPostsByUser($gebruiker)
    {
        $sql = "SELECT * from `int2_images` WHERE `user_id` = :userid  ORDER BY `time` ASC LIMIT 100";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':userid', $gebruiker);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }


    //SELECT int2_images.id, int2_images.name, int2_images.parent, int2_images.path, int2_images.parent2, int2_images.path, int2_images.time COUNT(int2_images_reactions.reaction_id) AS amount_reactions FROM `int2_images` LEFT JOIN int2_images_reactions ON int2_images.id = int2_images_reactions.image_id GROUP BY int2_images.id ORDER BY `id` DESC LIMIT 100

    //selecteerd de hall of fame posts
    function selectHallOfFamePosts()
    {
        $sql = "SELECT * from `int2_images` ORDER BY `time` ASC LIMIT 3";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }


    //selecteerd post bij id
    function selectPostById($post_id)
    {
        $sql = "SELECT * FROM `int2_images` WHERE `id` = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $post_id);
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    //selecteert posts die net een beetje sneller zijn
    function selectFasterPosts($time)
    {
        $sql = "SELECT * FROM `int2_images` WHERE `time` < :time LIMIT 3";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':time', $time);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    //selecteert gebruiker bij naam
    public function selectUserByPost($user)
    {
        $sql = "SELECT * FROM `int2_users` WHERE `id` = :user ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user', $user);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // insert een nieuwe post
    public function createPost($data)
    {
        $errors = $this->validate($data);

        if (empty($errors)) {
            $sql = "INSERT INTO `int2_images` (`name`, `user_id`, `parent2`, `time`, `path`) VALUES (:name, :userid, :parent2, :time, :path)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':name', $data['name-baby']);
            $stmt->bindValue(':userid', $data['user-id']);
            $stmt->bindValue(':parent2', $data['name-partner']);
            $stmt->bindValue(':time', $data['time']);
            $stmt->bindValue(':path', $data['path']);
            if ($stmt->execute()) {
                return $this->selectPostById($this->pdo->lastInsertId());
            }
        }
        return false;
    }



    //valideert de post
    public function validate($data)
    {
        $errors = [];
        if (empty($data['path'])) {
            $errors['path'] = 'Gelieve een foto in te laden';
        }
        if (empty($data['name-baby'])) {
            $errors['name-baby'] = 'Gelieve de naam van de baby in te vullen';
        }
        if (empty($data['name-partner'])) {
            $errors['name-partner'] = 'Gelieve de naam van u partner of vriend(in) in te vullen';
        }
        if (empty($data['time'])) {
            $errors['time'] = 'Gelieve de tijd in te vullen';
        }


        return $errors;
    }
}
