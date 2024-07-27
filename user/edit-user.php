<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM user WHERE id=$id";

        $res = mysqli_query($conn,$sql);

        $count = mysqli_num_rows($res);

        if($count === 1) {
            $row = mysqli_fetch_assoc($res);
            $name = $row['name'];
            $current_image = $row['image'];
            $bio = $row['bio']; 
        }
        else {
            $_SESSION['no-user-found'] = "user not found";
            header('location:'.'view-user.php');
        }
    }
    else {
        header('location:'.'view-user.php');
    }
?>

<div class="container">
    <h1>Edit User</h1>
    <form action="" method="POST" id="form" enctype="multipart/form-data">
        <fieldset>
            <div class="form-group">
                <label form="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $name;?>">   
            </div>

            <div class="form-group">
                <label form="image">Current Image:</label>
                <?php
                    if($current_image != "") {
                        ?>
                        <img src="../images/<?php echo $current_image; ?>" width="150px">
                     <?php   
                    }
                    else {
                        echo "image not found";
                    }
                ?>
                <!-- <input type="file" name="image" id="image"> -->
            </div>

            <div class="form-group">
                <label form="image">New Image:</label>
                <input type="file" name="image" id="image">
            </div>

            <div class="form-group">
                <label form="bio">Bio:</label>
                <textarea name="bio" id="bio" rows="4" cols="50"><?php echo $bio; ?></textarea> 
            </div>

            <div class="form-group">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" id="submit" value="Edit User">
                </div>

        </fieldset>
    </form>
</div>

<?php
    if(isset($_POST['submit'])) {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $current_image = $_POST['current_image'];
        $bio = $_POST['bio'];

        if(isset($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];

            if($image_name != "") {
                $ext = end(explode('.', $image_name));

                $image_name = "user".rand(000,999).'.'.$ext;

                $source_path = $_FILES['image']['tmp_name'];

                $destination_path = "../images/".$image_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                //remove current image
               if($current_image != "") {
                   $remove_path = "../images/".$current_image;
   
                   $remove = unlink($remove_path);
               }
            }
            else {
					$image_name = $current_image;
			}

        }
        else{
            $image_name = $current_image;
        }


       

        $sql2 = "UPDATE user SET
                name = '$name',
                image = '$image_name',
                bio = '$bio'
                WHERE id=$id
        ";
        $res2 = mysqli_query($conn,$sql2);  
        
        if($res2 == true) {
            $_SESSION['update'] = "user updated.";
            header('location:'. 'view-user.php');
        }
        else {
            $_SESSION['update'] = "falied to update user";
            header('location:'.'view-user.php');
        }

    }

?>


