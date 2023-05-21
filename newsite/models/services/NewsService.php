<?php

namespace Newsite\Models\Services;

use Newsite\Database\Database;
use Newsite\Models\Mapper;
use Newsite\Models\Entities\NewsEntity;


class NewsService
{

    public function getAll(): array
    {
        $db = new Database();
        return Mapper::map($db->getQuery("
SELECT news.id,
       news.idate,
       news.title,
       news.announce
FROM news
ORDER BY `news`.`idate` DESC"),
            NewsEntity::class);
    }

    public function getNewsById($id): array
    {
        $db = new Database();
        return Mapper::map($db->getQuery("
SELECT news.id,
       news.idate,
       news.title,
       news.content
FROM news
WHERE news.id =".$id.";"),
            NewsEntity::class);
    }
}