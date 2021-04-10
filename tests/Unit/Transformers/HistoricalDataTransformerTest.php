<?php

namespace Tests\Unit\Transformers;

use App\Models\Depot;
use App\Models\User;
use App\Transformers\HistoricalDataTransformer;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Helpers\TestDataCreator;

class HistoricalDataTransformerTest extends TestCase
{
    use WithFaker;
    use TestDataCreator;

    public function testTransformerSetsResultArray()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $stock = $this->createStock('TSLA');
        $depot->stocks()->attach($stock, $this->createStockPivotData(400.00, 6));
        $result = $this->createHistoricalDataResult();

        $transformer = new HistoricalDataTransformer($depot->stocks()->first());
        $assertionResult = $transformer->transform($result);

        $this->assertArrayHasKey("historical", $assertionResult);
        $this->assertCount(1, $assertionResult);
    }
}
