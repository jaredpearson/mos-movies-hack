<?hh

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

function withDb<T>((function(resource):T) $workFn) :T {
    $cnn = pg_connect("host=postgres dbname=mosmovies user=webapp password=mosmovies");
    $result = $workFn($cnn);
    pg_close($cnn);
    return $result;
}