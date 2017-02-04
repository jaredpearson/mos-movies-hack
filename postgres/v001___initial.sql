CREATE DATABASE mosmovies;
\connect mosmovies;
begin transaction;

CREATE USER webapp PASSWORD 'mosmovies';
GRANT CONNECT ON DATABASE mosmovies TO webapp;

CREATE TABLE movies (
    movies_id serial primary key,
    title text not null
);
GRANT all ON movies TO webapp;

GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public TO webapp;

end transaction;
