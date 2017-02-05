<?hh
namespace movies;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../lib/movies.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST) && !empty($_POST['title'])) {
        saveMovie($_POST['title']);
    }
}

$movieEls = loadMoviesPage()->movies->map($movie ==> {
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