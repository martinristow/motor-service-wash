<?php require_once 'inc/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/index_style.css">
    <title>Автоперална и Сервис</title>
</head>
<body>
    <header>
        <h1 class="logo">Автоперална и Сервис</h1>
    </header>
<?php
  $sql = "SELECT * FROM posts";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
      $counter = 0;
  
      while ($row = $result->fetch_assoc()) {
          $naslov = $row['naslov'];
          $text = $row['text'];
  
          if ($counter % 2 === 0) {
              // Započinjanje novog reda za svaki par postova
              echo '<div class="flex-container">';
          }
  ?>
  
          <section class="post-section flex-item">
              <div class="container">
                  <h2 class="section-heading"><?php echo $naslov; ?></h2>
                  <p class="description"><?php echo $text; ?></p>
              </div>
          </section>
  
  <?php
          if ($counter % 2 === 1 || $counter === $result->num_rows - 1) {
              // Zatvaranje reda kada je potrebno ili kada je poslednji post
              echo '</div>';
          }
  
          $counter++;
      }
  } else {
      echo "Нема објави во базата.";
  }
?>
    
</body>
</html>

   <?php 
   

   echo "<h2 div class='promocii-text'>Promocii</h2>";
   $sql = "SELECT * FROM promotions ORDER BY promotion_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$resultat = $result->fetch_all(MYSQLI_ASSOC);

foreach ($resultat as $rez) {
    echo '<div class="promotion-container promotion-container1">';
    echo '<div class="promotion-offer">' . $rez['special_offer'] . '</div>';
    echo '<div class="promotion-name"><a href="promocii.php">' . $rez['promotion_name'] . '</a></div>';
    echo '<div class="promotion-description">' . $rez['description'] . '</div>';
    echo '<div class="promotion-price">Сите овие услуги сега на супер цена од само ' . $rez['discount_percentage'] . "$" . '</div>';
    echo '<div class="promotion-description">' . $rez['contact_message'] . '</div>';
    echo '</div>';
}
   ?>
   


<?php require_once 'inc/footer.php'; ?>