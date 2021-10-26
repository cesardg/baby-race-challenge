<?php

require_once __DIR__ . '/DAO.php';

class ForumDAO extends DAO
{



    //selecteerd de questions
    function selectAllQuestions()
    {
        $sql = "SELECT * from `int2_forum` ORDER BY `id` DESC LIMIT 100";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function selectAwnsersByQuestion($question)
    {
        $sql = "SELECT * FROM `int2_forum_awnsers` INNER JOIN `int2_users` on int2_forum_awnsers.user_id=int2_users.id WHERE `question_id` = :question ORDER BY `awnser_id` DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':question', $question);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function selectPostBySearch($topic)
    {
        $sql =  "SELECT * FROM `int2_forum` WHERE `topic` LIKE :topic  ORDER BY `id` DESC ";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':topic', '%' . $topic . '%');

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function selectQuestionsById($id)
    {
        $sql = "SELECT * FROM `int2_forum` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAwnserById($id)
    {
        $sql = "SELECT * FROM `int2_forum_awnsers` WHERE `awnser_id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    //insert questions in de database
    public function insert($data)
    {
        $errors = $this->validate($data);

        if (empty($errors)) {
            $sql = "INSERT INTO `int2_forum` ( `user_id`, `topic`, `question`) VALUES ( :userid, :topic, :question)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':userid', $data['user-id']);
            $stmt->bindValue(':topic', $data['topic']);
            $stmt->bindValue(':question', $data['question']);

            if ($stmt->execute()) {
                return $this->selectQuestionsById($this->pdo->lastInsertId());
            }
        }
        return false;
    }

    //insert antwoorden in de database
    public function insertAwnser($data)
    {
        $errors = $this->validateAwnser($data);

        if (empty($errors)) {
            $sql = "INSERT INTO `int2_forum_awnsers` (`question_id`, `awnser`, `user_id`) VALUES (:question_id, :awnser, :userid)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':awnser', $data['awnser']);
            $stmt->bindValue(':question_id', $data['question_id']);
            $stmt->bindValue(':userid', $data['user-id']);
            if ($stmt->execute()) {
                return $this->selectAwnserById($this->pdo->lastInsertId());
            }
        }
        return false;
    }


    // valideerd de waarden van vragen
    public function validate($data)
    {
        $errors = [];
        if (empty($data['topic'])) {
            $errors['topic'] = 'vul aub een onderwerp in';
        }
        if (empty($data['question'])) {
            $errors['question'] = 'vul aub een vraag in';
        }

        return $errors;
    }

    // valideerd de waarden van antwoorden
    public function validateAwnser($data)
    {
        $errors = [];
        if (empty($data['awnser'])) {
            $errors['awnser'] = 'Vul aub een antwoord in';

            // ik geef hier het id mee zodat ik bij javascript de foutmelding kan laten geven bij het juiste input veld

            $errors['awnserid'] = $data['question_id'];
        }


        return $errors;
    }
}
