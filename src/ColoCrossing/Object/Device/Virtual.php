<?php

class ColoCrossing_Object_Device_Virtual extends ColoCrossing_Object_Device
{

	public function getSubnets(array $options = null)
	{
		return $this->getResourceChildCollection('subnets', $options);
	}

}
