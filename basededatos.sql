/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  admin
 * Created: 25-sep-2020
 */

CREATE DATABASE IF NOT EXISTS psicoltkt;
USE psicoltkt;

CREATE TABLE users(
id              int(255) auto_increment not null,
name            varchar(50) NOT NULL,
surname         varchar(100),
role            varchar(20) DEFAULT 'ROLE_USER',
email           varchar(255) NOT NULL,
password        varchar(255) NOT NULL,
image           varchar(255),
created_at      datetime DEFAULT NULL,
updated_at      datetime DEFAULT NULL,
remember_token  varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE categories(
id              int(255) auto_increment not null,
name            varchar(100),
created_at      datetime DEFAULT NULL,
updated_at      datetime DEFAULT NULL,
CONSTRAINT pk_categories PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE posts(
id              int(255) auto_increment not null,
user_id         int(255) not null,
category_id     int(255) not null,
title           varchar(255) not null,
content         text not null,
image           varchar(255),
created_at      datetime DEFAULT NULL,
updated_at      datetime DEFAULT NULL,
CONSTRAINT pk_posts PRIMARY KEY(id),
CONSTRAINT fk_post_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_post_category FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDb;

CREATE TABLE events(
id              int(255) auto_increment not null,
category_id     int(255) not null,
title           varchar(255) not null,
content         text not null,
image           varchar(255),
capacity     int(255),
available     int(255),
created_at      datetime DEFAULT NULL,
updated_at      datetime DEFAULT NULL,
CONSTRAINT pk_events PRIMARY KEY(id),
CONSTRAINT fk_events_category FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDb;

CREATE TABLE tkts(
id              int(255) auto_increment not null,
user_id         int(255) not null,
events_id     int(255) not null,
created_at      datetime DEFAULT NULL,
updated_at      datetime DEFAULT NULL,
CONSTRAINT pk_tkts PRIMARY KEY(id),
CONSTRAINT fk_tkt_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_tkt_events FOREIGN KEY(events_id) REFERENCES events(id)
)ENGINE=InnoDb;