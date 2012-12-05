CREATE TABLE sampletable
(
  id bigserial NOT NULL,
  name character varying(255),
  gender smallint DEFAULT 2,
  email character varying(255),
  birth date,
  address text,
  direction smallint DEFAULT 1,
  hobby character varying(255),
  CONSTRAINT pk_sample PRIMARY KEY (id )
)
WITH (
  OIDS=FALSE
);