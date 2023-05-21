<?php

namespace Newsite\Core;

class Request
{
	public function getMethod(): string
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	public function getPath(): string
	{
		$path = $_SERVER['REQUEST_URI'] ?? '/';

		$questionMarkPos = strpos($path, "?");
		if($questionMarkPos === false)
		{
			return $path;
		}

		return substr($path, 0, $questionMarkPos);
	}

	public function isGet(): string
	{
		return $this->getMethod() === 'get';
	}

	public function isPost(): string
	{
		return $this->getMethod() === 'post';
	}

	public function getData(): array
	{
		$data = [];
		if ($this->isGet())
		{
			foreach ($_GET as $key => $value)
			{
				$data[$key] = $value;
			}
		}
		if ($this->isPost())
		{
			foreach ($_POST as $key => $value)
			{
				$data[$key] = $value;
			}
		}

		return $data;
	}

	public function getJsonData(): array
	{
		try
		{
			return json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
		}
		catch (\JsonException $e)
		{
			return [];
		}
	}
}
