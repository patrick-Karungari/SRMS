<?php


session_start();
error_reporting(1);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        try {
            $studentname = $_POST['fullname'];
            $regNum = $_POST['regNum'];
            $studentemail = $_POST['emailid'];
            $sem = $_POST['semester'];
            $year = $_POST['year'];
            $sql = "SELECT uniNum from students where uniNum = :code or email = :email";
            $query = $dbh->prepare($sql);
            $query->bindParam(':email', $studentemail, PDO::PARAM_STR);
            $query->bindParam(':code', $regNum, PDO::PARAM_STR);
            $query->execute();
            if ($query->fetchColumn()) {
                $error = " Email or registration number in use. Try again.";
            } else {
                date_default_timezone_set("Africa/Nairobi");
                $time = date("Y-m-d H:i:sa");
                $sql = "INSERT INTO  students(fName,uniNum,email,semCode,yCode,updationTime) 
                        VALUES(:studentname,:regNum,:studentemail,:semCode,:yearCode,:timeu)";
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $query = $dbh->prepare($sql);
                $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
                $query->bindParam(':regNum', $regNum, PDO::PARAM_STR);
                $query->bindParam(':studentemail', $studentemail, PDO::PARAM_STR);
                $query->bindParam(':semCode', $sem, PDO::PARAM_STR);
                $query->bindParam(':yearCode', $year, PDO::PARAM_STR);
                $query->bindParam(':timeu', $time, PDO::PARAM_STR);
                if ($query->execute()) {
                    $msg = "Student info added successfully";
                } else {
                    $error = "Something went wrong. Please try again";
                }
            }
        } catch (Exception $e) {
            $error = $e;
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin| Student Admission< </title> <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
                <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
                <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
                <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
                <link rel="stylesheet" href="css/prism/prism.css" media="screen">
                <link rel="stylesheet" href="css/select2/select2.min.css">
                <link rel="stylesheet" href="css/main.css" media="screen">
                <script src="js/modernizr/modernizr.min.js"></script>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                    <?php include('includes/leftbar.php'); ?>
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Student Admission</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>

                                        <li class="active">Student Admission</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Fill the Student info</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post">

                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="fullname" class="form-control" id="fullname" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Registration Number</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="regNum" class="form-control" id="regNum" maxlength="17" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" name="emailid" class="form-control" id="email" required="required" autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Semester</label>
                                                    <div class="col-sm-10">
                                                        <select name="semester" class="form-control" id="default" required="required">
                                                            <option value="">Select Semester</option>
                                                            <?php $sql = "SELECT semCode from codes";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                                    <option value="<?php echo htmlentities($result->semCode); ?>"><?php echo htmlentities($result->semCode); ?>&nbsp; </option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Year</label>
                                                    <div class="col-sm-10">
                                                        <select name="year" class="form-control" id="default" required="required">
                                                            <option value="">Select Year</option>
                                                            <?php $sql = "SELECT yearCode from codes where id < 6";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                                    <option value="<?php echo htmlentities($result->yearCode); ?>"><?php echo htmlentities($result->yearCode); ?>&nbsp; </option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                        </div>
                    </div>
                    <!-- /.content-container -->
                </div>
                <!-- /.content-wrapper -->
            </div>
            <!-- /.main-wrapper -->
            <script src="js/jquery/jquery-2.2.4.min.js"></script>
            <script src="js/bootstrap/bootstrap.min.js"></script>
            <script src="js/pace/pace.min.js"></script>
            <script src="js/lobipanel/lobipanel.min.js"></script>
            <script src="js/iscroll/iscroll.js"></script>
            <script src="js/prism/prism.js"></script>
            <script src="js/select2/select2.min.js"></script>
            <script src="js/main.js"></script>
            <script>
                $(function($) {
                    $(".js-states").select2();
                    $(".js-states-limit").select2({
                        maximumSelectionLength: 2
                    });
                    $(".js-states-hide").select2({
                        minimumResultsForSearch: Infinity
                    });
                });
            </script>
    </body>

    </html>
<?PHP } ?>