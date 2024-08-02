<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM skills WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $skill = $row['skill'];
            $level = $row['level'];
            $current_image = $row['image'];
        }
        else {
            $_SESSION['no-skill-found'] = 'skill not found';
            header('location:'. 'view-skill.php');
        }
    }
?>

<div class="container">
    <h1>Edit Skill</h1>
    <form action="" method="POST" id="form" enctype="multipart/form-data">
        <fieldset>
            <div class="form-group">
                <label form="skill">Skill:</label>
                <input type="text" name="skill" id="skill" placeholder="enter skill" value="<?php echo $skill;?>">
            </div>

            <div class="form-group">
                <label form="level">Level:</label>
                <textarea name="level" id="level" rows="4" cols="50"><?php echo $level;?></textarea>
            </div>

            <div class="form-group">
                <label form="image">Current Image:</label>
                <?php
                    if($current_image != "") {
                        ?>
                        <img src="../images/skills/<?php echo $current_image; ?>" width="150px">
                     <?php   
                    }
                    else {
                        echo "image not found";
                    }
                ?>
                <!-- <input type="file" name="image" id="image"> -->
            </div>

            <div class="form-group">
                <label form="image">Image:</label>
                <input type="file" name="image" id="image"> 
            </div>

            <div class="form-group">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" id="submit" value="Edit Skill">
            </div>

        </fieldset>
    </form>
</div>

<?php

    if(isset($_POST['submit'])) {

        $id = $_POST['id'];
        $skill = $_POST['skill'];
        $current_image = $_POST['current_image'];

        if(isset($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];

            if($image_name != "") {
                $ext = end(explode('.', $image_name));

                $image_name = "skill". rand(000,999). '.' .$ext;

                $source_path = $_FILES['image']['tmp_name'];

                $destination_path = "../images/skills/".$image_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                if($current_image != "") {
                    $remove_path = "../images/".$current_image;
    
                    $remove = unlink($remove_path);
                }
            } 
            else {
                $image_name = $current_image;
            }
        }
        else {
            $image_name = $current_image;
        }

        $sql2 = "UPDATE skills SET
                skill = '$skill',
                level = '$level',
                image = '$image_name'
                WHERE id = $id
        ";

        $res2 = mysqli_query($conn, $sql2);

        if($res2 == true) {
            $_SESSION['update'] = 'skill updated';
            header('location:'. 'view-skill.php');
        }
        else {
            $_SESSION['update'] = 'falied to update skill';
            header('location:'. 'view-skill.php');
        }
    }

?>