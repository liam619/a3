<?php
validate_session(); // Ensure session started

/* validate session and start session */
function validate_session() {
    if(session_status() == PHP_SESSION_NONE){
        //session has not started
        session_start();
        console_log($_SESSION);
        console_log(session_id());
    }
}

/** Remove cart content **/
function removeCartItem() {
    if(isset($_POST['cancel'])) {
        unset($_SESSION['cart']);
        unset($_SESSION['user']);
    }
}

/** work as expected **/
function printProductList() {
    $fp = fopen('products.txt','r');
    if (($headings = fgetcsv($fp, 0, "\t")) !== false) {
        while ( $cells = fgetcsv($fp, 0, "\t") ) {
            for ($x=1; $x<count($cells); $x++)
                $products[$cells[0]][$headings[$x]]=$cells[$x];
        }
    }

    fclose($fp);

    foreach ($products as $ID => $item) {

        $meta=<<< "OUTPUT"
        <div>
            <div class='image'><a href='product.php?id={$ID}'><img src='../../media/{$item['IMG']}' title='{$item["TITLE"]}' alt='{$item["TITLE"]}' class="items"></a></div>
            <div class='name'><a href='product.php?id={$ID}' class="productsname"> {$item["TITLE"]} </a></div>
        </div>
OUTPUT;

        echo $meta;
    }
}

function printProductInfo() {

    $fp = fopen('products.txt','r');
    if (($headings = fgetcsv($fp, 0, "\t")) !== false) {
        while ( $cells = fgetcsv($fp, 0, "\t") ) {
            for ($x=1; $x<count($cells); $x++)
                $products[$cells[0]][$cells[1]][$headings[$x]]=$cells[$x];
        }
    }

    php2json($products[$_GET['id']], "products");

    fclose($fp);

    if($products[$_GET['id']] != "") {
        $select = "<option selected disabled> -OPTION- </option>";
        foreach ($products[$_GET['id']] as $oid => $details) {

                $proImage = $details["IMG"];
                $proTitle = $details["TITLE"];
                $proPrice = $details["PRICE"];
                $proDescs = $details["DESCRIPTION"];
                $select .= "<option value='{$details["OID"]}'> {$details["OPTION"]} </option>";
        }

        $meta=<<< "OUTPUT"
        <div id='info-left'>
            <div id='image'><img src='../../media/{$proImage}' title='{$proTitle}' alt='{$proTitle}' class="items show-items"></div>
        </div>

        <div id='info-right'>
            <div id='item-desc'> {$proTitle} </div>
            <div id='item-price'>
                <span>\$</span>
                <span id='price'> {$proPrice} </span>
            </div>
            <div id='item-option' class='dropdown dropdown-dark'>
                <select id='opt' class='dropdown-select' onchange="getOption()">
                    {$select}
                </select>
            </div>

            <div id='item-cart'>
                <div>
                  <form action='cart.php' method='POST' onsubmit='return validateForm()'>
                  <input type='hidden' name='id' value='{$_GET['id']}'>
                  <input type='hidden' name='option' value=''>
                  <input type='hidden' name='price' value='{$proPrice}'>
                    <table>
                        <tbody>
                            <tr>
                                <td><button type='button' id='itemDec' onclick='decValue()'> - </button></td>
                                <td><input type='text' id='product-info-qty' name='qty' value='1' maxlength='2' onchange='calcTotalPrice()'></td>
                                <td><button type='button' id='itemInc' onclick='incValue()'> + </button></td>
                                <td><button class='cartBtn'> Add to Cart </button></td>
                            </tr>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>

        <div id='tab-content'>
            <span id='description'> {$proDescs} </span>
        </div>
OUTPUT;

        echo $meta;
    } else {
        header("Location: products.php");
    }
}

function cartFunction() {

    if (isset($_POST['option'], $_POST['id'], $_POST['qty'])) {

        $fp = fopen('products.txt','r');
        if (($headings = fgetcsv($fp, 0, "\t")) !== false) {
            while ( $cells = fgetcsv($fp, 0, "\t") ) {
                for ($x=1; $x<count($cells); $x++)
                    $products[$cells[0]][$cells[1]][$headings[$x]]=$cells[$x];
            }
        }

        fclose($fp);

        /** Check if item(s) exist in SESSION['cart'] **/
        if(!isset($_SESSION['cart'][$_POST['id']][$_POST['option']])){
            foreach ($products as $id => $prodDetails) {
                if($id == $_POST["id"]){
                    foreach ($products[$id] as $oid => $details) {
                        if($details["OID"] == $_POST['option']) {
                            $_SESSION['cart'][$_POST['id']][$_POST['option']]['qty'] = $_POST['qty'];
                            $_SESSION['cart'][$_POST['id']][$_POST['option']]['price'] = $details['PRICE'];
                            $_SESSION['cart'][$_POST['id']][$_POST['option']]['subtotal'] = number_format($_POST['qty'] * $details['PRICE'], 2, '.', '');
                            $_SESSION['cart'][$_POST['id']][$_POST['option']]['title'] = $details['TITLE'];
                            $_SESSION['cart'][$_POST['id']][$_POST['option']]['option'] = $details['OPTION'];
                        }
                    }
                }
            }
        } else {
            $_SESSION['cart'][$_POST['id']][$_POST['option']]['qty'] += $_POST['qty'];

            $newQty = $_SESSION['cart'][$_POST['id']][$_POST['option']]['qty'];
            $itemPrice = $_SESSION['cart'][$_POST['id']][$_POST['option']]['price'];

            $_SESSION['cart'][$_POST['id']][$_POST['option']]['subtotal'] = number_format($newQty * $itemPrice, 2, '.', '');
        }
    }

    if(isset($_SESSION['cart'])){
        $subTotal = 0;
        foreach($_SESSION['cart'] as $ID => $item) {
            foreach($_SESSION['cart'][$ID] as $x => $items) {

                $meta=<<< "OUTPUT"
                <div class="row">
                  <div class="four columns borderForCart">{$items['title']}</div>
                  <div class="two columns borderForCart">{$items['option']}</div>
                  <div class="two columns borderForCart">{$items{'qty'}}</div>
                  <div class="two columns borderForCart">\$ {$items['price']}</div>
                  <div class="two columns borderForCart">\$ {$items['subtotal']} </div>
                </div>
OUTPUT;
                echo $meta;
                $subTotal += $items['subtotal'];
            }
        }

        $subTotal =  number_format($subTotal, 2, '.', '');

        $metaSub=<<< "OUTPUT"
        <div class="row">
            <div class="four columns borderForCart"></div>
            <div class="two columns borderForCart"></div>
            <div class="two columns borderForCart"></div>
            <div class="two columns borderForCart">Sub Total</div>
            <div class="two columns borderForCart">\$ {$subTotal} </div>
        </div>
OUTPUT;
        echo $metaSub;
    }
}

function checkoutFunction() {

    $regexMobile = '/^(\(04\)|04|\+614)[ ]?\d{4}[ ]?\d{4}$/';
    $regexAddress = '/^([a-zA-Z0-9\n\s\,\\/\-\'\.])+$/';
    $regexName = '/^([a-zA-Z\s\,\-\'\.])+$/';
    $regexCC = '/^(3|4|5|6)[ ]?\d{3}[ ]?\d{4,6}[ ]?\d{4,5}[ ]?(?:[0-9]{0,7})$/';

    $errorFound   = false;
    $nameError    = '';
    $addressError = '';
    $emailError   = '';
    $mobileError  = '';
    $ccNoError    = '';
    $ccExpError   = '';

    if (isset($_POST['name'], $_POST['address'], $_POST['email'], $_POST['mobile'], $_POST['ccNo'], $_POST['ccExp'])) {
        $_SESSION['user']['purcDate'] = date("Y-m-d");

        if(!empty($_POST)) {

            $_SESSION['user']['name'] = $_POST['name'];
            if(empty($_POST['name'])) {
                $nameError = ' <span id=\'errorMark\'> Cannot be blank!</span>';
                $errorFound = true;
            } else if (!preg_match($regexName, $_POST['name'])) {
                $nameError = ' <span id=\'errorMArk\'> Invalid Name!</span>';
                $errorFound = true;
            }

            $_SESSION['user']['address'] = $_POST['address'];
            if(empty($_POST['address'])) {
                $addressError = ' <span id=\'errorMark\'> Cannot be blank!</span>';
                $errorFound = true;
            } else if (!preg_match($regexAddress, $_POST['address'])) {
                $addressError = '<span id=\'errorMark\'> Invalid Address!</span>';
                $errorFound = true;
            }

            $_SESSION['user']['mobile'] = $_POST['mobile'];
           if(empty($_POST['mobile'])) {
               $mobileError = ' <span id=\'errorMark\'> Cannot be blank!</span>';
               $errorFound = true;
           } else if(!preg_match($regexMobile, $_POST['mobile'])) {
               $mobileError = ' <span id=\'errorMark\'> Invalid number!</span>';
               $errorFound = true;
           }

            $_SESSION['user']['email'] = $_POST['email'];
            if(empty($_POST['email'])) {
                $emailError = ' <span id=\'errorMark\'> Cannot be blank!</span>';
                $errorFound = true;
            } else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $emailError = ' <span id=\'errorMark\'> Invalid email!</span>';
                $errorFound = true;
            }

            if(empty($_POST['ccNo'])) {
                $ccNoError = ' <span id=\'errorMark\'> Cannot be blank!</span>';
                $errorFound = true;
            } else if(!preg_match($regexCC, $_POST['ccNo'])) {
                $ccNoError = ' <span id=\'errorMark\'> Invalid format!</span>';
                $errorFound = true;
            }

            $validDate = time() + (28 * 24 * 60 * 60);

            if(empty($_POST['ccExp'])) {
                $ccExpError = ' <span id=\'errorMark\'> Cannot be blank!</span>';
                $errorFound = true;
            } else if ($_POST['ccExp'] < date('Y-m-d')) {
                $ccExpError = ' <span id=\'errorMark\'> Card expired!</span>';
                $errorFound = true;
            } else if($_POST['ccExp'] < date('Y-m-d', $validDate)) {
                $ccExpError = ' <span id=\'errorMark\'> Expiry within one month!</span>';
                $errorFound = true;
            }

            if(!$errorFound) {
                header("Location: receipt.php");
            }
        }
    }

    $name    = (isset($_SESSION['user']['name']))? $_SESSION['user']['name'] : '';
    $address = (isset($_SESSION['user']['address']))? $_SESSION['user']['address'] : '';
    $email   = (isset($_SESSION['user']['email']))? $_SESSION['user']['email'] : '';
    $mobile  = (isset($_SESSION['user']['mobile']))? $_SESSION['user']['mobile'] : '';

    $meta=<<< "OUTPUT"
    <div class="row">
       <div class="two columns">Name</div>
       <div class="eight columns"><input type='text' id='name' name='name' class='u-full-width' value='{$name}' autofocus></div>
       {$nameError}
    </div>

    <div class="row">
       <div class="two columns">Address</div>
       <div class="eight columns"><textarea id='address' name='address' class='u-full-width'>{$address}</textarea></div>
       {$addressError}
    </div>

    <div class="row">
      <div class="two columns">Email</div>
      <div class="eight columns"><input type='text' id='email' name='email' class='u-full-width' value='{$email}'></div>
      {$emailError}
    </div>

    <div class="row">
      <div class="two columns">Mobile No.</div>
      <div class="four columns"><input type='text' id='mobile' name='mobile' class='u-full-width' value='{$mobile}'></div>
      {$mobileError}
    </div>

    <div class="row">
        <div class="two columns">Credit Card No</div>
        <div class="three columns"><input type='text' id='ccNo' name='ccNo' class='u-full-width' onkeyup="checkCardType()"></div>
        <div class="one columns" id='cardLogo'><i class="fa fa-credit-card"></i></div>
        {$ccNoError}
    </div>

    <div class="row">
        <div class="two columns">Card Expiry</div>
        <div class="three columns"><input type='month' id='ccExp' name='ccExp' class='u-full-width'></div>
        {$ccExpError}
    </div>
OUTPUT;

    echo $meta;
}

function printReceiptFunction() {

    $storeArray = array();

    $count = 0;
    foreach($_SESSION['cart'] as $ID => $item) {
        foreach($_SESSION['cart'][$ID] as $OID => $items) {

            $storeArray[$count] = array($_SESSION['user']['purcDate'],
                                    $_SESSION['user']['name'],
                                    $_SESSION['user']['address'],
                                    $_SESSION['user']['mobile'],
                                    $_SESSION['user']['email'],
                                    $ID, $OID, $items['qty'], $items['price'], $items['subtotal']);
            $count++;
        }
    }

    $fp = fopen('orders.txt', 'a');
    flock($fp, LOCK_EX);

    foreach ($storeArray as $record) {
        fputcsv($fp, $record, "\t");
    }

    flock($fp, LOCK_UN);
    fclose($fp);
}

function printReceiptItems() {
    $count = 0;
    $total = 0;

    foreach($_SESSION['cart'] as $ID => $item) {
        $max = count($_SESSION['cart']);
        $max+= $max;
        foreach($_SESSION['cart'][$ID] as $OID => $items) {

            $count++;
            $total += $items['subtotal'];
            $class = ($count == $max)? "item last" : "item";

            $meta=<<< "OUTPUT"
            <tr class="{$class}">
                <td> {$items['title']} ({$items['option']}) </td>
                <td> {$items['qty']} </td>
                <td>\$ {$items['subtotal']} </td>
            </tr>
OUTPUT;
            echo $meta;
        }
    }

    $total = number_format($total, 2, '.', '');
    $meta=<<< "OUTPUT"
    <tr class="total">
        <td></td>
        <td></td>
        <td> Total: \$ {$total} </td>
    </tr>

OUTPUT;

    echo $meta;
}

/* Print to console */
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .');';
    echo '</script>';
}

function preShow( $arr, $returnAsString=false ) {
  $ret  = '<pre>' . print_r($arr, true) . '</pre>';
  if ($returnAsString)
    return $ret;
  else
    echo $ret;
}

function printMyCode() {
  $lines = file($_SERVER['SCRIPT_FILENAME']);
  echo "<pre class='mycode'>\n";
  foreach ($lines as $lineNo => $lineOfCode)
     printf("%3u: %1s \n", $lineNo, rtrim(htmlentities($lineOfCode)));
  echo "</pre>";
}

function php2json( $arr, $arrName ) {
  $lineEnd="";
  echo "<script>\n";
  echo "  var $arrName = ".json_encode($arr, JSON_PRETTY_PRINT);
  echo "</script>\n\n";
}

function php2js( $arr, $arrName ) {
  $lineEnd="";
  echo "<script>\n";
  echo "  var $arrName = {\n";
  foreach ($arr as $key => $value) {
    echo "$lineEnd    $key : $value";
    $lineEnd = ",\n";
  }
  echo "  \n};\n";
  echo "</script>\n\n";
}
?>
