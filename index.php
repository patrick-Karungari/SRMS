<?php
session_start();
error_reporting(1);
include('includes/config.php');
if ($_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}
if (isset($_POST['login'])) {
    $uname = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
    $query = $dbh->prepare($sql);
    
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);

    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($results) {
        $_SESSION['alogin'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } else {

        $error = "Invalid credentials.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="">
    <div class="main-wrapper">

        <div class="">
            <div class="row">
                <h1 align="center">Student Result Management System</h1>
                
                <div class="col-md-4 col-md-offset-4">
                    <section style="padding-top: 10px" class="section">
                        <div class="row mt-40" style="margin-top: 20px !important">
                            <div style="padding-top: 0px !important" class="col-md-10 col-md-offset-1 pt-50">

                                <div style="padding-top: 0px" class="row mt-30 ">
                                    <div class="col-md-11">
                                        <div class="panel" style="border-radius:10px">
                                            <div class="panel-heading">
                                                <div class="panel-title text-center">
                                                    <h4>Admin Login</h4>
                                                </div>
                                            </div>
                                            <div class="panel-body p-20">

                                                <div class="section-title">
                                                    <p class="sub-title">Student Result Management System</p>
                                                </div>
                                                <?php if ($msg) { ?>
                                                    <div class="alert alert-success left-icon-alert" role="alert">
                                                        <strong>Succesfully Logged in!</strong><?php echo htmlentities($msg); ?>
                                                    </div><?php } else if ($error) { ?>
                                                    <div style="height: 40px;padding-top:8px" class="alert alert-danger left-icon-alert" role="alert">
                                                        <strong><?php echo htmlentities($error); ?></strong> 
                                                    </div>
                                                <?php } ?>
                                                <form class="form-horizontal" method="post">
                                                    <div class="form-group">
                                                        <label style="margin-right: 50%" for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="username" class="form-control" id="inputEmail3" placeholder="User Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="margin-right: 50%" for="inputPassword3" class="col-sm-2 control-label">Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-20">
                                                        <div class="col-sm-offset-2 col-sm-10">

                                                            <button type="submit" name="login" class="btn btn-success btn-labeled pull-right">Sign in<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>

                                                        </div>
                                                    </div>
                                                </form>




                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                        <p style="margin-bottom: 8px" class="text-muted text-center"><small>Copyright © SRMS Nuer Systems <?php echo date("Y"); ?></small></p>
                                        <p style="margin-top: 0px" class="text-muted text-center"><small>Patrick Karungari</small></p>
                                    </div>
                                    <!-- /.col-md-11 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->
                    </section>

                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /. -->

    </div>
    <!-- /.main-wrapper -->

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    

    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>