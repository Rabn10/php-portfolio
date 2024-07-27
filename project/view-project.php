<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    $sql = "SELECT * FROM projects where status=1";

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
        <h1>View User</h1>

        <br><br>

        <a href="add-project.php" class="btn-primary">Add Project</a>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Url</th>
                <th>Action</th>
            </tr>
            <?php if(count($data) > 0) { ?>
                <?php foreach($data as $key => $record) { ?>
            <tr>
                <td><?php echo $key + 1?></td>
                <td><?php echo $record['title']?></td>
                <td><?php echo $record['description']?></td>
                <td><?php
                    if($record['image'] != "") {
                        ?>
                        <img src="../images/projects/<?php echo $record['image']?>" width="100px">
                        <?php 
                    }
                    else {
                        echo "<div>image not added</div>";
                    }
                ?></td>
                <td><?php echo $record['url']?></td>
                <td>
                    <a href="edit-project.php?id=<?php echo  $record['id']?>" class="btn-secondary">Edit Project</a>
                    <a href="delete-project.php?id=<?php echo  $record['id']?>" class="btn-danger">Delete Project</a>
                </td>
            </tr>        
            <?php } ?>
            <?php } else { ?>
             <tr>
                <td>No projects added</td>
             </tr>   
             <?php } ?>
        </table>
    </div>
</div>