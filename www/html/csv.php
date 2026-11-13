<?php
require_once __DIR__ . '/config.php';
$db	=	new mysqli(cotizador_config('DB_HOST'),cotizador_config('DB_USER'),cotizador_config('DB_PASSWORD'),cotizador_config('DB_NAME'));
if ($db->connect_errno) {
  echo "Failed to connect to MySQL: " . $db->connect_error;
  exit();
}
?>
<tbody>
	<?php
if(($handle		=	fopen("countries.csv", "r")) !== FALSE){
	$n			=	1;
	while(($row	=	fgetcsv($handle)) !== FALSE){
		//$db->query('INSERT INTO `countries`(``, `countryName`, `currencyCode`, `population`, `fipsCode`, `isoNumeric`, `north`, `south`, `east`, `west`, `capital`, `continentName`, `continent`, `areaInSqKm`, `isoAlpha3`, `geonameId`) VALUES ("'.$row[1].'","'.$row[2].'","'.$row[3].'","'.$row[4].'","'.$row[5].'","'.$row[6].'","'.$row[7].'","'.$row[8].'","'.$row[9].'","'.$row[10].'","'.$row[11].'","'.$row[12].'","'.$row[13].'","'.$row[14].'","'.$row[15].'","'.$row[16].'")');
		$db->query('INSERT INTO countries ("countryName", "currencyCode", "population") VALUES ("'.$row[2].'","'.$row[3].'","'.$row[4].'")');
		if($n>1){
				
			}
			$n++;
		}
		fclose($handle);
	}
	?>
	</tbody>
</table>