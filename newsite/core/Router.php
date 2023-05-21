<?php

namespace Newsite\Core;

class Router
{
	protected static array $routes = [];

	/**
	 * Method to register a callback for a GET query on $urlTemplate route
	 *
	 * @param string $urlTemplate
	 * @param string|array|Closure $callback
	 *
	 * @return void
	 */
	public static function get(string $urlTemplate, $callback): void
	{
		self::add('get', $urlTemplate, $callback);
	}

	/**
	 * Method to register a callback for a POST query on $urlTemplate route
	 *
	 * @param string $urlTemplate
	 * @param string|array|Closure $callback
	 *
	 * @return void
	 */
	public static function post(string $urlTemplate, $callback): void
	{
		self::add('post', $urlTemplate, $callback);
	}

	/**
	 * Method for getting a handler from route map by $method and $url
	 *
	 * @param string $method
	 * @param string $url
	 *
	 * @return array|null
	 */
	public static function route(string $method, string $url): ?array
	{
		foreach (static::$routes as $route)
		{
			$matches = [];
			if($method === $route['method'] && preg_match($route['urlRegex'], $url, $matches))
			{
				return [
					'callback' => $route['callback'],
					'params' => $matches
				];
			}
		}
		return null;
	}

	private static function add(string $method, string $urlTemplate, $callback): void
	{
		static::$routes[] = [
			'method' => $method,
			'urlTemplate' => $urlTemplate,
			'urlRegex' => static::makeRegexFromUrl($urlTemplate),
			'callback' => $callback
		];
	}

	public static function makeRegexFromUrl(string $urlTemplate): string
	{
		return "#^"
			. preg_replace(
				'/\\\:([\w_]+)/', '(?<$1>[a-zA-Z0-9\-\_]+)', preg_quote($urlTemplate, null)
			)
			. "$#D";
	}
}
