<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Contact form</title>
</head>
<body>
<?php
ob_start();
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 card card-body my-5 border-primary border-primary mx-auto">
            <h1 class="display-4 text-primary">Contact Us</h1>
            <?php
            //Getting user inputs
            $name = $_POST["name"];
            $email = $_POST["email"];
            $message = $_POST["message"];
            //Error messages
            $emailIsValid = true;
            $error = false;
            $missingName = "<p><strong>Please enter your Name!</strong></p>";
            $missingEmail = "<p><strong>Please enter your Email Address!</strong></p>";
            $missingMessage = "<p><strong>Please enter your Message!</strong></p>";
            $invalidEmail = "<p><strong>Please enter Valid email Address !</strong></p>";
                //if user has submitted the form
                if($_POST["submit"]) {
                    //check for errors
                    if ($name){
                        $name = filter_var($name, FILTER_SANITIZE_STRING);
                    }else{
                        $error = true;
                    }
                    if ($email){
                        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                            $error .= true;
                            $emailIsValid = filter_var($email,FILTER_VALIDATE_EMAIL);
                        }
                    }
                    if ($message){
                        $message = filter_var($message, FILTER_SANITIZE_STRING);
                    }else{
                        $error = true;
                    }

                    //if no error
                    if (!$error ) {
                        //send the email
                        $to = "info@bestsitecreators.com";
                        $subject = "New submit from Php Contact form";
                        $message = "<html><body>
                        <p>From: $name</p>
                        <p>Email: $email</p>
                        <h4>Message:</h4>
                        <p><strong>$message</strong></p>
                        </body></html>";
                        
                        $headers = "Content-Type: text/html";
                        //if success
                        if (mail($to, $subject, $message, $headers)){
                            //print success message
                            header("Location: thanksFor.php");
                            //Else (not success) print Warning message
                        }else{
                            $resultMessage= "<div class='alert alert-warning'>Unable to send message, please try again later!</div>";
                        }

                    }

                    //print result message
                    echo $resultMessage;
                }
            ?>
            <form class="form-group" action="contact%20form.php" method="post">
                <label for="name" class="col-form-label font-weight-bold">Name:</label>
                <input  name="name" id="name" type="text" class="form-control form-control-lg <?php if ($_POST["submit"]) if (!$name) echo 'is-invalid'; else echo 'is-valid'?>" placeholder="name" value="<?php echo $_POST["name"]?>">
                <small class="invalid-feedback"><?php if (!$name) echo $missingName?></small>

                <label for="email" class="col-form-label font-weight-bold">Email:</label>
                <input name="email" id="email" type="email" class="form-control form-control-lg <?php if ($_POST["submit"]) if (!$email || !$emailIsValid) echo 'is-invalid'?>" placeholder="Email" value="<?php echo $_POST["email"]?>">
                <small class="invalid-feedback"><?php if (!$email) echo $missingEmail?></small>
                <small class="invalid-feedback"><?php if (!$emailIsValid && $email) echo $invalidEmail?></small>

                <label for="message" class="col-form-label font-weight-bold">Message:</label>
                <small class="invalid-feedback"><?php if (!$name) echo $missingMessage?></small>
                <textarea name="message" id="message" cols="30" rows="6" class="form-control"><?php echo $_POST["message"]?></textarea>
                <input type="submit" name="submit" id="submit" class="btn btn-lg btn-success mt-3" value="Send Message">
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<?php
ob_flush();
?>
</body>
</html>
