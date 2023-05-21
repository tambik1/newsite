<?php

class Autoloader
{

	public static function loader(string $className)
	{
		$prefix = 'Newsite\\';
		$baseDir = __DIR__ . '\\';

		$len = strlen($prefix);
		if(strncmp($prefix, $className, $len) !== 0)
		{
			return;
		}

		$relativeClass = substr($className, $len);
		$filename = $baseDir . str_replace("\\", DIRECTORY_SEPARATOR, $relativeClass) . '.php';

		if(file_exists($filename))
		{
			require $filename;
		}
	}
}