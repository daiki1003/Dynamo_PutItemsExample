<?php

require ('aws_php_sdk/vendor/autoload.php');

use Aws\Common\Aws;
use Aws\Common\Enum\Region;

define('AWS_ACCESS_KEY_ID', 'REPLACE');
define('AWS_SECRET_ACCESS_KEY', 'REPLACE');

$table_name = "REPLACE";
$endpoint = "http://localhost:8000";

// DynamoDBと接続
$config = array(
	'key' => AWS_ACCESS_KEY_ID,
	'secret' => AWS_SECRET_ACCESS_KEY,
	'base_url' => $endpoint,
	'region' => Region::AP_NORTHEAST_1,
);
$aws = Aws::factory($config);
$client = $aws->get('DynamoDb');

// ファイルの読み込み
$fp = fopen('REPLACE', 'r');

if ($fp) {
	if (flock($fp, LOCK_SH)) {
		while (!feof($fp)) {
			$data = fgets($fp);
			$explode_data = explode(",", $data);
			$result = $client->putItem(array(
				'TableName' => $table_name,
				'Item' => $client->formatAttributes(array(
					'REPLACE(KEY)' => 'REPLACE(VALUE)'
					// repeat...
				))
			));
		}

		flock($fp, LOCK_UN);
	} else {
		print('failed to file_lock');
	}
}
fclose($fp);
