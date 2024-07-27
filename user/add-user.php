<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    if(isset($_POST['submit'])) {
        $err=[];

        if (isset($_POST['name']) && !empty($_POST['name']) && trim($_POST['name'])) {
            $name = $_POST['name'];
        }
        else {
            $err['name'] = 'Please enter name';;
        }

        if (isset($_POST['bio']) && !empty($_POST['bio']) && trim($_POST['bio'])) {
            $bio = $_POST['bio'];
        }
        else {
            $err['bio'] = 'Please enter bio';
        }


    if(isset($_FILES['image']['name'])) {
        //upload the image
		//to upload image we need image name,source path and destination path
        $image_name = $_FILES['image']['name'];

        //Auto rename our image
		//get the extension of our image(jpg,png,jpge)
        $text = explode('.', $image_name);
        $ext = end($text);

        //Rename the image
        $image_name = "user".rand(0000,9999).'.'. $ext;

        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/".$image_name;
        //upload the image
        $upload = move_uploaded_file($source_path,$destination_path );

        // if ($upload==false) {
		// 	//set message
		// 	$_SESSION['upload'] = "<div class='error '>Falied to upload image</div>";
		// 	//redirect to add employee page
		// 	header('location: '.'add-user.php');
		// 	//stop the process
		// 	die();
		// }
    
    }    
    else {
		$err['image'] = 'Please enter image';
	}


    if(count($err) == 0) {
        $sql = "INSERT INTO user(name,image,bio) VAlUES('$name', '$image_name', '$bio')";
        $conn->query($sql);
        print_r($conn);
        // print_r($conn->query($sql));


        if($conn->affected_rows == 1 && $conn->insert_id > 0) {
            header('location:' . 'view-user.php');
            // $success = 'user insert successfully';
        }
        else {
            $error = 'user insert failed';
        }
    }
}
       
?>



<div class="container">
    <h1>Add User</h1>
    <form action="" method="POST" id="form" enctype="multipart/form-data">
        <fieldset>
            <div class="form-group">
                <label form="name">Name:</label>
                <input type="text" name="name" id="name" placeholder="enter name">
                <?php if(isset($err['name'])) {?>
                    <span><?php echo $err['name']?></span>
                <?php }?>    
            </div>

            <div class="form-group">
                <label form="image">Image:</label>
                <input type="file" name="image" id="image">
                <?php if(isset($err['image'])) {?>
                    <span><?php echo $err['image']?></span>
                <?php }?>  
            </div>

            <div class="form-group">
                <label form="bio">Bio:</label>
                <textarea name="bio" id="bio" rows="4" cols="50"></textarea>
                <?php if(isset($err['bio'])) {?>
                    <span><?php echo $err['bio']?></span>
                <?php }?>  
            </div>

            <div class="form-group">
                    <input type="submit" name="submit" id="submit" value="Add User">
                </div>

        </fieldset>
    </form>
</div>

