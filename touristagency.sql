create database TouristAgency;
use TouristAgency;
create table countries( id int not null auto_increment primary key, country varchar(64) unique) default charset='utf8';
create table cities( id int not null auto_increment primary key, city varchar(64), countryid int, foreign key(countryid) references countries(id) on delete cascade, unique index ucity(city, countryid)) default charset='utf8';
create table hotels( id int not null auto_increment primary key, hotel varchar(64), cityid int, foreign key(cityid) references cities(id) on delete cascade, countryid int, foreign key(countryid) references countries(id) on delete cascade, stars int, cost int, info varchar(2048))default charset='utf8';
create table images( id int not null auto_increment primary key, imagepath varchar(255), hotelid int,  foreign key(hotelid) references hotels(id) on delete cascade) default charset='utf8';
create table roles( id int not null auto_increment primary key, role varchar(32))default charset='utf8';
create table users( id int not null auto_increment primary key, login varchar(32) unique, pass varchar(128), email varchar(128), roleid int,  foreign key(roleid) references roles(id) on delete cascade, avatar mediumblob )default charset='utf8';
use TouristAgency;
insert into roles (role) values ('admin'), ('customer');
use TouristAgency;
select id from roles where role = 'admin';
use TouristAgency;
update users set roleid = 1 where id = 1;

use TouristAgency;
alter table comments
add column hotel_id int not null,
add constraint fk_hotel_id foreign key (hotel_id) references hotels(id);

use TouristAgency;
alter table comments convert to  character set utf8mb4 collate utf8mb4_unicode_ci;

use TouristAgency;
drop table if exists EXISTS comments;
create table comments (
    id int auto_increment primary key,
    user_id int not null,
    hotel_id int not null,
    comment text not null,
    posted timestamp default current_timestamp,
    foreign key (user_id) references users(id),
    foreign key (hotel_id) references hotels(id)
) default charset='utf8mb4';

use TouristAgency;
-- Удаление комментариев для отелей в Украине и Нидерландах, для этого в Edit -> Preferences->SQL Editor->
-- снять галочку с Safe Updates (reject UPDATEs and DELETEs with no restrictions)
delete from comments 
where hotel_id in (
    select id from hotels 
    where countryid in (
        select id from countries where country in ('Украина', 'Нидерланды')
    )
);

use TouristAgency;
delete from countries where country in('Украина', 'Нидерланды');

use TouristAgency;
-- Удаление комментариев для отелей в Украине и Нидерландах, для этого в Edit -> Preferences->SQL Editor->
-- снять галочку с Safe Updates (reject UPDATEs and DELETEs with no restrictions)
delete from comments 
where hotel_id in (
    select id from hotels 
    where countryid in (
        select id from countries where country in ('Ukraine', 'Pays-Bas')
    )
);

use TouristAgency;
update hotels
set hotel = 'Hotel "Gagapinn"'
where hotel = 'hotel &quot;Gagapinn&quot;';


