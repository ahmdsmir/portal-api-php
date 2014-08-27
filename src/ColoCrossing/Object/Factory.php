<?php

class ColoCrossing_Object_Factory
{

	public static function createObject($type, array $values = array())
	{
		switch ($type) {
			case 'device':
				return new ColoCrossing_Object_Device($values);
		}

		return new ColoCrossing_Object($values);
	}

	public static function createObjectArray($type, array $objects_values = array())
	{
		$objects = [];

		foreach ($objects_values as $index => $values) {
			$objects[] = self::createObject($type, $values);
		}

		return $objects;
	}

}
