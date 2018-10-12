<!DOCTYPE html>
<html lang='en'>

<?php include_once ('content/head.php');?>

<body class="custombackground" onscroll='navStayOnTop()'>

    <?php include_once ('content/navbar.php');?>

    <div id='container'>
        <div class="transbox-login" id='content'>
            <main>
                <article>
                    <br>
                    <img src="../../media/HerpNetwork.png" alt="Herp Network Logo" class="logo">
                    <h2 class="center">Member Login</h2>
                    <hr class="hr">

                    <form action='https://titan.csit.rmit.edu.au/~e54061/wp/processing.php' method='post' target='_blank' autocomplete='off'>
                        <div class='center'>
                            <input type='email' name='email' value='' placeholder='Username or Email Address' class='input-block'>
                        </div>
                        <div class='center'>
                            <input type='password' name='password' placeholder='Password' class='input-block'>
                        </div>
                        <div class='center'>
                            <button type='submit' class='btn btn-1 btn-1c' value='login'>LOG IN</button>
                        </div>
                    </form>
                </article>
            </main>
        </div>
    </div>

    <?php include_once ('content/foot.php');?>
    <script src='css/script.js'></script>
</body>

</html>
