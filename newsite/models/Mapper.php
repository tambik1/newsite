<?php
namespace Newsite\Models;
class Mapper
{
	public static function map(array $rows, $entityName): array
	{
		$entityArray = [];
		$reflection = new \ReflectionClass($entityName);
		foreach ($rows as $row)
		{
			$entity = $reflection->newInstance($reflection->getProperties());
			foreach ($row as $item => $value)
			{
				$entity->{strtolower($item)} = $value ?? '';
			}
			$entityArray[] = $entity;
		}

		return $entityArray;
	}
}