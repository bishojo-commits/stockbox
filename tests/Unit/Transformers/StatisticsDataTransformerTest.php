<?php

namespace Tests\Unit\Transformers;

use App\Transformers\StatisticsDataTransformer;
use Tests\TestCase;
use Tests\Helpers\TestDataCreator;

class StatisticsDataTransformerTest extends TestCase
{
    use TestDataCreator;

    public function testTransformerReturnsResultWithSummaryKey() {
        $result = $this->createEmptyResult();
        $stock = $this->createStock('TSLA');

        $transformer = new StatisticsDataTransformer($stock);
        $assertionResult = $transformer->transform($result);

        $this->assertArrayHasKey("statistics", $assertionResult);
    }
}
