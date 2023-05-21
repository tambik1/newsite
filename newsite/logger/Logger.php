<?php

namespace Newsite\Logger;

use Exception;
use RuntimeException;

define('LOG_DIR', '../log/');

class Logger
{

	protected static $logFile;
	protected static $file;
	protected static $options = [
		'dateFormat' => 'd-M-Y',
		'logFormat' => 'H:i:s',
	];

	protected function __construct()
	{
	}

	public static function setOptions($options = [])
	{
		static::$options = array_merge(static::$options, $options);
	}

	public static function debug($message, array $context = []): void
	{

		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
		static::writeLog([
							 'message' => $message,
							 'bt' => $bt,
							 'severity' => 'DEBUG',
							 'context' => $context,
						 ]);
	}

	public static function writeLog($args = []): void
	{
		static::createLogFile();

		if (!is_resource(static::$file))
		{
			static::openLog();
		}

		$time = date(static::$options['logFormat']);

		$context = json_encode($args['context'], JSON_THROW_ON_ERROR);

		$caller = array_shift($args['bt']);
		$btLine = $caller['line'];
		$btPath = $caller['file'];

		$path = static::absToRealPath($btPath);

		$timeLog = is_null($time) ? "[N/A] " : "[{$time}] ";
		$pathLog = is_null($path) ? "[N/A] " : "[{$path}] ";
		$lineLog = is_null($btLine) ? "[N/A] " : "[{$btLine}] ";
		$severityLog = is_null($args['severity']) ? "[N/A]" : "[{$args['severity']}]";
		$messageLog = is_null($args['message']) ? "N/A" : "{$args['message']}";
		$contextLog = empty($args['context']) ? "" : "{$context}";

		fwrite(static::$file, "{$timeLog}{$pathLog}{$lineLog}: {$severityLog} - {$messageLog} {$contextLog}" . PHP_EOL);

		static::closeFile();
	}

	public static function createLogFile(): void
	{
		if (!file_exists($dir = LOG_DIR) && !mkdir($dir) && !is_dir($dir))
		{
			throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
		}

		$time = date(static::$options['dateFormat']);
		static::$logFile = LOG_DIR . "{$time}.log";

		if (!file_exists(static::$logFile))
		{
			$var = static::$logFile;
			fopen(static::$logFile, 'wb') or exit("Can't create $var!");
		}

		if (!is_writable(static::$logFile))
		{
			throw new Exception("ERROR: Unable to write to file!", 1);
		}
	}

	private static function openLog(): void
	{
		$openFile = static::$logFile;
		static::$file = fopen($openFile, 'a') or exit("Can't open $openFile!");
	}

	public static function absToRealPath($pathToConvert): string
	{
		$pathAbs = str_replace(['/', '\\'], '/', $pathToConvert);
		$documentRoot = str_replace(['/', '\\'], '/', $_SERVER['DOCUMENT_ROOT']);

		return self::getServerName() . " " . str_replace($documentRoot, '', $pathAbs);
	}

	public static function getServerName()
	{
		return $_SERVER['SERVER_NAME'] ?? "cli";
	}

	public static function closeFile(): void
	{
		if (static::$file)
		{
			fclose(static::$file);
		}
	}

	public static function error($message, array $context = []): void
	{
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

		static::writeLog([
							 'message' => $message,
							 'bt' => $bt,
							 'severity' => 'ERROR',
							 'context' => $context,
						 ]);
	}

	public static function catchError($errno, $errString, $errFile, $errLine): bool
	{
		if (!(error_reporting() & $errno))
		{
			// Этот код ошибки не включён в error_reporting,
			// обрабатываются стандартным обработчиком ошибок PHP
			return false;
		}

		// экранирование $errString:
		$errString = htmlspecialchars($errString);

		switch ($errno)
		{
			case E_USER_ERROR:
				self::fatal($errString, ['file' => $errFile, 'line' => $errLine]);
				exit(1);

			case E_USER_WARNING:
				self::warning($errString, ['file' => $errFile, 'line' => $errLine]);
				break;

			case E_USER_NOTICE:
				self::notice($errString, ['file' => $errFile, 'line' => $errLine]);
				break;

			default:
				self::info($errString, ['file' => $errFile, 'line' => $errLine]);
				break;
		}

		return true;
	}

	public static function fatal($message, array $context = []): void
	{
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

		static::writeLog([
							 'message' => $message,
							 'bt' => $bt,
							 'severity' => 'FATAL',
							 'context' => $context,
						 ]);
	}

	public static function warning($message, array $context = []): void
	{
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

		static::writeLog([
							 'message' => $message,
							 'bt' => $bt,
							 'severity' => 'WARNING',
							 'context' => $context,
						 ]);
	}

	public static function notice($message, array $context = []): void
	{
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
		static::writeLog([
							 'message' => $message,
							 'bt' => $bt,
							 'severity' => 'NOTICE',
							 'context' => $context,
						 ]);
	}

	public static function info($message, array $context = []): void
	{
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
		static::writeLog([
							 'message' => $message,
							 'bt' => $bt,
							 'severity' => 'INFO',
							 'context' => $context,
						 ]);
	}

}