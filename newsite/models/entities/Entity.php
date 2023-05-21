<?php

namespace Newsite\Models\Entities;

abstract class Entity
{
	private array $errors = [];

	public function __construct($data = [])
	{
		foreach ($data as $key => $value)
		{
			if (property_exists($this, $key))
			{
				$this->{$key} = $value;
			}
		}
	}


	public function isValid(): bool
	{
		return empty($this->errors);
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

	public function addError(string $attribute, string $message): void
	{
		$this->errors[$attribute][] = $message;
	}

	public static function translateProperty(string $key): string
	{
		return $key;
	}

}