<div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>  
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Admin</th>
                                        <th>Subscriber</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php getAllUsers(); ?>
                                    <?php deleteUser(); ?>
                                    <?php setUserRole(); ?>
                                </tbody>
                            </table>
                        </div>