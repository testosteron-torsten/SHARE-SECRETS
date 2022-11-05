<?php 
    include "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
    echo"<title>$TITLE</title>";
    ?>
    <link rel='stylesheet' href='/styles/index-style.css'>
</head>

<body>
    <main>
        <div class="logo">
            <img src="img/logo.png" alt="Logo">
        </div>

        <div class="form">
            <form action="index.php" method="post">
                <label for="name">Your Secret Text:</label>
                <textarea name ="secret" required class="input"></textarea>
                <input type="hidden" id="set" name="set" value="1">
                <input class="button" type="submit" value="Generate">
            </form>

            <?php
                if(isset($_POST['set'])) 
                {
                    $secret = $_POST['secret'];

                    if($secret!=strip_tags($secret)) 
                    {
                        die("<script>alert('Invalid Input.');document.location.href='index.php';</script>");
                    }

                    $code = bin2hex(random_bytes(16));    
                    $link = "$URL/secret.php?code=$code";

                    try 
                    {
                        $encryption_key = base64_decode($key);
                        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                        $encrypted = openssl_encrypt($secret, 'aes-256-cbc', $encryption_key, 0, $iv);
                        $cryptosecret = base64_encode($encrypted . '::' . $iv);
                   
                        $statement = $pdo->prepare("INSERT INTO passwords (secret, code) VALUES (?,?)");
                        $result = $statement->execute(array($cryptosecret,$code));
                    } 
                    catch (Exception $e) 
                    {
                        die ("Problem storing secret in Database." . $e->getMessage() );
                    }

                    echo "<div class='link'>";
                    echo "<h2>Link:</h2>";
                    echo "<h3>$link</h3>";
                    echo "</div>";
                }
            ?> 
        </div> 
    </main>
</body>
</html>