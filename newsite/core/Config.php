<?php

namespace Newsite\Core;


class Config
{
	public const CONFIG_EXT = ".php";

	protected array $configMap = array();

	public function loadConfigs(string $configFolderPath): void
	{
		foreach (glob("$configFolderPath/*" . self::CONFIG_EXT) as $filename)
		{
			$configName = basename($filename, self::CONFIG_EXT);
			if(!isset($this->configMap[$configName]))
			{
				$this->configMap[$configName] = include $filename;
			}
		}
	}

	public function get(string $key): ?array
	{
		return $this->configMap[$key] ?? null;
	}
}