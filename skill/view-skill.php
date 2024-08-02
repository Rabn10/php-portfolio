<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    $sql = "SELECT * FROM skills WHERE status=1";

    $res= $conn->query($sql);

    $data = [];

    if($res->num_rows > 0) {
        while($row = $res->fetch_assoc()) {
            array_push($data,$row);
        }
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>View Skill</h1>

        <br><br>

        <a href="add-skill.php" class="btn-primary">Add Skills</a>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Skill</th>
                <th>Level</th>
                <th>image</th>
                <th>Action</th>
            </tr>
            <?php if(count($data) > 0) { ?>
                <?php foreach($data as $key => $record) {?>
            <tr>
                <td><?php echo $key + 1 ?></td>
                <td><?php echo $record['skill']?></td>
                <td><?php echo $record['level']?></td>
                <td><?php
                     if($record['image'] != "") {
                        ?>
                        <img src="../images/skills/<?php echo $record['image']?>" width="100px">
                        <?php 
                    }
                    else {
                        echo "<div>image not added</div>";
                    }
                ?></td>
                <td>
                    <a href="edit-skill.php?id=<?php echo  $record['id']?>" class="btn-secondary">Edit Skill</a>
                    <a href="delete-skill.php?id=<?php echo  $record['id']?>" class="btn-danger">Delete Skill</a>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
                <tr>
                    <td>no skills addred</td>
                </tr>  
            <?php } ?>          
        </table>
    </div>
</div>