<?php

class ColoCrossing_Object
{

	private $client;

	private $values;

	private $objects;

	private $object_arrays;

	public function __construct(ColoCrossing_Client $client, array $values = array())
	{
		$this->client = $client;
		$this->values = $values;

		$this->objects = array();
		$this->object_arrays = array();
	}

	public function getClient()
	{
		return $this->client;
	}

	public function getValues()
	{
		return $this->values;
	}

	public function getValue($key)
	{
		return isset($this->values[$key]) ? $this->values[$key] : false;
	}

	public function getObjects()
	{
		return $this->objects;
	}

	public function getObject($key, ColoCrossing_Resource $resource = null)
	{
		if(isset($this->objects[$key]))
		{
			return $this->objects[$key];
		}

		$value = $this->getValue($key);

		if($value && is_array($value))
		{
			if(isset($resource) && isset($value['id']))
			{
				$this->objects[$key] = $resource->find($value['id'], $options = array('extra_content' => $value));
			}
			return $this->objects[$key] = ColoCrossing_Object_Factory::createObject($this->client, $resource, $value);
		}

		return null;
	}

	public function getObjectArrays()
	{
		return $this->object_arrays;
	}

	public function getObjectArray($key, ColoCrossing_Resource $resource = null)
	{
		if(isset($this->object_arrays[$key]))
		{
			return $this->object_arrays[$key];
		}

		$value = $this->getValue($key);

		if($value && is_array($value))
		{
			if(empty($resource))
			{
				return $this->object_arrays[$key] = ColoCrossing_Object_Factory::createObjectArray($this->client, $resource, $value);
			}

			$this->object_arrays[$key] = array();
			foreach ($value as $index => $content)
			{
				$this->object_arrays[$key][] = $resource->find($content['id'], $options = array('extra_content' => $content));
			}
			return $this->object_arrays[$key];
		}

		return null;
	}

	public function __toJSON()
	{
		if (defined('JSON_PRETTY_PRINT'))
		{
      		return json_encode($this->__toArray(), JSON_PRETTY_PRINT);
    	}

    	return json_encode($this->__toArray());
	}

	public function __toString()
	{
    	$class = get_class($this);
    	return $class . ' JSON: ' . $this->__toJSON();
	}

	public function __toArray()
	{
		return $this->values;
	}

	public function __call($name, $arguments)
    {
    	$name = ltrim(ColoCrossing_Utility::convertCamelCaseToSnakeCase($name), 'get_');
        if (isset($this->values[$name]) || array_key_exists($name, $this->values))
        {
            return $this->values[$name];
        }

        return null;
    }
}
