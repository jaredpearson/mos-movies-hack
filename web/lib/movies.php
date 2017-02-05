<?hh

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/db.php';

class Movie {
    public int $id;
    public string $title;

    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
    }
}

class MoviePage {
    public int $total;
    public ImmVector<Movie> $movies;

    public function __construct(int $total, ImmVector<Movie> $movies) {
        $this->total = $total;
        $this->movies = $movies;
    }
}

function loadMoviesPage(): MoviePage {
    return withDb($cnn ==> {
        $movies = Vector{};
        $result = pg_query($cnn, "SELECT movies_id, title FROM movies ORDER BY title");
        while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
            $movies->add(new Movie($row["movies_id"], $row["title"]));
        }
        pg_free_result($result);

        $countResult = pg_query($cnn, "SELECT count(*) FROM movies;");
        $total = (int)pg_fetch_row($countResult)[0];

        return new MoviePage($total, $movies->immutable());
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
