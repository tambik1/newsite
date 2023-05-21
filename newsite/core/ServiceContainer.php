<?php

namespace Newsite\Core;

class ServiceContainer
{
	private static array $container = [];

	public static function get($key)
	{
		return self::$container[$key];
	}

	public static function add($key, $service)
	{
		self::$container[$key] = $service;
	}
}