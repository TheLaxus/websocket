<?php
//by Wake, Laxus and Dut
  if(!isset($_SESSION)){
    session_start();
  }
  
  header('Content-Type: application/json');
  
  if(extract($_POST) && isset($_SESSION['username'])) {
    require_once ("../../configuration/class/class.pdo.php");
    
    $MyPDO = new MyPDO();
    $bdd = $MyPDO->connection();
    
    $consultUser = $bdd->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $consultUser->bindValue(1, $_SESSION['username']);
    $consultUser->execute();
    
    if($consultUser->rowCount() > 0){
      $user = $consultUser->fetch(PDO::FETCH_ASSOC);
      
      $orders = array();
      
      // Fazendo consulta no banco de dados
      
      $consultSockets = $bdd->prepare("SELECT id,action,type,hash,label FROM sockets_engagements WHERE viewed = ? AND hash = ?");
      $consultSockets->bindValue(1, '0');
      $consultSockets->bindValue(2, $user['id']);
      $consultSockets->execute();
      
      if($consultSockets->rowCount() > 0) {
        $sockets = $consultSockets->fetch(PDO::FETCH_ASSOC);
        $orders = $sockets;
        
        for($i = 0; $i < count($orders); $i++ {
          $hash = $orders[$i]['hash'];
        }
        
        echo json_encode([
          "orders" => $orders
        ]);
            
        for ($i = 0; $i < count($orders); $i++) {
          $setOrderViewed = $bdd->prepare("UPDATE sockets_engagements SET viewed = ? WHERE id = ?");
          $setOrderViewed->bindValue(1, '1');
          $setOrderViewed->bindValue(2, $orders[$i]['id']);
          $setOrderViewed->execute();
        }
     } else {
       echo json_encode([]);
     }
            
     exit;
  }else {*/
    echo 'Cannot get' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '';
?>
   
