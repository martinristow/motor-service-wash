<style>.poraka {
    font-size: 1.5em;
    font-weight: bold;
    color: #007bff;
    text-align: center;
    margin-top: 20px;
}
</style>
<?php
require_once 'inc/header.php';
//OVA E ZA DA MU SE PRIKAZUVAAT NOTIFIKACIITE NA USEROT PRATENI OD ADMINOT
// Добиј го тековниот user_id од сесијата
$current_user_id = $_SESSION['user_id'];

// SQL упит за избор на notifications за тековниот корисник
$sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY notification_id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();

// Добиј резултати
$result = $stmt->get_result();
$resultat = $result->fetch_all(MYSQLI_ASSOC);
echo '<div class="poraka">Пораки<br><br></div>';


// Печати ги податоците или прави нешто со нив
foreach ($resultat as $rez) {
    
    
echo '<div class="message-container">';
echo '<div class="message-text">' . "<h4>НАМБ тим</h4>". "" . $rez['message'] . '</div>';
echo '<div class="timestamp-text">' . $rez['timestamp'] . '</div>';
echo '</div><br>';}
?>



<?php require_once 'inc/footer.php'; ?>