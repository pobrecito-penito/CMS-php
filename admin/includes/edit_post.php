<?php

if(isset($_GET['p_id'])){
 $the_post_id = $_GET['p_id'];
    
    $query = "SELECT * FROM posts WHERE post_id={$the_post_id}";
    $select_post_by_id = mysqli_query($connection,$query);
                                
while($row = mysqli_fetch_assoc($select_post_by_id)){
    $post_id = $row['post_id'];
    $post_content = $row['post_content'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value='<?php echo $post_title; ?>' type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select class="form-control" name="post_category" id="">
            <?php  
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection,$query);
                queryCheck($select_all_categories_query);                                
                while($row = mysqli_fetch_assoc($select_all_categories_query)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value=$cat_id>{$cat_title}</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>



    <div class="form-group">
        <label for="post_image">Post Image</label>
        </br>
        <img width="100" src="../images/<?php echo $post_image; ?>" >
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>

</form>
<?php }}

if(isset($_POST['update_post'])){
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category'];
    $post_author = $_POST['post_author'];
    $post_status = $_POST['post_status'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $date = date('d-m-y');
    $post_comment_count = 2;

    move_uploaded_file($image_tmp,"../images/$image");

    if(empty($image)){
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_image_query = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_image_query)){
            $image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title='{$post_title}', ";
    $query .= "post_category_id={$post_category_id}, ";
    $query .= "post_author='{$post_author}', ";
    $query .= "post_status='{$post_status}', ";
    $query .= "post_image='{$image}', ";
    $query .= "post_tags='{$post_tags}', ";
    $query .= "post_content='{$post_content}', ";
    $query .= "post_date=now() ";
    $query .= "WHERE post_id={$the_post_id} ";

    $update_post_query = mysqli_query($connection,$query);
    queryCheck($update_post_query);
    header("Location:posts.php?source=edit_post&p_id=$the_post_id");
}



?>