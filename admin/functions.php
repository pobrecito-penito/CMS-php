<?php

function queryCheck($query) {
    
    global $connection;

    if(!$query){
        die("QUERY FAILED" . " " . mysqli_error($connection));
    }

}


function insertCategories() {

    global $connection;

    if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)){
            echo "This field cannot be empty";
        } else {
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUE ('{$cat_title}')";

            $create_category_query = mysqli_query($connection,$query);
            if(!$create_category_query){
                die("QUERY FAILED" . " " . mysqli_error($connection));
            }
        }

    }

}


function findAllCategories () {

    global $connection;

    $query = "SELECT * FROM categories";
    $select_all_categories_query = mysqli_query($connection,$query);
                                    
    while($row = mysqli_fetch_assoc($select_all_categories_query)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }

}


function deleteCategories() {

    global $connection;

    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id={$the_cat_id} ";
        $delete_category_query = mysqli_query($connection,$query);
        header("Location:categories.php");
    }
    
}


function findAllPosts () {

    global $connection;

    $query = "SELECT * FROM posts";
    $select_all_posts_query = mysqli_query($connection,$query);
                                    
    while($row = mysqli_fetch_assoc($select_all_posts_query)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];

        echo "<tr>";
        echo "<td>{$post_id}</td>";
        echo "<td>{$post_author}</td>";
        echo "<td>{$post_title}</td>";

        $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
        $find_category_query = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($find_category_query)){
            $cat_title = $row['cat_title'];
            echo "<td>{$cat_title}</td>";
        }

        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='../images/$post_image' alt='No image'></td>";
        echo "<td>{$post_tags}</td>";
        echo "<td>{$post_comment_count}</td>";
        echo "<td>{$post_date}</td>";
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
        echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
        echo "</tr>";
    }

    deletePost();
}


function deletePost() {

    global $connection;

    if(isset($_GET['delete'])){
        $post_id = $_GET['delete'];

        $query = "DELETE FROM posts ";
        $query .= "WHERE post_id={$post_id}";

        $delete_post_query = mysqli_query($connection,$query);
        queryCheck($delete_post_query);

        header("Location:posts.php");
    }

}


function getAllComments() {
    
    global $connection;

    $query = "SELECT * FROM comments ";
    $all_comments_query = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($all_comments_query)){
        $comment_id = $row['comment_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_post_id = $row['comment_post_id'];
        $comment_date = $row['comment_date'];

        echo "<tr>";
        echo "<td>{$comment_id}</td>";
        echo "<td>{$comment_author}</td>";
        echo "<td>{$comment_content}</td>";
        echo "<td>{$comment_email}</td>";
        echo "<td>{$comment_status}</td>";

        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
        $find_post_query = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($find_post_query)){
            $post_title = $row['post_title'];
            echo "<td><a href='../post.php?p_id=$comment_post_id'>{$post_title}</td>";
        }

        echo "<td>{$comment_date}</td>";
        
        echo "<td><a href='comments.php?comment_status=approved&comment_id={$comment_id}'>Approve</a></td>";
        echo "<td><a href='comments.php?comment_status=disapproved&comment_id={$comment_id}'>Disapprove</a></td>";
        echo "<td><a href='comments.php?delete_comment={$comment_id}'>Delete</a></td>";
        echo "</tr>";
    }
}


function createComment($the_post_id) {

    global $connection;

    if(isset($_POST['create_comment'])){
        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];

        $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) ";
        $query .= "VALUES ($the_post_id,'$comment_author','$comment_email','$comment_content','unapproved',now())";
        $create_comment_query = mysqli_query($connection,$query);
        queryCheck($create_comment_query);

        $query = "UPDATE posts SET ";
        $query .= "post_comment_count = post_comment_count + 1 ";
        $query .= "WHERE post_id = $the_post_id ";
        $update_comment_count_query = mysqli_query($connection,$query);
        queryCheck($update_comment_count_query);
    }
}


function deleteComment() {

    global $connection;

    if(isset($_GET['delete_comment'])){
        $the_comment_id = $_GET['delete_comment'];

        $query = "DELETE FROM comments WHERE comment_id = $the_comment_id ";
        $delete_comment_query = mysqli_query($connection,$query);

        queryCheck($delete_comment_query);
        header("Location:comments.php");
    }
}

function setCommentStatus() {

    global $connection;

    if(isset($_GET['comment_status'])){
        $comment_status = $_GET['comment_status'];
        $the_comment_id = $_GET['comment_id'];

        $query = "UPDATE comments SET comment_status='$comment_status' ";
        $query .= "WHERE comment_id = $the_comment_id";
        $set_comment_status_query = mysqli_query($connection,$query);

        queryCheck($set_comment_status_query);
        header("Location:comments.php");
    }
}



function getAllUsers() {
    
    global $connection;

    $query = "SELECT * FROM users ";
    $all_users_query = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($all_users_query)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];

        echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$username}</td>";
        echo "<td>{$user_firstname}</td>";
        echo "<td>{$user_lastname}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td>{$user_role}</td>";
        echo "<td><a href='users.php?user_role=admin&user_id=$user_id'>Admin</td>";
        echo "<td><a href='users.php?user_role=subscriber&user_id=$user_id'>Subscriber</td>";
        echo "<td><a href='users.php?source=edit_user&edit_user_id=$user_id'>Edit</td>";
        echo "<td><a href='users.php?delete_user=$user_id'>Delete</td>";
    }
}


function createUser() {
    
    global $connection;

    if(isset($_POST['create_user'])){
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        $query = "INSERT INTO users(user_firstname,user_lastname,user_role,username,user_email,user_password) ";
        $query .= "VALUES ('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','{$user_password}')";
        $add_user_query = mysqli_query($connection,$query);

        queryCheck($add_user_query);
    }
}

function deleteUser() {

    global $connection;

    if(isset($_GET['delete_user'])){
        $user_id = $_GET['delete_user'];

        $query = "DELETE FROM users ";
        $query .= "WHERE user_id = $user_id ";
        $delete_user_query = mysqli_query($connection,$query);

        queryCheck($delete_user_query);

        header("Location:users.php");
    }
}

function setUserRole() {

    global $connection;

    if(isset($_GET['user_role'])){
        $user_role = $_GET['user_role'];
        $user_id = $_GET['user_id'];

        $query = "UPDATE users SET user_role='$user_role' ";
        $query .= "WHERE user_id = $user_id ";
        $set_user_role_query = mysqli_query($connection,$query);

        queryCheck($set_user_role_query);
        header("Location:users.php");
    }
}