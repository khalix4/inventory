<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Super Cerame Stock Management System - Register</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <script>
    function toggleSecretCode() {
        const typeInput = document.getElementById('type_admin');
        const secretCodeDiv = document.getElementById('secretCodeDiv');
        if (typeInput.value === '1') {
            secretCodeDiv.style.display = 'block';
        } else {
            secretCodeDiv.style.display = 'none';
        }
    }
    </script>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row shadow">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <form class="user" role="form" action="processregister.php" method="post">
                                        <div class="form-group">
                                            <input class="form-control form-control-user" placeholder="Full Name"
                                                name="fullname" type="text" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control form-control-user" placeholder="Email Address"
                                                name="email" type="email">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control form-control-user" placeholder="Username"
                                                name="username" type="text">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control form-control-user" placeholder="Password"
                                                name="password" type="password">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control form-control-user" placeholder="Confirm Password"
                                                name="confirm_password" type="password">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control form-control-user" id="type_admin"
                                                name="type_admin" onchange="toggleSecretCode()">
                                                <option value="" selected>Select Account Type</option>
                                                <option value="1">Admin</option>
                                                <option value="2">User</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="secretCodeDiv" style="display: none;">
                                            <input class="form-control form-control-user" placeholder="Secret Code"
                                                name="secret_code" type="password">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit"
                                            name="btnregister">Register Account</button>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="login.php" style="text-decoration: none;">Already
                                                have an account? Login!</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
</body>

</html>