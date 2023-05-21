<?php

namespace Newsite\Helpers;

class Session
{
	private const FLASH_KEY = "flash_message";

	public static function start(): bool
	{
		return self::_init();
	}

	public static function destroy(): void
	{
		//deleting session data
		$_SESSION = array();
		//destroying session
		session_destroy();
	}

	public static function get(string $key)
	{
		return $_SESSION[$key] ?? false;
	}

	public static function setFlash($key, $message): void
	{
		$_SESSION[self::FLASH_KEY][$key] = $message;
	}

	public static function hasMessages(): bool
	{
		return isset($_SESSION[self::FLASH_KEY]);
	}

	public static function displayMessages(): string
	{
		$output = "";

		foreach ($_SESSION[self::FLASH_KEY] as $message)
		{
			$output .= "<a>" . $message . "</a>\n";
		}

		self::clear(self::FLASH_KEY);

		return $output;
	}

	public static function set(string $key, $data): void
	{
		$_SESSION[$key] = $data;
	}

	public static function clear(string $key): void
	{
		unset($_SESSION[$key]);
	}

	public static function has(string $key): bool
	{
		if (!isset($_SESSION[$key]))
		{
			return false;
		}
		if ($_SESSION['key'] === '')
		{
			return false;
		}
		return true;
	}

	private static function _init(): bool
	{
		if (session_status() === PHP_SESSION_DISABLED)
		{
			return false;
		}
		if (session_status() === PHP_SESSION_ACTIVE)
		{
			return false;
		}
		return session_start();
	}
}