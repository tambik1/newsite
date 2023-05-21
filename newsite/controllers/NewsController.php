<?php
namespace Newsite\Controllers;
use Newsite\Core\Controller;
use Newsite\Core\Response;
use Newsite\Core\ServiceContainer;
use Newsite\Models\Services\NewsService;

class NewsController extends Controller
{
	public function news(): Response
	{
		/** @var NewsService $newsService */
        $newsService = ServiceContainer::get("news");
		$data = $newsService->getAll();
		if (isset($data))
		{
			$this->setTitle("Новости");
			return $this->render('blocks/_news', [
				'news' => $data,

			]);
		}
		return $this->render('layout/404');
	}
	public function newsById(): Response
	{
        $newsService = ServiceContainer::get("news");
        $id = $_GET['id'];
        $newData = $newsService->getNewsById($id);

		if (isset($newData))
		{
			$this->setTitle("Детальная");
			return $this->render('blocks/_new_detail', [
				'new' => $newData,

			]);
		}
		return $this->render('layout/404');
	}

}