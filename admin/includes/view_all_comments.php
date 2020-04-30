<div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Author</th>
                                        <th>Comment</th>
                                        <th>Email</th>  
                                        <th>Status</th>
                                        <th>In Response to</th>
                                        <th>Date</th>
                                        <th>Approve</th>
                                        <th>Disapprove</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php getAllComments(); ?>
                                    <?php deleteComment(); ?>
                                    <?php setCommentStatus(); ?>
                                </tbody>
                            </table>
                        </div>