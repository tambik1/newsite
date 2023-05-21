# Получение всех постов
SELECT * FROM posts;
# Получение поста по id
SELECT * FROM posts WHERE ID = 1;
# Получение всех комментариев, к посту
SELECT * FROM comments WHERE POST_ID = 3;
#получение всей нужной инфы для поста
SELECT posts.ID, posts.title, posts.DESCRIPTION, posts.DATE_UPDATE, user.name, user.SURNAME,user.PHOTO FROM posts
	INNER JOIN user on user.ID = posts.AUTHOR_ID;
#Получение инфы по комментариям к посту
SELECT comments.ID, comments.DESCRIPTION, comments.DATE_UPDATE, user.NAME, user.SURNAME, user.PHOTO FROM comments
	INNER JOIN user ON user.ID = comments.AUTHOR_ID WHERE POST_ID = 3;
#получение тегов по id поста:
SELECT tags.NAME FROM tags, post_tags,posts WHERE tags.ID = post_tags.TAG_ID AND post_tags.POST_ID = posts.ID AND posts.id = 1;


#тест подзапроса
SELECT posts.ID,
       posts.title,
       posts.DESCRIPTION,
       posts.DATE_UPDATE,
       user.name,
       user.SURNAME,
       user.PHOTO,
       GROUP_CONCAT(tags.NAME SEPARATOR ',') as tags_name FROM posts
		INNER JOIN user on user.ID = posts.AUTHOR_ID
		LEFT JOIN post_tags ON post_tags.POST_ID= posts.ID
		LEFT JOIN tags ON tags.ID = post_tags.TAG_ID
GROUP BY posts.ID