<?php
$s = file_get_contents(__DIR__ . '/../app/Http/Controllers/Admin/SpmbController.php');
$pairs = ['('=>')','['=>']','{'=>'}'];
$stack = [];
$len = strlen($s);
for ($i=0; $i<$len; $i++) {
    $c = $s[$i];
    if (isset($pairs[$c])) {
        $stack[] = ['c'=>$c, 'pos'=>$i];
    } elseif (in_array($c, $pairs)) {
        $last = array_pop($stack);
        if (!$last) {
            echo "Unmatched closing $c at offset $i\n";
            exit(1);
        }
        $expected = $pairs[$last['c']];
        if ($c !== $expected) {
            echo "Mismatch: opened {$last['c']} at offset {$last['pos']} but closed by $c at offset $i\n";
            exit(1);
        }
    }
}
if (count($stack)) {
    $last = end($stack);
    $line = substr_count(substr($s,0,$last['pos']), "\n") + 1;
    echo "Unclosed {$last['c']} at offset {$last['pos']} (line {$line}).\n";
} else {
    echo "All balanced\n";
}
