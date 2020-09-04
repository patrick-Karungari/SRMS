<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $subject = $_POST['subject'];
        $studentid = $_POST['uninum'];

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
            $sql = "SELECT semCode, yCode from subjects where subjectCode= :studentid";
            //$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentid', $subject, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);            
            if ($results) {
                $yCode;
                $semCode;
                foreach ($results as $result) {
                    $yCode = $result->semCode;
                    $semCode = $result->yCode;
                }
                $sql = "SELECT `grade` from `score` where `subCode`= :subjectCode and `uniNum` = :uniNum";
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $query = $dbh->prepare($sql);
                $query->bindParam(':subjectCode', $subject, PDO::PARAM_STR);
                $query->bindParam(':uniNum', $studentid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                
                if (!$results) {
                    $sql = "INSERT INTO  score(uniNum,subCode,Grade,semCode,yearCode) VALUES(:studentid,:subject,:marks,:semCode,:yearCode)";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
                    $query->bindParam(':subject', $subject, PDO::PARAM_STR);
                    $query->bindParam(':marks', $mark, PDO::PARAM_STR);
                    $query->bindParam(':semCode', $yCode, PDO::PARAM_STR);
                    $query->bindParam(':yearCode', $semCode, PDO::PARAM_STR);
                    if ($query->execute()) {
                        $msg = " Result info added successfully";
                    } else {
                        $error = " Something went wrong. Please try again";
                    }
                }else{
                    $error = " Result already added";
                }               
            
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SRMS Admin | Add Result </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
        </link>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.selector').select2();
            });
        </script>
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <script>
            function getStudent(val) {
                $('.selector').selectpicker();
            }
        </script>
        <script>
            function getresult(val, clid) {

                var clid = $(".clid").val();
                var val = $(".stid").val();;
                var abh = clid + '$' + val;
                //alert(abh);
                $.ajax({
                    type: "POST",
                    url: "get_student.php",
                    data: 'studclass=' + abh,
                    success: function(data) {
                        $("#reslt").html(data);

                    }
                });
            }
        </script>


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
                                    <h2 class="title">Declare Result</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>

                                        <li class="active">Student Result</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">

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
                                                    <label for="date" class="col-sm-2 control-label ">Student Name</label>
                                                    <div class="col-sm-10">
                                                        <select name="uninum" class="form-control selector" id="studentid" required="required">
                                                            <option value="">Select Student</option>
                                                            <?php $sql = "SELECT fName,uniNum from students";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $count = 1;
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {
                                                                    $count = $count + 1;
                                                            ?>
                                                                    <option value="<?php echo htmlentities($result->uniNum); ?>">
                                                                        <?php echo htmlentities($result->uniNum); ?>&nbsp;
                                                                        <?php echo htmlentities($result->fName); ?>
                                                                    </option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Subject</label>
                                                    <div class="col-sm-10">
                                                        <select name="subject" class="form-control selector" id="subjectid" required="required">
                                                            <option value="">Select Subject</option>
                                                            <?php $sql = "SELECT * from subjects";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) { ?>
                                                                    <option value="<?php echo htmlentities($result->subjectCode); ?>">
                                                                        <?php echo htmlentities($result->subjectCode); ?>&nbsp;
                                                                        <?php echo htmlentities($result->subjectName); ?>
                                                                    </option>
                                                            <?php }
                                                            } ?>
                                                        </select>
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
                                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Declare Result</button>
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
            <script>
                document.getElementById("hm").onkeyup = function() {
                    var input = parseInt(this.value);
                    if (input < 0 || input > 100)
                        alert("Value should be between 0 - 100");
                    return;
                }
            </script>
    </body>

    </html>
<?PHP } ?>