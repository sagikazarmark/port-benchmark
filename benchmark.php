<?php

require __DIR__.'/vendor/autoload.php';

use Nerd\CartesianProduct\CartesianProduct;
use Port\Reader\IteratorReader;
use Port\Steps\Step\ConverterStep;
use Port\Steps\StepAggregator;
use Port\Writer\CallbackWriter;

$bench = new Ubench;

// Generating large dataset without memory footprint => better results
$data = [
    'row1' => ['row1_value1', 'row1_value2', 'row1_value3', 'row1_value4', 'row1_value5', 'row1_value6', 'row1_value7'],
    'row2' => ['row2_value1', 'row2_value2', 'row2_value3', 'row2_value4', 'row2_value5', 'row2_value6', 'row2_value7'],
    'row3' => ['row3_value1', 'row3_value2', 'row3_value3', 'row3_value4', 'row3_value5', 'row3_value6', 'row3_value7'],
    'row4' => ['row4_value1', 'row4_value2', 'row4_value3', 'row4_value4', 'row4_value5', 'row4_value6', 'row4_value7'],
    'row5' => ['row5_value1', 'row5_value2', 'row5_value3', 'row5_value4', 'row5_value5', 'row5_value6', 'row5_value7'],
    'row6' => ['row6_value1', 'row6_value2', 'row6_value3', 'row6_value4', 'row6_value5', 'row6_value6', 'row6_value7'],
    // 'row7' => ['row7_value1', 'row7_value2', 'row7_value3', 'row7_value4', 'row7_value5', 'row7_value6', 'row7_value7'],
    // 'row8' => ['row8_value1', 'row8_value2', 'row8_value3', 'row8_value4', 'row8_value5', 'row8_value6', 'row8_value7'],
    // 'row9' => ['row9_value1', 'row9_value2', 'row9_value3', 'row9_value4', 'row9_value5', 'row9_value6', 'row9_value7'],
];

$cartesianProduct = new CartesianProduct($data);
$reader = new IteratorReader($cartesianProduct);
$workflow = new StepAggregator($reader);

$writer = new CallbackWriter(function($item) {});
$workflow->addWriter($writer);

$converterStep = new ConverterStep;
$converterStep->add(function($item) { return $item; });
$workflow->addStep($converterStep);

$bench->start();

$result = $workflow->process();

$bench->end();

echo sprintf("%d items\n", $result->getTotalProcessedCount());
echo $bench->getTime();
echo "\n";
echo $bench->getMemoryPeak();
echo "\n";
echo $bench->getMemoryUsage();
echo "\n";
