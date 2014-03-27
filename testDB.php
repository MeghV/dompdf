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
            <script type="text/javascript" src="//use.typekit.net/gnr4lci.js"></script>
            <link rel="stylesheet" href="http://use.typekit.net/c/900b63/europa:i3:i4:n3:n4:n7,ff-market-web:n4.X9L:N:2,X9M:N:2,X9H:N:2,X9J:N:2,X9K:N:2,Y03:N:2/d?3bb2a6e53c9684ffdc9a98fe135b2a62b27f2d458092b639f25fab29a72491ee4b7c60fd2ab25a341e52077370f9de5ce7ec85defd5b3ac20dfe686c1feb44b30eaa4b1d1209bc3f331fbb3c78d07b8ae9b63aef2be4ce41f6269b8ba6d5f54c034b8518e0760ddcc9a90f18a9eb840e11b437ab489701dbdf8da2c9709a0cb51d3c3bec8f6a5246d1fa8a4c02a19ba768cfd1e43c984f8775c23d38e5cf1dcc2897361bdf9478e73841869f4287ab25b93086694edd26e3481a54dfaa6c08edee58b08e90a1b7ce9d146a8ac21acacd399cc42770688dff4bbf39006acae3cddd49479fee168874c5f4dd8e95a133c783a741b712461e5b110d19dfb3e282e836f260558f69144441e2f33825f4ae4048a04425386ac8b3143023ad5c31c8fbac">
            <link rel="stylesheet" type="text/css" href="//cloud.typography.com/678768/787942/css/fonts.css">
                <style type="text/css">
                    html, body {
                        margin: 0;
                        padding: 0;
                        font-family: sans-serif;
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