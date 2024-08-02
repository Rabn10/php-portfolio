<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    if(isset($_POST['submit'])) {
        
        $err = [];

        if (isset($_POST['skill']) && !empty($_POST['skill']) && trim($_POST['skill'])) {
            $skill = $_POST['skill'];
        }
        else {
            $err['skill'] = 'Please enter skill';
        }

        if (isset($_POST['level']) && !empty($_POST['level']) && trim($_POST['level'])) {
            $level = $_POST['level'];
        }
        else {
            $err['level'] = 'Please enter level';
        }

        if(isset($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];

            $text = explode('.', $image_name);
            $ext = end($text);

            $image_name = "skill".rand(0000,9999).'.'. $ext;

            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/skills/".$image_name;
            $upload = move_uploaded_file($source_path, $destination_path);
        }
        else {
            $err['image'] = 'please select image';
        }

        if(count($err) == 0) {
            $sql = "INSERT INTO skills(skill, level, image) Values ('$skill','$level','$image_name')";
            $conn->query($sql);

            if($conn->affected_rows == 1 && $conn->insert_id > 0) {
                header('location:'. 'view-skill.php');
            }
            else {
                $error = 'failed to insert skill';
            }
        }
    }
?>

<div class="container">
    <h1>Add Skill</h1>
    <form action="" method="POST" id="form" enctype="multipart/form-data">
        <fieldset>
            <div class="form-group">
                <label form="skill">Skill:</label>
                <input type="text" name="skill" id="skill" placeholder="enter skill">   
                <?php if(isset($err['skill'])) { ?>
                    <span><?php echo $err['skill'] ?></span>
                    <?php } ?>   
            </div>

            <div class="form-group">
                <label form="level">Level:</label>
                <input type="text" name="level" id="level" placeholder="enter level"> 
                <?php if(isset($err['level'])) { ?>
                    <span><?php echo $err['level'] ?></span>
                    <?php } ?>  
            </div>

            <div class="form-group">
                <label form="image">Image:</label>
                <input type="file" name="image" id="image"> 
            </div>

            <div class="form-group">
                    <input type="submit" name="submit" id="submit" value="Add Skill">
                </div>

        </fieldset>
    </form>
</div>