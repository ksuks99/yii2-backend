<?php 


/*
1.
function console_log($data){ // сама функция
    if(is_array($data) || is_object($data)){
    echo("<script>console.log('php_array: ".json_encode($data)."');</script>");
  } else {
    echo("<script>console.log('php_string: ".$data."');</script>");
  }
}

// вызов функции
$test='dsa';
console_log($test);


2.
function console_log( ...$messages ){
  $msgs = '';
  foreach ($messages as $msg) {
    $msgs .= json_encode($msg);
  }

  echo '<script>';
  echo 'console.log('. json_encode($msgs) .')';
  echo '</script>';
}

*/

/**
 * Simple helper to debug to the console
 *
 * @param $data object, array, string $data
 * @param $context string  Optional a description.
 *
 * @return string
 */
function debug_to_console($data, $context = 'Debug in Console') {

    // Buffering to solve problems frameworks, like header() in this and not a solid return.
    ob_start();

    $output  = 'console.info(\'' . $context . ':\');';
    $output .= 'console.log(' . json_encode($data) . ');';
    $output  = sprintf('<script>%s</script>', $output);

    echo $output;
}


// $data is the example variable, object; here an array.
$data = [ 'foo' => 'bar' ];
debug_to_console($data);`

?>