<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockMovementPropsData as DataStockMovementPropsData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class StockMovementPropsData extends Data implements DataStockMovementPropsData{
    #[MapInputName('funding_id')]
    #[MapName('funding_id')]
    public mixed $funding_id = null;

    #[MapInputName('margin')]
    #[MapName('margin')]
    public ?int $margin = 0;

    #[MapInputName('price')]
    #[MapName('price')]
    public ?int $price = 0;

    #[MapInputName('cogs')]
    #[MapName('cogs')]
    public ?int $cogs = 0;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(StockMovementPropsData $data): StockMovementPropsData{
        $data->props['prop_funding'] = [
            'id'   => null,
            'name' => null
        ];
        if (isset($data->funding_id)){
            $funding = self::new()->FundingModel()->findOrFail($data->funding_id);
            $data->props['prop_funding'] = [
                'id'   => $funding->id,
                'name' => $funding->name
            ];
        }
        return $data;
    }
}