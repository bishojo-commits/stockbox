<?php

namespace Tests\Unit\Transformers;

use App\Models\Depot;
use App\Models\User;
use App\Transformers\DepotTotalTransformer;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\TestDataCreator;
use Tests\TestCase;

class DepotTotalTransformerTest extends TestCase
{
    use WithFaker;
    use TestDataCreator;

    public function testTransformerCalculatesDepotTotal()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $stock = $this->createStock('TSLA');
        $stockTwo = $this->createStock('IJ8');

        $depot->stocks()->attach($stock, $this->createStockPivotData(400.00, 6));
        $depot->stocks()->attach($stockTwo, $this->createStockPivotData(6.00, 10));

        $result[0] = $this->createResultData("TSLA", 500.00);
        $result[1] = $this->createResultData("IJ8", 7.00);

        $transformer = new DepotTotalTransformer($depot->stocks);
        $assertionResult = $transformer->transform($result);

        $this->assertEquals(3070.00, $assertionResult['depotTotal']);
    }

    public function testTransformerCalculatesDepotTotalEmptyResult()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $result = [];

        $transformer = new DepotTotalTransformer($depot->stocks);
        $assertionResult = $transformer->transform($result);

        $this->assertEquals(0.00, $assertionResult['depotTotal']);
    }
}
