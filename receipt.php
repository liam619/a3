<!DOCTYPE html>

<html lang='en'>
<?php include_once ('content/head.php'); ?>

<?php printReceiptFunction(); ?>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="3">
                <table>
                    <tr>
                        <td class="title">
                            <img src="../../media/B.jpg">
                        </td>
                        <td></td>
                        <td>
                            Invoice #: <?php echo rand(1000, 100000); ?><br>
                            Created: <?php echo $_SESSION['user']['purcDate'] ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="3">
                <table>
                    <tr>
                        <td> <?php echo $_SESSION['user']['address'] ?></td>
                        <td></td>
                        <td> <?php echo $_SESSION['user']['name'] ?> <br> <?php echo $_SESSION['user']['email'] ?> </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td> Payment Method </td>
            <td></td>
            <td></td>
        </tr>

        <tr class="details">
            <td> Credit Card </td>
            <td></td>
            <td></td>
        </tr>

        <tr class="heading">
            <td> Item </td>
            <td> Quantity </td>
            <td> Price </td>
        </tr>

        <?php printReceiptItems() ?>
    </table>
</div>
</body>
</html>
