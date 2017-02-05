<?hh

require_once __DIR__.'/../../lib/movies.php';

$movies = loadMoviesPage();

header('Content-Type: application/json; charset=utf8');

echo json_encode($movies);