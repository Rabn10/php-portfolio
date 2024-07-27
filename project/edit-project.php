<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM projects where id=$id";

        $res =mysqli_query($conn,$sql);
         
        $count = mysqli_num_rows($res);

        if($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $description = $row['description'];
            $current_image = $row['image'];
            $url = $row['url'];
        }
        else {
            $_SESSION['no-porject-found'] = 'project not found';
            header('location:'.'view-project.php');
        }
    }
    else {
        header('location:'.'view-project.php');
    }
?>

<div class="container">
    <h1>Edit Project</h1>
    <form action="" method="POST" id="form" enctype="multipart/form-data">
        <fieldset>
            <div class="form-group">
                <label form="title">title:</label>
                <input type="text" name="title" id="title" placeholder="enter title" value="<?php echo $title;?>">
            </div>

            <div class="form-group">
                <label form="description">Description:</label>
                <textarea name="description" id="description" rows="4" cols="50"><?php echo $description;?></textarea>
            </div>

            <div class="form-group">
                <label form="image">Current Image:</label>
                <?php
                    if($current_image != "") {
                        ?>
                        <img src="../images/projects/<?php echo $current_image; ?>" width="150px">
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
                <label form="url">URL:</label>
                <input type="text" name="url" id="url" placeholder="enter url" value="<?php echo $url;?>"> 
            </div>

            <div class="form-group">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" id="submit" value="Edit Project">
            </div>

        </fieldset>
    </form>
</div>

<?php

    if(isset($_POST['submit'])) {
        
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $current_image = $_POST['current_image'];
        $url = $_POST['url'];

        if(isset($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];

            if($image_name != "") {
                $ext = end(explode('.', $image_name));

                $image_name = "project". rand(000,999).'.'.$ext;

                $source_path = $_FILES['image']['tmp_name'];

                $destination_path = "../images/projects/".$image_name;

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

        $sql2 = "UPDATE projects SET
                title = '$title',
                description = '$description',
                image = '$image_name',
                url = '$url'
                WHERE id = $id
        ";

        $res2 = mysqli_query($conn, $sql2);

        if($res2 == true) {
            $_SESSION['update'] = "project updated.";
            header('location:'. 'view-project.php');
        }
        else {
            $_SESSION['update'] = 'falied to update project';
            header('location:'. 'view-project.php');
        }
    }

?>