<?php
// Start session to access confirmation code
session_start();
?>

<?php include 'php/db.php' ?>

<?php include 'php/new-user.php' ?>

<?php include 'header.php' ?>
<main>
    <div class="row mx-auto h-100 pb-5">
        <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto row p-4 m-5" style="height: 27em;">
            <?php if (isset($show_label) && $show_label): ?>
                <h3>A confirmation code has been sent to your email</h3>
                <label class="pass-missmatch col-4 text-center ms-2 my-auto rounded">Wrong verification code</label>
                <form method="POST" class="h-75">
                    <div class="form-group">
                        <label for="exampleFormControlInput3">Confirmation code</label>
                        <input type="text" class="form-control" id="exampleFormControlInput3" name="confirmation_code"
                            placeholder="Enter the confirmation code">
                    </div>
                    <button type="submit" name="submit" class="sign-btn w-100 mt-2">Check code</button>
                </form>
            <?php elseif (isset($result) && $result): ?>
                <h3>Registration successful!</h3>
            <?php elseif (isset($user_exist) && $user_exist): ?>
                <h3>Registration failed. User with this email already exists.</h3>
            <?php else: ?>
                <h3>A confirmation code has been sent to your email</h3>
                <form method="POST" class="h-75">
                    <div class="form-group">
                        <label for="exampleFormControlInput3">Confirmation code</label>
                        <input type="text" class="form-control" id="exampleFormControlInput3" name="confirmation_code"
                            placeholder="Enter the confirmation code">
                    </div>
                    <button type="submit" name="submit" class="sign-btn w-100 mt-2">Check code</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include 'footer.php' ?>