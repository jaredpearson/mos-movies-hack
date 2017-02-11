<?hh
require_once __DIR__.'/../vendor/autoload.php';

http_response_code(404);
echo '<!DOCTYPE html>';
echo 
<html>
<head>
<title>Movies - Page Not Found</title>
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet" />
<link href="/css/main.css" rel="stylesheet" />
</head>
<body>
<h1>Page Not Found</h1>
</body>
</html>;