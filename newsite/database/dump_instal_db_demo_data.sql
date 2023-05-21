-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 25 2022 г., 15:04
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `chmyr`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `ID` int NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `DATA_CREATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DATA_UPDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `POST_ID` int NOT NULL,
  `AUTHOR_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`ID`, `DESCRIPTION`, `DATA_CREATE`, `DATA_UPDATE`, `POST_ID`, `AUTHOR_ID`) VALUES
(1, 'Космос огромен, холоден и невероятно пуст, но ровно до тех пор, пока кто-то не поставил небольшую, но очень дорогую тарелочку, на орбиту.', '2022-06-25 12:02:56', '2022-06-25 12:02:56', 2, 1),
(2, 'Пля, вот только утром сижу и вспоминаю: а ещё перед НГ всей пикабой так за него переживали! А теперь и новостей про него не слышно...', '2022-06-25 12:02:56', '2022-06-25 12:02:56', 2, 1),
(3, 'Это рептилойды так пытаются \"случайно\" вывести его из строя,чтоб не спалил их.', '2022-06-25 12:03:24', '2022-06-25 12:03:24', 2, 2),
(4, 'Так обидно за тех кто это создал и собрал, и запустил. Столько старались, такую целостную сверхточную и тонкую инженерину забабахали, а тут взяло и прилетело. Они, естественно, это предвидели, но вот перфекционист во мне прям грустит...', '2022-06-25 12:03:24', '2022-06-25 12:03:24', 3, 5),
(5, 'В зеркало телескопа «Джеймса Уэбба» уэббал микрометеорит.\r\n\r\n', '2022-06-25 12:03:39', '2022-06-25 12:03:39', 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `favorite`
--

CREATE TABLE `favorite` (
  `ID` int NOT NULL,
  `POST_ID` int NOT NULL,
  `USER_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `favorite`
--

INSERT INTO `favorite` (`ID`, `POST_ID`, `USER_ID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 3, 3),
(4, 4, 4),
(5, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `ID` int NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `DATA CREATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DATA UPDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PHOTO` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `AUTHOR_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`ID`, `TITLE`, `DESCRIPTION`, `DATA CREATE`, `DATA UPDATE`, `PHOTO`, `AUTHOR_ID`) VALUES
(1, 'Лучшие научные снимки мая6) Невыносимая жара', 'Жители Дели ищут тень под мостом на высохшем русле реки Ямуна в изнуряющий летний день. Во многих частях Индии по-прежнему наблюдаются чрезвычайно высокие температуры и засушливые условия, которые сохраняются с марта. Вызванное деятельностью человека изменение климата сделало смертельную жару в 30 раз более вероятной, говорят исследователи из инициативы World Weather Attribution.', '2022-06-25 11:52:08', '2022-06-25 11:52:08', NULL, 1),
(2, 'Лучшие научные снимки мая  Сцена на Шпицбергене⁠⁠', 'Телекоммуникационные купола спутниковой станции Шпицбергена (SvalSat) расположены на вершине горы недалеко от города Лонгйир на норвежском архипелаге Шпицберген. SvalSat — самая северная спутниковая станция в мире, которая может соединяться со спутниками на полярной орбите при каждом полете вокруг Земли, от одного полюса до другого.', '2022-06-25 11:52:08', '2022-06-25 11:52:08', NULL, 1),
(3, 'Лучшие научные снимки мая.  3) Речной монстр⁠⁠', 'Ошеломленные рыбаки столкнулись лицом к лицу с этим гигантским пресноводным скатом после того, как случайно вытащили его из темных глубин реки Меконг в Камбодже. 4-метровое существо было поймано после того, как оно проглотило мелкую рыбу на крючке с наживкой. После измерения и взвешивания спасательной командой (которая обнаружила колоссальные 181 кг), скат был выпущен невредимым обратно в реку. Меконг является признанным во всем мире очагом биоразнообразия, где обитает около 1000 видов рыб, в том числе очень редких.', '2022-06-25 11:53:12', '2022-06-25 11:53:12', NULL, 2),
(4, 'Лучшие научные снимки мая   1) Клетки, которые набухают⁠⁠', 'Молекулярные биологи обнаружили, что когда плоский лист клеток изгибается в кривую — как на этом изображении под микроскопом — клетки набухают и приобретают куполообразную форму . Исследователи говорят, что понимание того, как клетки реагируют на изгиб, может помочь в развитии органоидов — выращенных в лаборатории многоклеточных структур, которые предназначены для имитации микроанатомии органа.', '2022-06-25 11:53:12', '2022-06-25 11:53:12', NULL, 3),
(5, 'Тайна «великого затемнения» Бетельгейзе раскрыта⁠⁠', 'Снимки с японского космического корабля Himawari-8 проливают свет на удивительное исчезновение красного сверхгиганта.\r\n\r\nВ конце 2019 года, всего за несколько месяцев до того, как пандемия COVID-19 охватила весь земной шар, большая часть мира вместо этого была озабочена красноватой, угасающей точкой света на расстоянии более 500 световых лет. Бетельгейзе, красный сверхгигант, легко узнаваемый как правое «плечо» созвездия Ориона, внезапно и загадочным образом потускнел более чем в два раза. Некоторые астрономы предположили, что она вот-вот взорвется как сверхновая — событие, которое, по другим прогнозам, произойдет в течение следующих 100 000 лет или около того. К началу февраля 2020 года, однако, затухание прекратилось, и в течение нескольких недель звезда вернулась к своей обычной яркости, что оставило исследователей с нерешенными вопросами об этом странном эпизоде, который они назвали «Великое затемнение».', '2022-06-25 11:53:38', '2022-06-25 11:53:38', NULL, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `post_tags`
--

CREATE TABLE `post_tags` (
  `ID` int NOT NULL,
  `POST_ID` int NOT NULL,
  `TAG_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `post_tags`
--

INSERT INTO `post_tags` (`ID`, `POST_ID`, `TAG_ID`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 2, 3),
(4, 3, 3),
(5, 4, 5),
(6, 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `ID` int NOT NULL,
  `NAME` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`ID`, `NAME`) VALUES
(1, 'Новое'),
(2, 'Интересное '),
(3, 'Кино'),
(4, 'IT'),
(5, 'Скучное');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `ID` int NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `SURNAME` varchar(255) NOT NULL,
  `LOGIN` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `PHOTO` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`ID`, `NAME`, `SURNAME`, `LOGIN`, `PASSWORD`, `PHOTO`) VALUES
(1, 'Вася', 'Пупкин', 'vasia', 'vasiavasia', NULL),
(2, 'Илон', 'Маск', 'ilon', 'ilon', NULL),
(3, 'Андрей', 'Бодрей', 'andrey', 'andrey', NULL),
(4, 'Иван', 'Дубрыч', 'ivan', 'ivanivan', NULL),
(5, 'Алиса', 'В стране чудес', 'alisa', 'alisaalisa', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AUTHOR_ID` (`AUTHOR_ID`),
  ADD KEY `POST_ID` (`POST_ID`);

--
-- Индексы таблицы `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `POST_ID` (`POST_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AUTHOR_ID` (`AUTHOR_ID`);

--
-- Индексы таблицы `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `POST_ID` (`POST_ID`),
  ADD KEY `TAG_ID` (`TAG_ID`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `favorite`
--
ALTER TABLE `favorite`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`AUTHOR_ID`) REFERENCES `user` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`POST_ID`) REFERENCES `posts` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`POST_ID`) REFERENCES `posts` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`AUTHOR_ID`) REFERENCES `user` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`POST_ID`) REFERENCES `posts` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`TAG_ID`) REFERENCES `tags` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
