<?php

$username = "";
$password = "";

try {
    $conn = new PDO('mysql:host=HOST;dbname=INSERT_DB_HERE', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $stmt = $conn->prepare('SELECT * FROM `TEST-links&addresses`');
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $email = $row["email"];
        $url = $row["claim_url"];
        $company = $row["company_name"];

        // dompdf stuff
        set_include_path(get_include_path() . PATH_SEPARATOR . "/var/www/php/dompdf/dompdf");
 
        require_once "dompdf_config.inc.php";

        $dompdf = new DOMPDF();
         
        $html = <<<ENDHTML
        <html>
            <head>
                <link rel="stylesheet" type="text/css" href="//cloud.typography.com/678768/787942/css/fonts.css" />
                <style type="text/css">
                    html, body {
                        margin: 0;
                        padding: 0;
                        font-family: 'Verlag 3r','Verlag A','Verlag B', sans-serif;
                        color: white;
                    }

                    
                    body {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                        
                    }

                    #block1 {
                        padding: 0;
                        width: 92%;
                        margin-top: 5.5%
                        margin-right: 4%;
                        margin-left: 4%;
                        height: 89%;
                        background-image: url(http://upload.wikimedia.org/wikipedia/commons/7/76/Seattle_Downtown_and_Elliott_Bay.jpg);
                        background-repeat: no-repeat;
                        background-size: cover;
                        background-position: center;
                        box-sizing: border-box;
                    }

                   
                    #text-content {
                        position: relative;
                        z-index: 1000;
                        margin: 0;
                        padding: 0;
                        margin-top: 70%;
                        background-color: rgb(237, 159, 9);
                        text-align: center;
                        color: white;
                        width: 100%;
                        height: 10%;
                    }
                   
                   #text-content h2 {
                        margin: 0;
                        padding-top: 3%;
                        padding-bottom: 3%;
                    }

                    #text-content h4 {
                        margin: 0;
                        background-color: white;
                        color: black;
                        font-size: 1.05em;
                        padding-top: 1%;
                        padding-bottom: 1%;
                    }
                    
                    #profilePic {
                        margin: 0;
                        padding: 0;
                        position: absolute;
                        z-index: 999;
                        display: block;
                        width: 60%;
                        height: 70%;
                        top: 5%;
                        background-image: url(http://i.imgur.com/09mw5Hb.png);
                        margin-right: 20%;
                        margin-left: 20%;
                        background-size: contain;
                        background-position: top center;
                    }

                </style>
            </head>
            <body>
                <div id="block1" class="block">
                    <div id="text-content">
                        <h2>ACTIVATE YOUR PROFILE NOW</h2>
                        <h4>http://bit.ly/{$company}</h4>
                    </div>
                    <div id="profilePic"></div>
                </div>
            </body>
        </html>
ENDHTML;
         
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        $file_to_save = '/var/www/php/dompdf/TestCards/' . $company . '.pdf';
        file_put_contents($file_to_save, $output);
        echo "Created postcard for "  . $company . "\n";
    }
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>