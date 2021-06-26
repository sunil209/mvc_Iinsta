<?php

function getDefinedValue(string $searchedValue, string $text) : ?string {
  $matches = [];
  $pattern = '/define *\( *[\'\"]' . $searchedValue . '[\'\"] *, *[\'\"](.*?)[\'\"] *\)/';
  preg_match($pattern, $text, $matches);

  return $matches[1] ?? null;
}

function sendResponse(int $status, string $message, string $responseBody = '') {
  if (!headers_sent()) {
    header(($_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1') . ' ' . $status . ' ' . $message, true, $status);
  }

  echo $responseBody;
  die();
}

function healthcheckFail() {
  sendResponse(500, 'Internal Server Error', 'ERROR');
}

function healthcheckSuccess() {
  sendResponse(200, 'OK', 'OK');
}

function executeHealthcheck() {
  $config     = file_get_contents('wp-config.php');
  $dbName     = getDefinedValue('DB_NAME', $config);
  $dbUser     = getDefinedValue('DB_USER', $config);
  $dbPassword = getDefinedValue('DB_PASSWORD', $config);
  $dbHost     = getDefinedValue('DB_HOST', $config);
  $dsn        = sprintf('mysql:dbname=%s;host=%s', $dbName, $dbHost);

  try {
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $result = $pdo->query('SELECT ID FROM wp_posts LIMIT 1');
    $result->closeCursor();
    unset($result);
    healthcheckSuccess();
  } catch (PDOException $e) {
    error_log($e->getMessage());
    healthcheckFail();
  }
}

executeHealthcheck();
