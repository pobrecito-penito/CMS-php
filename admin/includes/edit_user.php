<?php

if(isset($_POST['edit_user'])){
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $query = "UPDATE users SET ";
    $query .= "user_firstname='{$user_firstname}', ";
    $query .= "user_lastname='{$user_lastname}', ";
    $query .= "user_role='{$user_role}', ";
    $query .= "username='{$username}', ";
    $query .= "user_email='{$user_email}', ";
    $query .= "user_password='{$user_password}' ";
    $edit_user_query = mysqli_query($connection,$query);

    queryCheck($edit_user_query);
}

if(isset($_GET['edit_user_id'])){
    $the_user_id = $_GET['edit_user_id'];
    $query = "SELECT * FROM users WHERE ";
    $query .= "user_id = $the_user_id ";
    $get_user_by_id_query = mysqli_query($connection,$query);
    queryCheck($get_user_by_id_query);

    while($row = mysqli_fetch_assoc($get_user_by_id_query)){
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_role = $row['user_role'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];

        ?>


<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_role">User Role</label>
        <select class="form-control" name="user_role" id="">
           <option value="<?php echo $user_role; ?>"><?php echo ucfirst($user_role); ?></option>
           <?php if($user_role == 'admin'){
               echo "<option value='subscriber'>Subscriber</option>";
           } else {
               echo "<option value='admin'>Admin</option>";
           } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_title">Username</label>
        <input value="<?php echo $username; ?>" type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input value="<?php echo $user_email; ?>" type="text" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input value="<?php echo $user_password; ?>" type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>

</form>


<?php  }}  ?>