<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    $stid = $_GET['uniNum'];
    if (isset($_POST['Update'])) {
        $mark = $_POST['marks'];
        if ($mark > 85) {
            $mark = "A";
        } elseif ($mark > 75) {
            $mark = "B";
        } elseif ($mark > 60) {
            $mark = "C";
        } elseif ($mark > 40) {
            $mark = "D";
        } elseif ($mark > 20) {
            $mark = "E";
        } elseif ($mark > 0) {
            $mark = "F";
        } else {
            $mark = "Missing";
        }
        try {
            $scode = ($_GET['subCode']);
            $sql = "UPDATE score SET grade=:mrks where subCode=:iid ";
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $query = $dbh->prepare($sql);
            $query->bindParam(':mrks', $mark, PDO::PARAM_STR);
            $query->bindParam(':iid', $scode, PDO::PARAM_STR);
            if($query->execute()){
                $msg = " Result info updated successfully";
            }else{
                $error=" Something went owfuly wrong. Please try again";
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }else{
        //$error=" Something went wrong. Please try again";
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin| Student result info < </title> <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
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
                                    <h2 class="title">Student Result Info</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>

                                        <li class="active">Result Info</li>
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
                                                <h5>Update the Result info</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php header("Location: index.php");?>
                                                    
                                                </div><?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>

                                            <form class="form-horizontal" method="post">

                                                <?php
                                                $regNum = ($_GET['uniNum']);
                                                $scode = ($_GET['subCode']);
                                                $sql = "SELECT * from score where uniNum=:regNum AND subCode=:scode";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':regNum', $regNum, PDO::PARAM_STR);
                                                $query->bindParam(':scode', $scode, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($results) {
                                                    foreach ($results as $result) { ?>
                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                            <div class="col-sm-10">
                                                                <input disabled type="text" name="fullname" class="form-control" id="fullname" value="<?php
                                                                                                                                                        $sql = "SELECT fName from students where uniNum=:scode";
                                                                                                                                                        $query = $dbh->prepare($sql);
                                                                                                                                                        $query->bindParam(':scode', $regNum, PDO::PARAM_STR);
                                                                                                                                                        $query->execute();
                                                                                                                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                                                                                                        foreach ($results as $result) {
                                                                                                                                                            echo htmlentities($result->fName);
                                                                                                                                                        }
                                                                                                                                                        ?>" required="required" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Subject Name</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="subjectname" value="<?php

                                                                                                                $sql = "SELECT subjectName from subjects where subjectCode=:scode";
                                                                                                                $query = $dbh->prepare($sql);
                                                                                                                $query->bindParam(':scode', $scode, PDO::PARAM_STR);
                                                                                                                $query->execute();
                                                                                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                                                                foreach ($results as $result) {
                                                                                                                    echo htmlentities($result->subjectName);
                                                                                                                }
                                                                                                                ?>" disabled class="form-control" id="default" placeholder="Subject Name" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Marks</label>
                                                            <div class="col-sm-10">
                                                                <input min="0" max="100" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="number" name="marks" class="form-control" id="result" placeholder="Student Marks" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <button type="submit" name="Update" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div>

                                                <?php }
                                                } ?>



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

            <!-- ========== PAGE JS FILES ========== -->
            <script src="js/prism/prism.js"></script>
            <script src="js/DataTables/datatables.min.js"></script>

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
            <script>
                $(function($) {
                    $('#example').DataTable();

                    $('#example2').DataTable({
                        "scrollY": "300px",
                        "scrollCollapse": true,
                        "paging": false
                    });

                    $('#example3').DataTable();
                });
            </script>
    </body>

    </html>
<?PHP } ?>