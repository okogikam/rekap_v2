<?php
// Execute a simple command
$last_line = exec('ping habar.my.id', $output_array, $return_code);

//echo "Last line: " . $last_line . "\n";
//echo "Exit code: " . $return_code . "\n";
echo "<pre>";
print_r($output_array);
echo "</pre>";
?>
