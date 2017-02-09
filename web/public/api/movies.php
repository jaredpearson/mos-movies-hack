<?hh

namespace Movies\Api\Controllers;
use \Movies\Data\Movies;

require_once __DIR__.'/../../lib/movies.php';

class MoviesApiController {
    public function get() {
        $moviePage = Movies\loadMoviesPage();
        echo json_encode($moviePage);
    }

    public function post() {
        $requestBody = file_get_contents('php://input');
        if (empty($requestBody)) {
            http_response_code(400);
            echo json_encode(Map {'error' => 'Missing JSON body'});
            exit();
        }

        $requestAsJson = json_decode($requestBody, true);
        if (empty($requestAsJson['title'])) {
            http_response_code(400);
            echo json_encode(Map {'error' => 'Missing required attribute: title'});
            exit();
        } else {
            $newMovieId = Movies\saveMovie($requestAsJson['title']);
            echo json_encode(Movies\loadMovieById($newMovieId));
        }
    }
}

$controller = new MoviesApiController();
header('Content-Type: application/json; charset=utf8');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->post();

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->get();

} else {
    http_response_code(405);

}