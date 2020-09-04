<div class="left-sidebar bg-black-300 box-shadow " >
    <div class="sidebar-content" style="position: -webkit-sticky;
  position: sticky;
  top: 20px;">
        <div class="user-info closed">
            <img style="width:50px;  height:50px;   max-width: 100%; max-height: 100%" src="http://102.140.238.100/TukenyaHub/PhotoUpload/uploads/Abmi_01656_2016.jpg" alt="John Doe" class="img-circle profile-img">
            <h6 class="title"><?php
                                $username = $_SESSION['alogin'];
                                $sql = "SELECT name FROM admin WHERE UserName=:username";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':username', $username, PDO::PARAM_STR);
                                $query->execute();
                                while ($results = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo htmlentities($results->name);
                                }   ?>
            </h6>
            <small class="info"><?php

                                $username = $_SESSION['alogin'];
                                $sql = "SELECT Role FROM admin WHERE UserName=:username";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':username', $username, PDO::PARAM_STR);
                                $query->execute();
                                while ($results = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo htmlentities($results->Role);
                                }
                                ?>
            </small>
        </div>
        <!-- /.user-info -->

        <div class="sidebar-nav">
            <ul class="side-nav color-gray">
                <li class="nav-header">
                    <span class="">Main Category</span>
                </li>
                <li>
                    <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                </li>

                <li class="nav-header">
                    <span class="">Appearance</span>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-file-text"></i> <span>Student Classes</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="create-class.php"><i class="fa fa-bars"></i> <span>Create Class</span></a></li>
                        <li><a href="manage-classes.php"><i class="fa fa fa-server"></i> <span>Manage Classes</span></a></li>

                    </ul>
                </li>
                <li class="has-children">
                    <a href="#"><i class="fa fa-file-text"></i> <span>Subjects</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav">
                        <li><a href="create-subject.php"><i class="fa fa-bars"></i> <span>Create Subject</span></a></li>
                        <li><a href="manage-subjects.php"><i class="fa fa fa-server"></i> <span>Manage Subjects</span></a></li>

                </li>
            </ul>
            </li>
            <li class="has-children">
                <a href="#"><i class="fa fa-users"></i> <span>Students</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add-students.php"><i class="fa fa-bars"></i> <span>Add Students</span></a></li>
                    <li><a href="manage-students.php"><i class="fa fa fa-server"></i> <span>Manage Students</span></a></li>

                </ul>
            </li>
            <li class="has-children">
                <a href="#"><i class="fa fa-info-circle"></i> <span>Result</span> <i class="fa fa-angle-right arrow"></i></a>
                <ul class="child-nav">
                    <li><a href="add-result.php"><i class="fa fa-bars"></i> <span>Add Result</span></a></li>
                    <li><a href="manage-results.php"><i class="fa fa fa-server"></i> <span>Manage Result</span></a></li>

                </ul>
            <li><a href="change-password.php"><i class="fa fa fa-server"></i> <span> Admin Change Password</span></a></li>

            </li>
        </div>
        <!-- /.sidebar-nav -->
    </div>
    <!-- /.sidebar-content -->
</div>