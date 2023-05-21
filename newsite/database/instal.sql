create table tags
(
	ID   int auto_increment
		primary key,
	NAME varchar(255) not null
);

create table user
(
	ID       int auto_increment
		primary key,
	NAME     varchar(255) not null,
	SURNAME  varchar(255) not null,
	LOGIN    varchar(255) not null,
	PASSWORD varchar(255) not null,
	PHOTO    varchar(255) null
);

create table posts
(
	ID            int auto_increment
		primary key,
	TITLE         varchar(255)                        not null,
	DESCRIPTION   text                                not null,
	`DATA CREATE` timestamp default CURRENT_TIMESTAMP not null,
	`DATA UPDATE` timestamp default CURRENT_TIMESTAMP not null,
	PHOTO         varchar(255)                        null,
	AUTHOR_ID     int                                 not null,
	constraint posts_ibfk_1
		foreign key (AUTHOR_ID) references user (ID)
);

create table comments
(
	ID          int auto_increment
		primary key,
	DESCRIPTION text                                not null,
	DATA_CREATE timestamp default CURRENT_TIMESTAMP not null,
	DATA_UPDATE timestamp default CURRENT_TIMESTAMP not null,
	POST_ID     int                                 not null,
	AUTHOR_ID   int                                 not null,
	constraint comments_ibfk_1
		foreign key (AUTHOR_ID) references user (ID),
	constraint comments_ibfk_2
		foreign key (POST_ID) references posts (ID)
);

-- create index AUTHOR_ID
-- 	on comments (AUTHOR_ID);
--
-- create index POST_ID
-- 	on comments (POST_ID);

create table favorite
(
	ID      int auto_increment
		primary key,
	POST_ID int not null,
	USER_ID int not null,
	constraint favorite_ibfk_1
		foreign key (POST_ID) references posts (ID),
	constraint favorite_ibfk_2
		foreign key (USER_ID) references user (ID)
);

-- create index POST_ID
-- 	on favorite (POST_ID);
--
-- create index USER_ID
-- 	on favorite (USER_ID);

create table post_tags
(
	ID      int auto_increment
		primary key,
	POST_ID int not null,
	TAG_ID  int not null,
	constraint post_tags_ibfk_1
		foreign key (POST_ID) references posts (ID),
	constraint post_tags_ibfk_2
		foreign key (TAG_ID) references tags (ID)
);

-- create index POST_ID
-- 	on post_tags (POST_ID);
--
-- create index TAG_ID
-- 	on post_tags (TAG_ID);
--
-- create index AUTHOR_ID
-- 	on posts (AUTHOR_ID);