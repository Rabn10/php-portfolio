<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    if(isset($_POST['submit'])) {

        $err=[];

        if (isset($_POST['title']) && !empty($_POST['title']) && trim($_POST['title'])) {
            $title = $_POST['title'];
        }
        else {
            $err['title'] = 'Please enter title';
        }

        if (isset($_POST['description']) && !empty($_POST['description']) && trim($_POST['description'])) {
            $description = $_POST['description'];
        }
        else {
            $err['description'] = 'Please enter description';
        }

        if (isset($_POST['url']) && !empty($_POST['url']) && trim($_POST['url'])) {
            $url = $_POST['url'];
        }
        else {
            $err['url'] = 'Please enter url';
        }

        if(isset($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];

            $text = explode('.', $image_name);
            $ext = end($text);

            $image_name = "project".rand(0000,9999).'.'. $ext;

            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/projects/".$image_name;
            $upload = move_uploaded_file($source_path, $destination_path);
        }
        else {
            $err['image'] = 'please select image';
        }

        if(count($err) == 0) {
            $sql = "INSERT INTO projects(title,description,image, url) VALUES ('$title','$description','$image_name','$url')";
            $conn->query($sql);
            // print_r($conn);

            if($conn->affected_rows == 1 && $conn->insert_id > 0) {
                header('location:'. 'view-project.php');
            }
            else {
                $error = 'failed to insert project';
            }

        }
    }
?>



<div class="container">
    <h1>Add Project</h1>
    <form action="" method="POST" id="form" enctype="multipart/form-data">
        <fieldset>
            <div class="form-group">
                <label form="title">title:</label>
                <input type="text" name="title" id="title" placeholder="enter title">
                <?php if(isset($err['title'])) { ?>
                    <span><?php echo $err['title'] ?></span>
                    <?php } ?>    
            </div>

            <div class="form-group">
                <label form="description">Description:</label>
                <textarea name="description" id="description" rows="4" cols="50"></textarea>
                <?php if(isset($err['description'])) { ?>
                    <span><?php echo $err['description'] ?></span>
                <?php } ?>  
            </div>

            <div class="form-group">
                <label form="image">Image:</label>
                <input type="file" name="image" id="image"> 
            </div>

            <div class="form-group">
                <label form="url">URL:</label>
                <input type="text" name="url" id="url" placeholder="enter url">
                <?php if(isset($err['url'])) { ?>
                    <span><?php echo $err['url'] ?></span>
                <?php } ?>    
            </div>

            <div class="form-group">
                    <input type="submit" name="submit" id="submit" value="Add Project">
                </div>

        </fieldset>
    </form>
</div>

