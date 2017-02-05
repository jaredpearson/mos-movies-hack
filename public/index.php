<?hh
namespace movies;

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once 'db.php';

class Movie {
    public int $id;
    public string $title;

    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
    }
}

function loadMovies(): Vector<Movie> {
    return withDb($cnn ==> {
        $movies = Vector{};
        $result = pg_query($cnn, "SELECT movies_id, title FROM movies ORDER BY title");
        while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
            $movies->add(new Movie($row["movies_id"], $row["title"]));
        }
        pg_free_result($result);
        return $movies;
    });
}

function saveMovie(string $title) : int {
    return withDb($cnn ==> {
        $result = pg_query_params($cnn, "INSERT INTO movies (title) VALUES ($1) RETURNING movies_id", array($title));
        $newMovieId = (int)pg_fetch_row($result)[0];
        pg_free_result($result);
        return $newMovieId;
    });
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST) && !empty($_POST['title'])) {
        saveMovie($_POST['title']);
    }
}

$movieEls = loadMovies()->map($movie ==> {
    return 
        <div>
            <div>
                {$movie->title}
            </div>
        </div>;
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
<div style="margin-bottom: 1em;">
    <form action="index.php" method="post">
        <div style="display: table">
            <div style="display: table-row">
                <div style="display: table-cell">Title:</div>
                <input style="display: table-cell" type="text" name="title" />
            </div>
            <div style="display: table-row">
                <div style="display: table-cell"></div>
                <button type="submit">Add</button>
            </div>
        </div>
    </form>
</div>
<div class="table-movies">{$movieEls}</div>
</body>
</html>;