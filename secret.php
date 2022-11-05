<?php
    include "functions.php";
    $code = $_GET['code'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
    echo"<title>$TITLE</title>";
    ?>
    <link rel='stylesheet' href='/styles/secret-style.css'>
</head>

<body>
    <main>
        <div class="logo">
            <img src="img/logo.png" alt="Logo">
        </div>
    
        <?php
            if(isset($_GET['code'])) 
            {
        ?>
                <div class="section">
                <div>
                    <h1>Show Secret</h1>
                    <p class="disclaimer">
                    Attention! The link can only be called up once and is only valid for 30
                    days, so save this password carefully! We recommend you to
                    change this password if possible. We also recommend using a password manager and
                    advise against storing passwords insecurely on paper or in Excel files, for example.
                    </p>
    
                    <form action="secret.php" method="post">
                        <input type="hidden" id="code" name="code" value="<?php echo"$code";?>">
                        <input type="hidden" id="set" name="set" value="1">
                        <input class="button" type="submit" value="Show">
                    </form>
                </div>
                </div>
        <?php
            }  
        ?>
 
        <?php
            if(isset($_POST['set'])) 
            {
                if(isset($_POST['code'])) 
                {
                    $code = $_POST['code'];
                    
                    try 
                    {
                        $sth = $pdo->prepare("SELECT * FROM passwords WHERE code = ?");
                        $sth->execute(array($code));
                        $result = $sth->fetch();
                        $errorhandling = $result["secret"] ?? 'default';
                    } 
                    catch (Exception $e) 
                    {
                        die ("Problem fetching secret from Database, contact your Administrator" . $e->getMessage() );
                    }
        
                    if($errorhandling!='default')
                    {
                        try 
                        {
                            $secret = $result["secret"];
                            $encryption_key = base64_decode($key);
                            list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($secret), 2),2,null);
                            $secretdec = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);

                            echo "<h2>Your Secret:</h2>";         
                            echo "<h3>$secretdec</h3>";
                            $sth2 = $pdo->prepare("DELETE FROM passwords WHERE code = ?");
                            $sth2->execute(array($code));
                        } 
                        catch (Exception $e) 
                        {   
                            die ("Problem deleting secret from Database, contact your Administrator" . $e->getMessage() );
                        }
                    }
                    else
                    {
                        echo "<h2>Link expired or not valid!</h2>";   
                    }
                }  
            }
        ?>
    </main>
</body>
</html>