<?hh

require_once __DIR__.'/../../lib/movies.php';

header('Content-Type: application/json; charset=utf8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestBody = file_get_contents('php://input');
    if (empty($requestBody)) {
        http_response_code(400);
        echo json_encode(Map {'error' => 'Missing JSON body'});
    }

    $requestAsJson = json_decode($requestBody, true);
    if (empty($requestAsJson['title'])) {
        http_response_code(400);
        echo json_encode(Map {'error' => 'Missing required attribute: title'});
    } else {
        $newMovieId = saveMovie($requestAsJson['title']);
        echo json_encode(loadMovieById($newMovieId));
    }

} else {

    $movies = loadMoviesPage();
    echo json_encode($_GET);
}