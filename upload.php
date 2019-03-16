<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/xlsx/src/SimpleXLSX.php';
require_once __DIR__.'/db.php';

echo '<h1>XLSX to HTML</h1>';

if (isset($_FILES['file'])) {
	
	if ( $xlsx = SimpleXLSX::parse( $_FILES['file']['tmp_name'] ) ) {

		echo '<h2>Parsing Result</h2>';
		echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

		list( $cols, ) = $xlsx->dimension();

		foreach ( $xlsx->rows() as $k => $r ) {
			echo $k . '----';
			if($k != 0){
				$sql = 'INSERT INTO `datatables_demo` (`id`, `first_name`, `last_name`, `source_language`, `target_language`, `type`, `service`, `expertise`, `rate`, `unit`, `native_language`, `status`, `location`, `phone`, `email`, `skype`, `gender`, `dob`, `availability`, `rating`, `link_cv`, `lastest_support`, `number_supported`) VALUES (NULL, ';
				// for ( $i = 0; $i < $cols; $i ++ ) {
				$check = 'aaaa----';
				for ( $i = 0; $i < 21; $i ++ ) {
					if($r[ $i ] == '1970-01-01 00:00:00') $r[ $i ] = '';
					if(strlen($r[ $i ]) > 0) $check = 'bbbb----';

					$r[ $i ] = str_replace('"','',$r[ $i ]);
					if($i == 0){
						$full_name = explode(" ",$r[ $i ]);
						$last_name = $full_name[count($full_name) - 1];
						$first_name = substr($r[ $i ], 0, strlen($r[ $i ]) - strlen($last_name) - 1);
						$sql .= isset( $first_name ) ? '"' . $first_name . '",' : '' . '",';
						$sql .= isset( $last_name ) ? '"' . $last_name . '",' : '' . '",';
					}else{
						$sql .= isset( $r[ $i ] ) ? '"' . $r[ $i ] . '",' : '' . '",';
					}
				}
				if($check === 'aaaa----'){
					break;
				}

				$sql = rtrim($sql, ",");

				$sql .= ")";
				// var_dump($sql);die;

				if ($conn->query($sql) === TRUE) {
				    echo "New record created successfully <br />";
				} else {
				    echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
		}
		$conn->close();
	} else {
		echo SimpleXLSX::parseError();
	}
}
echo '<h2>Upload form</h2>
<form method="post" enctype="multipart/form-data">
*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="Parse" />
</form>';
