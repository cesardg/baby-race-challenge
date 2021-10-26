<?php
require_once __DIR__ . '/DAO.php';
class ShopDAO extends DAO {


  public function selectAllShopItems()
  {
    $sql = "SELECT * from `int2_shop` ORDER BY `id` ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectById($id)
  {
    $sql = "SELECT * FROM `int2_shop` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


}
