<?php
function getNumbers()
{
    $numbers = [];
    for ($i = 1; $i <= 5; $i++) {
        $numbers[] = $i;
    }
    return $numbers;
}

foreach (getNumbers() as $num) {
    echo $num . PHP_EOL;
}
function getNumbersGenerator()
{
    for ($i = 1; $i <= 5; $i++) {
        yield $i;  // Yield each value one at a time
    }
}

foreach (getNumbersGenerator() as $num) {
    echo $num . PHP_EOL;
}
