<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleItem\Contracts\Data\GoodsReceiptUnitData;
use Hanafalah\ModuleItem\Contracts\Data\ItemStockData;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockMovementData as DataStockMovementData;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockMovementPropsData;
use Hanafalah\ModuleWarehouse\Enums\MainMovement\Direction;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Enum;

class StockMovementData extends Data implements DataStockMovementData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;

    #[MapInputName('direction')]
    #[MapName('direction')]
    #[Enum(Direction::class)]
    public mixed $direction = null;

    #[MapInputName('card_stock_id')]
    #[MapName('card_stock_id')]
    public mixed $card_stock_id = null;

    #[MapInputName('card_stock_model')]
    #[MapName('card_stock_model')]
    public ?object $card_stock_model = null;

    #[MapInputName('reference_type')]
    #[MapName('reference_type')]
    public ?string $reference_type = null;

    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id = null;

    #[MapInputName('item_stock_id')]
    #[MapName('item_stock_id')]
    public mixed $item_stock_id = null;

    #[MapInputName('item_stock')]
    #[MapName('item_stock')]
    public ?ItemStockData $item_stock = null;

    #[MapInputName('goods_receipt_unit_id')]
    #[MapName('goods_receipt_unit_id')]
    public mixed $goods_receipt_unit_id = null;

    #[MapInputName('goods_receipt_unit')]
    #[MapName('goods_receipt_unit')]
    public ?GoodsReceiptUnitData $goods_receipt_unit = null;

    #[MapInputName('qty')]
    #[MapName('qty')]
    public ?float $qty = 0;

    #[MapInputName('qty_unit_id')]
    #[MapName('qty_unit_id')]
    public mixed $qty_unit_id = null;

    #[MapInputName('qty_unit')]
    #[MapName('qty_unit')]
    public ?array $qty_unit = null;

    #[MapInputName('opening_stock')]
    #[MapName('opening_stock')]
    public ?float $openingStock = null;

    #[MapInputName('closing_stock')]
    #[MapName('closing_stock')]
    public ?float $closingStock = null;

    #[MapInputName('batch_movements')]
    #[MapName('batch_movements')]
    #[DataCollectionOf(BatchMovementData::class)]
    public ?array $batch_movements = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?StockMovementPropsData $props = null;

    public static function after(StockMovementData $data): StockMovementData{
        $new = self::new();
        $props = &$data->props->props;

        $qty_unit = $new->ItemStuffModel();
        if (isset($data->qty_unit_id)) $qty_unit = $qty_unit->withoutGlobalScope('flag')->findOrFail($data->qty_unit_id);
        $props['prop_unit'] = $qty_unit->toViewApi()->resolve();

        $item_stock = $new->ItemStockModel();
        if (isset($data->item_stock_id)) $item_stock = $item_stock->findOrFail($data->item_stock_id);
        $props['prop_item_stock'] = $item_stock->toViewApi()->resolve();

        if (isset($data->reference_type)){
            $reference = $new->{$data->reference_type.'Model'}();
            if (isset($data->reference_id)) $reference = $reference->findOrFail($data->reference_id);
            $props['prop_reference'] = $reference->toViewApi()->resolve();
        }
        return $data;
    }
}