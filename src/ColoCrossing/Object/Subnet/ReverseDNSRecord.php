<?php

class ColoCrossing_Object_Subnet_ReverseDNSRecord extends ColoCrossing_Resource_Object
{

	public function update($value)
	{
		$subnet = $this->getSubnet();

		if(empty($subnet))
		{
			return false;
		}

		$resource = $this->getResource();

		return $resource->update($subnet->getId(), $this->getId(), $value);
	}

	public function getSubnet()
	{
		$client = $this->getClient();

		return $this->getObject('subnet', $client->subnets);
	}

}
