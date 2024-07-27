<?php include('../partials/menu.php') ?>
<?php include('../partials/config.php') ?>

<?php
    $sql = "SELECT * FROM user WHERE status=1";

    $res = $conn->query($sql);

    $data = [];

    if($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            array_push($data,$row);
        }
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>View User</h1>

        <br><br>

        <a href="add-user.php" class="btn-primary">Add User</a>

        <?php
            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            } 
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Image</th>
                <th>Bio</th>
                <th>Action</th>
            </tr>

            <?php if(count($data) > 0) { ?>
                <?php foreach ($data as $key => $record)  { ?>
            <tr>
                <td><?php echo $key + 1?></td>
                <td><?php echo $record['name']?></td>
                <td><?php
                    if($record['image'] != "") {
                        ?>
                        <img src="../images/<?php echo $record['image']?>" width = "100px">
                        <?php
                    } 
                    else {
                        echo "<div>image not added</div>";
                    }
                ?></td>
                <td><?php echo $record['bio']?></td>
                <td>
                    <a href="edit-user.php?id=<?php echo $record['id']?>" class="btn-secondary">Edit User</a>
                    <a href="delete-user.php?id=<?php echo $record['id']?>" class="btn-danger">Delete User</a>
                </td>

            </tr>
            <?php } ?>

            <?php } else { ?>
					<tr class="no_record">
						<td colspan="3">No member found into database</td>

					</tr>

					<?php   } ?>
        </table>
    </div>
</div>