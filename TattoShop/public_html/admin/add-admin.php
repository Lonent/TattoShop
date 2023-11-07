<?php include 'header.php' ;
if (isset($_SESSION['admin_id'])) { 
?>
<main>
    <div class="row mx-auto h-100 pb-5" action="">
        <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto row p-4 m-5" style="height: 27em;">
            <h3>Register</h3>
            <?php
            // Check if the error flag is set
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo '<div class="alert alert-danger" role="alert">Admin with the same login already exists!</div>';
            }
            ?>
            <label class="pass-missmatch col-4 text-center ms-2 my-auto rounded" style="display:none">Password
                missmatch!</label>
            <form method="POST" action="php/add-admin.php" onsubmit="return checkPasswords()">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Login</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="login"
                        placeholder="Login">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                        placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm password</label>
                    <div class="d-md-flex">
                        <input type="password" class="form-control" id="exampleInputPassword2" name="confirm_password"
                            placeholder="Password" oninput="checkPasswords()">

                    </div>
                </div>
                <button type="submit" class="sign-btn w-100 mt-2">Sign up</button>
            </form>
        </div>
    </div>

</main>

<?php } else {header('Location: index.php');};?>
<script>
    function checkPasswords() {
        var pass1 = document.getElementById("exampleInputPassword1").value;
        var pass2 = document.getElementById("exampleInputPassword2").value;
        var label = document.querySelector(".pass-missmatch");
        if (pass1 != pass2) {
            label.style.display = "block";
            return false;
        } else {
            label.style.display = "none";
            return true;
        }
    }
</script>