<!DOCTYPE html>
<html lang='en'>

<?php include_once ('content/head.php'); ?>

<body onscroll='navStayOnTop()'>

    <?php include_once ('content/navbar.php');?>


        <div class='container'>
             <div class="row">
                <div class="four columns borderForCart">Item Name</div>
                <div class="two columns borderForCart">Option</div>
                <div class="two columns borderForCart">Quantity</div>
                <div class="two columns borderForCart">Price</div>
                <div class="two columns borderForCart">Total Price</div>
             </div>

            <?php cartFunction();?>

             <div class="row">
                 <form method="post" action="checkout.php">
                     <div class="six columns"> <input class="button-primary" type="submit" value="Submit"> </div>
                 </form>

                 <form method="post" action="products.php">
                     <input type='hidden' name='cancel' value='true'>
                     <div class="six columns"> <input class="button-primary" type="submit" value="Cancel"> </div>
                 </form>
             </div>
             <hr>
        </div>

    <?php include_once ('content/foot.php');?>
    <script src='css/script.js'></script>
</body>
</html>
