<?php 
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$sport = $_POST['sport'];
$phone = $_POST['phone'];

if(!empty($firstname) || !empty($lastname) || !empty($email) || !empty($sport) || !empty($phone)){
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "final_db";

    $conn = mysqli_connect($host,$dbUsername,$dbPassword,$dbname);
    if(mysqli_error($conn)){

    	die('Connect Error('. mysqli_connect_error().')'.mysqli_connect_error());
    }else{
        $SELECT = "SELECT email From booking Where email = ? Limit 1";
        $INSERT = "INSERT Into booking (firstname, lastname,email,sport, number) values(?,?,?,?,?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0){

        	$stmt->close();

        	$stmt = $conn->prepare($INSERT);
        	$stmt->bind_param("ssssi", $firstname, $lastname, $email, $sport, $phone);
        	$stmt->execute();
        	echo "You have booked successfully";
        }else {

        	echo "Someone already booked with this email";
        }

        $stmt->close();
        $conn->close();
    }
}else {
	echo "All field are required";
	die();
}

?>