<?php 


function getFileArray($fileName){
	$fileArray = array();

	if(($handle = fopen($fileName, "r")) !== FALSE){
		while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
        	$fileArray[] = $row;
    	}
   		fclose($handle);
	}
	return $fileArray;
}

function addRecord( $key ){
	$newLine = array(
		$key,
		time(),
	);

	file_put_contents('data.txt', implode(',',$newLine) . PHP_EOL, FILE_APPEND);
}

function getHabitCounts(){
	$data = array();


	foreach(getFileArray('data.txt') as $row){
		$habit 		= $row[0];
		$habitTime 	= $row[1];

		$habitKeys[] = $habit;

		// Per TimeFrame over last month
		if($habitTime >= strtotime('-1 month')){

			$day 	= date('j', $habitTime );
			$hour 	= date('H', $habitTime );

			if(!isset($data[$habit])){
				$data[$habit]['last_month'] 	= 0;
				$data[$habit]['day'][$day] 		= 0;
				$data[$habit]['hourly'][$hour] 	= 0;
			}
			else{
				if(!isset($data[$habit]['day'][$day])){
					$data[$habit]['day'][$day] = 0;
				}
				
				if(!isset($data[$habit]['hourly'][$hour])){
					$data[$habit]['hourly'][$hour] = 0;
				}
			}

			$data[$habit]['last_month'] 	+= 1;
			$data[$habit]['day'][$day] 		+= 1;
			$data[$habit]['hourly'][$hour] 	+= 1;
		}
		

		// Time of Most Recent event
		if(!isset($data[$habit]['latest']) || $habitTime > $data[$habit]['latest']){
			$data[$habit]['latest'] = $habitTime;
		}

		// Time of First event
		if(!isset($data[$habit]['since']) || $habitTime < $data[$habit]['since']){
			$data[$habit]['since'] = $habitTime;
		}
	}
	$data['totals'] = array_count_values( $habitKeys );
	return $data;
}
