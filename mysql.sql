CREATE TABLE sampletable(
  id bigint auto_increment not null primary key,
  name varchar(255),
  gender smallint DEFAULT 2,
  email varchar(255),
  birth date,
  address text,
  direction smallint DEFAULT 1,
  hobby varchar(255))