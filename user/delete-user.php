<?php include('../partials/config.php'); 
    session_start();

    if(isset($_GET['id'])) {

        $id = $_GET['id'];


        $sql = "SELECT * FROM user WHERE id=$id";
        
        $res = $conn->query($sql);

        $count = mysqli_num_rows($res);

        if($count==1) {
            $deletequeary = "UPDATE user SET status=0 WHERE id=$id";

            $deletesql = $conn->query($deletequeary);

            if($deletesql==TRUE) {
                $_SESSION['delete'] = "Data Deleated successfully";
                header('location:'. 'view-user.php');
            }

        }

    }

?>