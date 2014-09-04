<?php

require_once('../src/ColoCrossing.php');

$colocrossing_client = new ColoCrossing_Client();
$colocrossing_client->setAPIToken('eb3ac813fd85acd1a386c46cd84e39c6bf263c35');
$colocrossing_client->setOption('ssl_verify', false);

?>

<?php

$switch_id = 38; //Enter your switch id here
$switch = $colocrossing_client->devices->find($switch_id);

if(isset($switch))
{
	$type = $switch->getType();

	if($type->isNetworkDistribution())
	{
		$port_id = 4;//Enter your port id here
		$port = $switch->getPort($port_id);

		if(isset($port) )
		{
			//Get Graph for the last week
			$graph = $port->getBandwidthGraph(strtotime('-1 week'), time());

			if(isset($graph))
			{
				ob_clean();
		    	ob_start();

	        	header("Content-Type: image/png");
		    	imagepng($graph);
		    	imagedestroy($graph);

		    	ob_end_flush();
			}
		}
	}
}

?>