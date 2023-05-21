<?php

namespace Newsite\Core;

class View
{
	public static function renderView(string $layoutName, string $title, string $viewName, array $data = []): string
	{
		$viewContent = static::renderTemplate(
			"$viewName.php",
			$data
		);

		$data = array_merge($data, ['content' => $viewContent, 'title' => $title]);

		return static::renderTemplate(
			"layout\\$layoutName.php",
			$data
		);
	}

	public static function renderTemplate(string $path, array $templateData = []): string
	{
		$fullPath = Application::$ROOT_DIR . "\\news\\newsite\\views\\" . $path;
		if (!file_exists($fullPath))
		{
			return "";
		}

		extract($templateData, EXTR_OVERWRITE);

		ob_start();
		include $fullPath;
		return ob_get_clean();
	}
}