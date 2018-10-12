<!DOCTYPE html>
<html lang='en'>

<?php include_once ('content/head.php');
    removeCartItem();
?>

<body onscroll='navStayOnTop()'>

    <?php include_once ('content/navbar.php');?>

    <div id='container'>

        <?php include_once ('content/sidepanel.php');?>

        <div id='content'>
            <h1 class="h"> Item for sales </h1>
            <div id='product-filter'> </div>
            <div id='product-grid'>
                <?php printProductList();?>
            </div>
        </div>
    </div>
    <?php include_once ('content/foot.php');?>
    <script src='css/script.js'></script>
</body>
</html>
