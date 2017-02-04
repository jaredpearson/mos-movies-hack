
Running a migration against the database
```
docker exec -i "$(docker-compose ps -q postgres)" psql -U postgres -f - mosmovies < v001___initial.sql
```