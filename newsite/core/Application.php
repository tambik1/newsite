<?php

namespace Newsite\Core;

use Newsite\Logger\Logger;
use Newsite\Helpers\Session;

class Application
{
	public static string $ROOT_DIR;

	public static Application $app;

	public Request $request;
	public Response $response;

	public Config $config;

	public string $defaultLayout = "main";
	public ?Controller $controller;

	public string $currentAction = "";

	public function __construct(string $rootDir)
	{

		self::$ROOT_DIR = $rootDir;
		self::$app = $this;

		$this->request = new Request();
		$this->response = new Response();

		Session::start();
	}

	/**
	 *
	 * @return void
	 */
	public function run(): void
	{
		['callback' => $callback, 'params' => $params] = Router::route(
			$this->request->getMethod(),
			$this->request->getPath()
		);

		try
		{
			$this->handleCallback($callback, $params)
				 ->flush();
		}
		catch (\Exception $e)
		{
			Logger::error($e->getMessage());
			$this->response
				->error(500)
				->flush();
		}
	}

	public function setController(Controller $controller): void
	{
		$this->controller = $controller;
	}

	/**
	 * @throws \ReflectionException
	 * @throws \Exception
	 */
	private function handleCallback($callback, $params): Response
	{
		if ($callback === null)
		{
			return $this->response->error(404);
		}

		if (is_string($callback))
		{
			return $this->response->text(
				View::renderView(self::$app->defaultLayout,'Chmyr',$callback)
			);
		}

		if (is_array($callback))
		{
			/** @var Controller $controller */
			$controller = new $callback[0]($this->request, $this->response);
			$controller->action = $callback[1];

			Logger::info("Trace: {$this->request->getPath()} for action {$controller->action}");



			if(!$this->response->isAllowedControllerExecution())
			{
				return $this->response;
			}

			$this->setController($controller);
			$this->currentAction = $controller->action;

			$callback[0] = $controller;

			$reflected = new \ReflectionMethod($callback[0], $callback[1]);
			$args = $this->formCallbackArguments($reflected, $params);

			return $callback(...$args);
		}

		if ($callback instanceof \Closure)
		{
			$reflected = new \ReflectionFunction($callback);
			$args = $this->formCallbackArguments($reflected, $params);

			$result = $callback(...$args);

			return $this->response;
		}

		return $this->response;
	}

	/**
	 * @throws \Exception
	 */
	private function formCallbackArguments($reflected, $params): array
	{
		$args = [];

		foreach ($reflected->getParameters() as $parameter)
		{
			if (isset($params[$parameter->getName()]))
			{
				$args[] = $params[$parameter->getName()];
			}
			elseif (!$parameter->isDefaultValueAvailable())
			{
				throw new \RuntimeException("No value for parameter $" . $parameter->getName());
			}
			else
			{
				$args[] = $parameter->getDefaultValue();
			}
		}

		return $args;
	}

	private function handleCallbackResult($result): void
	{
		if (is_string($result))
		{
			$this->response->text($result);
		}
		elseif (is_array($result))
		{
			$this->response->json($result);
		}
	}
}