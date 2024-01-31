<?php 

require_once 'inc/header.php';


        
$sql = "SELECT * FROM promotions ORDER BY promotion_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$resultat = $result->fetch_all(MYSQLI_ASSOC);

foreach ($resultat as $rez) {
    
    echo '<div class="promotion-container">';
    echo '<div class="promotion-offer"> ' . $rez['special_offer'] . '</div>';
    echo '<div class="promotion-name"><a href="promocii.php">' . $rez['promotion_name'] . '</a></div>';
    echo '<div class="promotion-description">' . $rez['description'] . '</div>';
    echo '<div class="promotion-price">Сите овие услуги сега на супер цена од само ' . $rez['discount_percentage'] . "$" . '</div><br>';
    echo '<div style=" padding: 10px; margin-bottom: 10px;" ">' . $rez['contact_message'] . '</div>';

    
    echo '</div>';
}


?>
<?php require_once 'inc/footer.php'; ?>
