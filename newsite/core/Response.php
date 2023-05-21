<?php

namespace Newsite\Core;

use JsonException;

class Response
{
	protected int $code = 200;
	protected string $reason = "";
	protected array $headers = [];
	protected string $body = "";

	protected bool $allowControllerExecution = true;

	public function error(int $code, string $reason = ""): Response
	{
		$this->code = $code;
		$this->reason = $reason;

		return $this;
	}

	public function text(string $text): Response
	{
		$this->body = $text;

		return $this;
	}

	public function html(string $html): Response
	{
		$this->body = $html;

		return $this;
	}

	public function json(array $data): Response
	{
		try
		{
			$this->body = json_encode($data, JSON_THROW_ON_ERROR);
		}
		catch (JsonException $e)
		{
			echo "Cannot parse data to json!";
		}

		$this->headers['Content-Type'] = 'application/json';

		return $this;
	}

	public function flush(): void
	{
		$this->writeHeaders();
		$this->writeBody();
	}

	public function restrictControllerExecution(): Response
	{
		$this->allowControllerExecution = false;
		return $this;
	}

	public function isAllowedControllerExecution(): bool
	{
		return $this->allowControllerExecution;
	}

	protected function writeHeaders(): void
	{
		if($this->code !== 200)
		{
			header("HTTP/1.1 $this->code $this->reason)");
		}
		foreach ($this->headers as $header => $value)
		{
			header("$header: $value");
		}
	}

	protected function writeBody(): void
	{
		echo $this->body;
	}

	public function redirect(string $url): Response
	{
		$this->headers["Location"] = $url;
		return $this;
	}

	public function reload(): Response
	{
		$this->headers["Refresh"] = 0;
		return $this;
	}

	public function redirectBack(): Response
	{
		return $this->redirect($_SERVER['HTTP_REFERER']);
	}

	public static function setStatusCode(int $statusCode): void
	{
		http_response_code($statusCode);
	}
}
