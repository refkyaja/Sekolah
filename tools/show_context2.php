<?php
$s = file_get_contents(__DIR__ . '/../app/Http/Controllers/Admin/SpmbController.php');
$offset = 4749;
$start = max(0, $offset - 200);
$end = min(strlen($s), $offset + 200);
$context = substr($s, $start, $end - $start);
$line = substr_count(substr($s,0,$offset), "\n") + 1;
echo "Line: $line\n\n";
echo $context;
