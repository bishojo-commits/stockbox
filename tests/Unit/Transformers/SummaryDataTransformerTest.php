<?php

namespace Tests\Unit\Transformers;

use App\Transformers\SummaryDataTransformer;
use Tests\TestCase;
use Tests\Helpers\TestDataCreator;

class SummaryDataTransformerTest extends TestCase
{
    use TestDataCreator;

    public function testTransformerReturnsResultWithSummaryKey() {
        $result = $this->createEmptyResult();
        $stock = $this->createStock('TSLA');

        $transformer = new SummaryDataTransformer($stock);
        $assertionResult = $transformer->transform($result);

        $this->assertArrayHasKey("summary", $assertionResult);
    }
}
