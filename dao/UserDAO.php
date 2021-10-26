<?php
require_once __DIR__ . '/DAO.php';
class UserDAO extends DAO {

  public function selectById($id) {
    $sql = "SELECT * FROM `int2_users` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectByEmail($email) {
    $sql = "SELECT * FROM `int2_users` WHERE `email` = :email";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insert($data) {
    $errors = $this->getValidationErrors($data);
    if (empty($errors)) {
      $sql = "INSERT INTO `int2_users` (`email`, `password`, `voornaam`, `naam`, `gebruikersnaam`, `path`) VALUES (:email, :password, :voornaam, :naam, :gebruikersnaam, :path)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':password', $data['password']);
      $stmt->bindValue(':voornaam', $data['voornaam']);
      $stmt->bindValue(':naam', $data['naam']);
      $stmt->bindValue(':gebruikersnaam', $data['gebruikersnaam']);
      $stmt->bindValue(':path', $data['path']);
      
      if($stmt->execute()) {
        $insertedId = $this->pdo->lastInsertId();
        return $this->selectById($insertedId);
      }
    }
    return false;
  }

  public function getValidationErrors($data) {
    $errors = array();
    if (empty($data['email'])) {
      $errors['email'] = 'Geef aub uw email op';
    }
    if (empty($data['password'])) {
      $errors['password'] = 'Geef aub een paswoord op';
    }
    if (empty($data['voornaam'])) {
      $errors['voornaam'] = 'Geef aub uw voornaam op';
    }
    if (empty($data['gebruikersnaam'])) {
      $errors['gebruikersnaam'] = 'Geef aub uw gebruikersnaam op';
    }
    if (empty($data['naam'])) {
      $errors['naam'] = 'Geef aub uw naam op';
    }
   
    return $errors;
  }
}
