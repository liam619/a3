<!DOCTYPE html>
<html lang='en'>

<?php include_once ('content/head.php');?>

<body onscroll='navStayOnTop()'>

    <?php include_once ('content/navbar.php');?>

    <form method="post" action="checkout.php">
        <div class='container'>
            <h3> Enter your credentials </h3>
            <hr>

            <?php checkoutFunction(); ?>

             <input class="button-primary" type="submit" value="Submit">
             <hr>
        </div>
    </form>

    <?php include_once ('content/foot.php');?>
    <script src='css/script.js'></script>
</body>
</html>
