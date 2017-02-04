<?hh

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

class Movie {
    public int $id;
    public string $title;

    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
    }
}

function getMovies(): Vector<Movie> {
    $movies = Vector{};
    $cnn = pg_connect("host=postgres dbname=mosmovies user=webapp password=mosmovies");
    $result = pg_query($cnn, "SELECT movies_id, title FROM movies ORDER BY title");
    while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
        $movies->add(new Movie($row["movies_id"], $row["title"]));
    }
    pg_free_result($result);
    pg_close($cnn);
    return $movies;
}

$movieEls = getMovies()->map($movie ==> {
    return <div id={$movie->id}>{$movie->title}</div>;
});

echo '<!DOCTYPE html>';
echo 
<html>
<head>
<title>Movies</title>
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet" />
<link href="/css/main.css" rel="stylesheet" />
</head>
<body>
<div>{$movieEls}</div>
</body>
</html>;