<?php
namespace Newsite\Core;

class Controller
{
	public string $layoutName = "main";
	public string $action = "";
	public string $title = "News";

	protected Request $request;
	protected Response $response;


	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	protected function render(string $view, array $viewData = []): Response
	{
		return $this->response->html(
			View::renderView($this->layoutName, $this->title, $view, $viewData)
		);
	}

	protected function data(array $data): Response
	{
		return $this->response->json($data);
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title): void
	{
		$this->title = $title;
	}
}