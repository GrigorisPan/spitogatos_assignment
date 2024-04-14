<?php

/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */

function basePath($path = '')
{
  return __DIR__ . '/' . $path;
}

/**
 * Load a view 
 *
 * @param string $name
 * @return void
 */

function loadView($name, $data = [])
{
  $viewPath = basePath("App/views/{$name}.view.php");

  if (file_exists($viewPath)) {
    extract($data);
    require $viewPath;
  } else {
    echo "View '{$name} not found'";
  };
}

/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name, $data = [])
{

  $partialPath = basePath("App/views/partials/{$name}.php");

  if (file_exists($partialPath)) {
    extract($data);
    require $partialPath;
  } else {
    echo "View '{$name} not found!'";
  };
}

/**
 * Sanitize Data 
 * 
 * @param string $dirty
 * @return string
 * 
 */

function Sanitize($dirty)
{
  return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect to given url
 * 
 * @param string @url
 * @return void
 */
function redirect($url)
{
  header("Location: {$url}");
  exit;
}
