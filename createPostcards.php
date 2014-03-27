<?php
set_include_path(get_include_path() . PATH_SEPARATOR . "/Users/Megh/Documents/Development/dompdfTest/dompdf");
 
require_once "dompdf_config.inc.php";

$filename = $argv[1];


if (isset($filename)) {
	$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
	echo $ext;
	if ($ext !== "pdf") {
	    $filename = $filename . ".pdf";
	}

	$dompdf = new DOMPDF();
	 
	$html = <<<'ENDHTML'
	<html>
		<head>
		<script type="text/javascript" src="//use.typekit.net/gnr4lci.js"></script>
		<link rel="stylesheet" href="http://use.typekit.net/c/900b63/europa:i3:i4:n3:n4:n7,ff-market-web:n4.X9L:N:2,X9M:N:2,X9H:N:2,X9J:N:2,X9K:N:2,Y03:N:2/d?3bb2a6e53c9684ffdc9a98fe135b2a62b27f2d458092b639f25fab29a72491ee4b7c60fd2ab25a341e52077370f9de5ce7ec85defd5b3ac20dfe686c1feb44b30eaa4b1d1209bc3f331fbb3c78d07b8ae9b63aef2be4ce41f6269b8ba6d5f54c034b8518e0760ddcc9a90f18a9eb840e11b437ab489701dbdf8da2c9709a0cb51d3c3bec8f6a5246d1fa8a4c02a19ba768cfd1e43c984f8775c23d38e5cf1dcc2897361bdf9478e73841869f4287ab25b93086694edd26e3481a54dfaa6c08edee58b08e90a1b7ce9d146a8ac21acacd399cc42770688dff4bbf39006acae3cddd49479fee168874c5f4dd8e95a133c783a741b712461e5b110d19dfb3e282e836f260558f69144441e2f33825f4ae4048a04425386ac8b3143023ad5c31c8fbac">
		<link rel="stylesheet" type="text/css" href="//cloud.typography.com/678768/787942/css/fonts.css">
			<style type="text/css">
				html, body {
					margin: 0;
					font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
					color: white;
				}

				
				body {
					background-color: rgb(108,215,206);

				}

				.block {
					margin-top: 2in;
					width: 100%;
					text-align: center;
				}

				#block1 {
					
				}

				h1 {
					width: 100%;
					padding-top: 60px; padding-bottom: 60px;
					font-style: italic;
					background-color: rgb(55,157,165);
					margin: 0;
				}

				h4 {
					width: 100%;
					margin: 0;
					font-family: 'Arial', sans-serif;
					padding-top: 10px; padding-bottom: 10px;
					background-color: rgb(237, 159, 9);
				}

				img {
					display: block;
					width: 80%;
					height: 1.5in;
					margin: 0 auto;
					padding: 0;
					
				}
			</style>
		</head>
		<body>
			
			<div id="block1" class="block">
	 			<h1>Your Porch profile is ready!</h1>
	 			<h4>ACTIVATE YOUR PROFILE NOW</h4>
	 		</div>
		</body>
	</html>
ENDHTML;
	 
	$dompdf->load_html($html);
	$dompdf->render();
	$output = $dompdf->output();
	$file_to_save = '/Users/Megh/Documents/Development/dompdfTest/' . $filename;
	file_put_contents($file_to_save, $output);

} else {
	echo "Usage: php [php file] [generated pdf file name]\n";
}