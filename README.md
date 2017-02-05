This is a Facebook Hack version of a movie catalog.

# Setup
Install Docker including Docker Compose, then run the following command.

```
docker build && docker up
```

This should start the HHVM server on port 8081 and an Nginx server on port 8080.

# REST API
To get the list of movies:

```
curl http://localhost:8080/api/v1/movies
```

Add a new movie to the list:

```
curl http://localhost:8080/api/v1/movies -X POST -H "Content-Type: application/json" -d '{"title":"High Noon"}'
```