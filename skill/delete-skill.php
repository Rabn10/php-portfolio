<?php include('../partials/config.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM skills WHERE id=$id";

    $res = $conn->query($sql);

    $count = mysqli_num_rows($res);

    if($count == 1) {
        $deletequery = "UPDATE skills SET status=0 WHERE id=$id";

        $deletesql = $conn->query($deletequery);

        if($deletesql == TRUE) {
            $_SESSION['delete'] = "project deleted successfully";
            header('location:'. 'view-skill.php');
        }
    }

}

?>