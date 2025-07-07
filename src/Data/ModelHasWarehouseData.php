<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasWarehouseData as DataModelHasWarehouseData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ModelHasWarehouseData extends Data implements DataModelHasWarehouseData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('model_type')]
    #[MapName('model_type')]
    public string $model_type;

    #[MapInputName('model_id')]
    #[MapName('model_id')]
    public mixed $model_id;

    #[MapInputName('warehouse_type')]
    #[MapName('warehouse_type')]
    public mixed $warehouse_type = null;

    #[MapInputName('warehouse_id')]
    #[MapName('warehouse_id')]
    public mixed $warehouse_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(self $data): self{
        $new = self::new();

        $props = &$data->props;

        $warehouse = $new->{$data->warehouse_type.'Model'}();
        $warehouse = (isset($data->warehouse_id)) ? $warehouse->findOrFail($data->warehouse_id) : $warehouse;
        $props['prop_warehouse'] = $warehouse->toViewApi()->resolve();

        $model = $new->{$data->model_type.'Model'}();
        $model = (isset($data->model_id)) ? $model->findOrFail($data->model_id) : $model;
        $props['prop_model'] = $model->toViewApi()->resolve();
        return $data;
    }
}