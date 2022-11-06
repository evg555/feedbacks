create table users
(
    id       bigint unsigned auto_increment primary key,
    login    varchar(100) not null,
    password varchar(100) not null,

    constraint users_UN unique (login)
);

create table authors
(
    id    bigint unsigned auto_increment primary key,
    name  varchar(100) not null,
    email varchar(100) not null,

    constraint authors_UN unique (email)
);

create table feedbacks
(
    id        bigint unsigned auto_increment primary key,
    text      text                                       not null,
    image     varchar(100)                               null,
    created   datetime         default CURRENT_TIMESTAMP null,
    accept    tinyint unsigned default 0                 not null,
    changed   datetime                                   null,
    thumb     varchar(100)                               null,
    author_id bigint unsigned                            not null,

    constraint feedbacks_FK foreign key (author_id) references authors (id)
            on update cascade on delete cascade
);


