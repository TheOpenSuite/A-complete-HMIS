<?php
session_start();
include('assets/inc/config.php'); // Get configuration file

if (isset($_POST['doc_login'])) {
    $doc_number = $_POST['doc_number'];
    $doc_pwd = sha1(md5($_POST['doc_pwd'])); // Double encrypt to increase security

    // Updated SQL query to check for doc_dept='pharmacy'
    $stmt = $mysqli->prepare("SELECT doc_number, doc_pwd, doc_id FROM his_docs WHERE doc_number=? AND doc_pwd=? AND doc_dept='pharmacy'");

    // Bind fetched parameters
    $stmt->bind_param('ss', $doc_number, $doc_pwd);
    $stmt->execute(); // Execute bind
    $stmt->bind_result($doc_number, $doc_pwd, $doc_id); // Bind result

    $rs = $stmt->fetch(); // Fetch the result

    // If the query is successful (a match is found)
    if ($rs) {
        $_SESSION['doc_id'] = $doc_id;
        $_SESSION['doc_number'] = $doc_number; // Assign session to doc_number
        header("location: pharma_view_presc.php"); // Redirect to prescription view
    } else {
        $err = "Access Denied. Please check your credentials or department.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Hospital Management Information System -A Super Responsive Information System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="MartDevelopers" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Load Sweet Alert Javascript-->
    <script src="assets/js/swal.js"></script>

    <!-- Inject SWAL for success or error -->
    <?php if (isset($success)) { ?>
    <script>
        setTimeout(function () {
            swal("Success", "<?php echo $success; ?>", "success");
        }, 100);
    </script>
    <?php } ?>

    <?php if (isset($err)) { ?>
    <script>
        setTimeout(function () {
            swal("Failed", "<?php echo $err; ?>", "error");
        }, 100);
    </script>
    <?php } ?>
</head>
<body>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <a href="index.php">
                                <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Enter your doctor number and password to access the Pharmacist panel.</p>
                        </div>

                        <form method='post' >
                            <div class="form-group mb-3">
                                <label for="emailaddress">Doctor Number</label>
                                <input class="form-control" name="doc_number" type="text" id="emailaddress" required="" placeholder="Enter your doctor number">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input class="form-control" name="doc_pwd" type="password" required="" id="password" placeholder="Enter your password">
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" name="doc_login" type="submit"> Log In </button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p><a href="his_doc_reset_pwd.php" class="text-white-50 ml-1">Forgot your password?</a></p>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</div> <!-- end page -->

<!-- New 'Back to Index' button -->
<div class="text-center mt-4">
    <button onclick="window.location.href='../../index.php'" class="btn btn-secondary">Back to Home</button>
</div>

<?php include("assets/inc/footer1.php"); ?>

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

</body>
</html>
