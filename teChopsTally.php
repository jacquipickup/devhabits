<?php 
ini_set('display_errors', 1);

require_once('logic.php');

if( isset($_POST['key'])){
	addRecord($_POST['key']);
}
$habits 		= getFileArray('setup.txt');
$habitCounts 	= getHabitCounts();

echo"<pre>";print_r($habitCounts );echo"</pre>";
?><!DOCTYPE html>
<html>
<head>

<style>
h2{

}

span.count{

}

</style>
</head>
<body>

<?php foreach($habits as $habit): ?>

	<?php $key = $habit[2]; ?>	
	<h2><?php echo $habit[0]. ' ' . $habit[1]; ?></h2>
	<form action="#" method="post">
		<input type="hidden" name="key" value="<?php echo $habit[2]; ?>"/>
	 	<input type="submit" value="Happened again!" />
	</form>


	<span class="count"><?php echo (isset($habitCounts['totals'][$key]) ?  $habitCounts['totals'][$key] : 0 ); ?></span> 
	Since <?php echo (isset($habitCounts['since'][$key]) ? date('d M Y',$habitCounts['since'][$key]) : '?');?>
	

<?php endforeach; ?>

</body>
</html>