<?php 
class User{
    protected $conn;

    public function __construct(){
        global $conn;
        $this->conn = $conn;
    }

    public function create($name, $username, $email, $password){
        //proveruvame dali postoi korisnik so vekje vneseniot email ili username
        if ($this->isUsernameTaken($username) || $this->isEmailTaken($email)) {
            return false; // Korisnikot vekje postoi
        }
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);//stavame zastita na passwordot
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        $result = $stmt->execute();
    
        if ($result) {
            $_SESSION['user_id'] = $stmt->insert_id;
            return true;
        } else {
            return false;
        }
    }
    
    // Funkcija koja proveruva dali vekje postoe korisnik so istiot username 
    private function isUsernameTaken($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    
    // Funkcija koja proverava dali postoi korisnik so ista email adresa
    private function isEmailTaken($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    


    //FUNKCIJA ZA LOGIN SISTEM
    public function login($username, $password){
        $sql = "SELECT user_id, password FROM users WHERE username = ?";// SQL упит за добивање корисник со даденото корисничко име
        $stmt = $this->conn->prepare($sql);// SQL упит за добивање корисник со даденото корисничко име
        $stmt->bind_param("s",$username);// Поврзување на параметарот (корисничкото име) со SQL упитот
        $stmt->execute();// Извршување на SQL упитот

        $results = $stmt->get_result();// Добивање на резултатите од извршениот упит

        if($results->num_rows == 1){// Проверка дали постои корисник со даденото корисничко име
            $user = $results->fetch_assoc();   // Добивање на информации за корисникот

            if(password_verify($password,$user['password'])){//tuka prviot password e nie toj password 
                //sto sme go vnele a drugiot $user['password'] ni e passwordot od bazata 
                $_SESSION['user_id'] = $user['user_id'];// Ако лозинката е точна, постави го корисничкиот идентификатор во сесијата

                return true;// Врати вистина, што значи успешна автентикација
            }
        }
        return false;// Врати невистина, што значи неуспешна автентикација

    }
    //TUKA ZAVRSUVA OVAA FUNKCIJA NA LOGIN

    public function is_admin(){
        $sql = "SELECT * FROM users WHERE user_id = ? AND user_type = 'admin'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$_SESSION['user_id']);//proveruvame dali najaveniot korisnik go ima vo bazata i dali istitot e admin
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            return true;
        }

        return false;
    }

    public function is_employee(){
        $sql = "SELECT * FROM users WHERE user_id = ? AND user_type = 'employee'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$_SESSION['user_id']);//proveruvame dali najaveniot korisnik go ima vo bazata i dali istitot e employee
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            return true;
        }

        return false;
    }

 

    //METODA ZA PROVERKA DALI E NAJAVEN USEROT
    public function is_logged(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        return false;
    }
    //TUKA ZAVRSUVA OVAA METODA/FUNKCIJA 


    //FUNKCIJA ZA LOGOUT
    public function logout(){
       
        
        unset($_SESSION['user_id']);
    }
    

  
}

?>