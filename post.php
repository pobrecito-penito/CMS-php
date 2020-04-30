<?php include "includes/header.php" ?>
<?php include "./admin/functions.php" ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

    <?php
        if(isset($_GET['p_id'])){
            $the_post_id = $_GET['p_id'];
            createComment($the_post_id);
    
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_all_posts_query = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_all_posts_query)){
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_image = $row['post_image'];
            $post_date = $row['post_date'];
            $post_content = $row['post_content'];

        ?>            

            <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

            
       <?php  }}  ?> 

             <!-- Blog Comments -->

                <!-- Comments Form -->

<div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input class="form-control" name="comment_author"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" name="comment_email"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="content">Your Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        
                        <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php
                $query = "SELECT * FROM comments WHERE comment_post_id=$the_post_id ";
                $query .= "AND comment_status='approved' ";
                $query .= "ORDER BY comment_id DESC ";

                $get_comments_by_status_query = mysqli_query($connection,$query);
                queryCheck($get_comments_by_status_query);

                while($row = mysqli_fetch_assoc($get_comments_by_status_query)){
                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];
                    $comment_date = $row['comment_date'];
                ?>

                <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>


            <?php } ?>  

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <!-- End Nested Comment -->
                    </div>
                </div>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>      

        </div>
        <!-- /.row -->

        <hr>
<!-- Footer -->
<?php include "includes/footer.php" ?>      
