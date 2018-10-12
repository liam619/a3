<!DOCTYPE html>
<html lang='en'>

<?php include_once ('content/head.php');
?>

<body onscroll='navStayOnTop()'>

    <?php include_once ('content/navbar.php');?>

    <div id='container'>
        <?php include_once ('content/sidepanel.php');?>

        <div id='content'>
            <h1 class="h"> Item for sales </h1>
			<hr class="hr">
            <div id='product-info'>
                <?php printProductInfo() ?>
            </div>
        </div>
        <?php include_once ('content/foot.php');?>
    </div>
    <script src='css/script.js'></script>
</body>
</html>
