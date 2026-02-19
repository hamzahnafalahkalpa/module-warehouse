# CLAUDE.md - Module Warehouse

## Overview

`hanafalah/module-warehouse` is a Laravel package providing warehouse and inventory management capabilities for the Wellmed healthcare system. It handles stock tracking, batch management, goods receipt, stock movements, and physical warehouse/building/room organization.

**Namespace:** `Hanafalah\ModuleWarehouse`

## Dependencies

```json
{
    "hanafalah/laravel-support": "dev-main",
    "hanafalah/laravel-has-props": "dev-main",
    "hanafalah/module-funding": "dev-main"
}
```

## Important Warning

**DO NOT EXTEND `BaseServiceProvider` DIRECTLY IN APPLICATION CODE.**

The `ModuleWarehouseServiceProvider` extends `Hanafalah\LaravelSupport\Providers\BaseServiceProvider`. This base class contains critical auto-registration logic via the `registers(['*'])` method that:
- Auto-discovers and binds contracts to implementations
- Registers schemas, data classes, and models
- Sets up configuration merging

If you need to extend this module's functionality, create your own service provider that registers additional bindings without conflicting with the base registration logic.

## Architecture

### Service Provider

The `ModuleWarehouseServiceProvider` handles:
- Main class registration (`ModuleWarehouse::class`)
- Command service registration
- Auto-registration of all schemas, contracts, and data classes

### Core Components

#### Stock Management

**Stock Model** (`Models/Stock/Stock.php`)
- Tracks inventory levels per subject (item), warehouse, and funding source
- Supports parent-child hierarchy for aggregated stock views
- Uses polymorphic relationships for flexible warehouse and subject types
- Automatically creates parent stock records when funding is specified

Key relationships:
- `subject()` - Morphable (what item is being stocked)
- `warehouse()` - Morphable (where the stock is located)
- `funding()` - Belongs to Funding model
- `supplier()` - Morphable supplier relationship
- `procurement()` - Morphable procurement relationship
- `stockBatches()` - Has many stock batches

**Stock Movement Model** (`Models/Stock/StockMovement.php`)
- Records all stock changes (in/out/opname/request)
- Tracks opening and closing stock levels
- Parent-child structure for grouped movements
- Uses ULID for primary keys

Direction enum values:
- `IN` - Stock received
- `OUT` - Stock consumed/dispatched
- `OPNAME` - Stock adjustment/reconciliation
- `REQUEST` - Stock request
- `OTHER` - Other movements

**Batch Model** (`Models/Stock/Batch.php`)
- Tracks batch numbers and expiration dates
- Links to stock through `StockBatch` pivot

**Batch Movement Model** (`Models/Stock/BatchMovement.php`)
- Tracks movements specific to batches

**Goods Receipt Unit** (`Models/Stock/GoodsReceiptUnit.php`)
- Records received goods with unit conversion
- Links to card stock and stock movements

#### Building and Room Management

**Building Model** (`Models/Building/Building.php`)
- Represents physical buildings/facilities
- Uses Unicode model for naming
- Supports address and phone information
- Contains multiple rooms

**Room Model** (`Models/Building/Room.php`)
- Represents storage locations within buildings
- Visibility scoping (visible/invisible rooms)
- Links to warehouse items and services
- Uses `HasWarehouseStock` trait for stock relationships

**WarehouseItem Model** (`Models/WarehouseItem.php`)
- Links items to warehouse locations
- Polymorphic warehouse and item relationships
- Supports flagging for categorization

### Enums

**Direction** (`Enums/MainMovement/Direction.php`)
```php
enum Direction: string {
    case IN      = 'IN';
    case OUT     = 'OUT';
    case OPNAME  = 'OPNAME';
    case REQUEST = 'REQUEST';
    case OTHER   = 'OTHER';
}
```

**PriceUpdateMethod** (`Enums/MainMovement/PriceUpdateMethod.php`)
```php
enum PriceUpdateMethod: string {
    case AVERAGE = 'AVERAGE';
    case MIN     = 'MIN';
    case MAX     = 'MAX';
}
```

### Traits (Concerns)

**HasStock** (`Concerns/Stock/HasStock.php`)
- Add to models that can have stock (e.g., items, products)
- Provides `stock()` and `stocks()` morphable relationships as subject

**HasWarehouseStock** (`Concerns/Stock/HasWarehouseStock.php`)
- Add to models that act as warehouses (e.g., rooms, storage locations)
- Provides `stock()` and `stocks()` morphable relationships as warehouse

**HasRoom** (`Concerns/Building/HasRoom.php`)
- Add to models that can be associated with rooms

### Data Transfer Objects

Located in `src/Data/`:
- `StockData` - Stock creation/update payload
- `StockMovementData` - Movement recording payload
- `BatchData` - Batch information
- `BatchMovementData` - Batch movement tracking
- `StockBatchData` - Stock-batch association
- `BuildingData` - Building information
- `RoomData` - Room information
- `ModelHasWarehouseData` - Warehouse association
- `ModelHasRoomData` - Room association
- `WarehouseItemData` - Warehouse-item links
- `RoomItemCategoryData` - Room item categorization

### Schemas

Located in `src/Schemas/`:
- `Stock` - Stock creation and management logic
- `StockMovement` - Movement processing
- `Batch` - Batch management
- `BatchMovement` - Batch movement tracking
- `StockBatch` - Stock-batch relationships
- `Building` - Building management
- `Room` - Room management
- `ModelHasRoom` - Room associations
- `ModelHasWarehouse` - Warehouse associations
- `WarehouseItem` - Warehouse item links
- `GoodsReceiptUnit` - Goods receipt processing
- `RoomItemCategory` - Room item categorization

### API Resources

Located in `src/Resources/`:
- View resources for list displays
- Show resources for detailed views

Each model has corresponding `View*` and `Show*` resources.

## Directory Structure

```
src/
├── Commands/              # Artisan commands
│   ├── EnvironmentCommand.php
│   └── InstallMakeCommand.php
├── Concerns/              # Reusable traits
│   ├── Building/
│   │   └── HasRoom.php
│   └── Stock/
│       ├── HasStock.php
│       └── HasWarehouseStock.php
├── Contracts/             # Interfaces
│   ├── Data/              # Data contract interfaces
│   ├── Schemas/           # Schema contract interfaces
│   └── ModuleWarehouse.php
├── Data/                  # Data Transfer Objects
├── Enums/                 # Enumerations
│   └── MainMovement/
│       ├── Direction.php
│       └── PriceUpdateMethod.php
├── Models/                # Eloquent models
│   ├── Building/
│   │   ├── Building.php
│   │   └── Room.php
│   ├── Stock/
│   │   ├── Batch.php
│   │   ├── BatchMovement.php
│   │   ├── GoodsReceiptUnit.php
│   │   ├── MainMovement.php
│   │   ├── MainStock.php
│   │   ├── Stock.php
│   │   ├── StockBatch.php
│   │   ├── StockFunding.php
│   │   └── StockMovement.php
│   ├── Storage/
│   │   ├── ModelHasStorage.php
│   │   └── Storage.php
│   ├── ModelHasRoom.php
│   ├── ModelHasWarehouse.php
│   ├── RoomItemCategory.php
│   └── WarehouseItem.php
├── Providers/             # Additional service providers
│   └── CommandServiceProvider.php
├── Resources/             # API resources
├── Routes/                # Route definitions
│   └── api/
│       └── room-item-category.php
├── Schemas/               # Business logic schemas
├── Supports/              # Support classes
│   └── BaseModuleWarehouse.php
├── ModuleWarehouse.php
└── ModuleWarehouseServiceProvider.php
```

## Usage Examples

### Adding Stock Tracking to a Model

```php
use Hanafalah\ModuleWarehouse\Concerns\Stock\HasStock;

class Product extends Model
{
    use HasStock;

    // Now has stock() and stocks() relationships
}
```

### Making a Model Act as a Warehouse

```php
use Hanafalah\ModuleWarehouse\Concerns\Stock\HasWarehouseStock;

class StorageRoom extends Model
{
    use HasWarehouseStock;

    // Now has stock() and stocks() relationships as warehouse
}
```

### Creating Stock via Schema

```php
$stockData = StockData::from([
    'subject_type' => 'Product',
    'subject_id' => $productId,
    'warehouse_type' => 'Room',
    'warehouse_id' => $roomId,
    'funding_id' => $fundingId,
    'stock' => 100
]);

$stockSchema = app(StockContract::class);
$stock = $stockSchema->prepareStoreStock($stockData);
```

### Recording Stock Movement

```php
$movementData = StockMovementData::from([
    'direction' => Direction::IN->value,
    'card_stock_id' => $cardStockId,
    'qty' => 50,
    'qty_unit_id' => $unitId,
    'item_stock_id' => $itemStockId
]);
```

## Configuration

The module uses the config key `module-warehouse`. Configuration can be published and customized as needed.

## Model Features

### Props System

Models using `HasProps` trait store denormalized data in a `props` JSON column:
- `props->prop_warehouse` - Cached warehouse info
- `props->prop_supplier` - Cached supplier info
- `props->prop_procurement` - Cached procurement info
- `props->prop_subject` - Cached subject info
- `props->prop_funding` - Cached funding info

This enables efficient querying via `getPropsQuery()` method.

### ULID Primary Keys

Stock movement models use ULID (Universally Unique Lexicographically Sortable Identifier) for primary keys, providing:
- Time-sortable IDs
- Globally unique without coordination
- URL-safe string format

### Soft Deletes

Models supporting soft deletes:
- `Room`
- `WarehouseItem`
- `GoodsReceiptUnit`

## Integration Points

- **module-funding** - Stock can be linked to funding sources
- **module-item** - Stock movements reference item stocks and card stocks
- **module-regional** - Building model uses address handling

## Common Patterns

### Stock Parent-Child Hierarchy

When stock has a `funding_id`, the system automatically creates or links to a parent stock record without funding. This allows:
- Aggregate stock view (parent) across all funding sources
- Detailed stock view (children) per funding source

### Visibility Scoping

Room model includes visibility scoping:
```php
// Get only visible rooms (default)
Room::all();

// Get invisible rooms
Room::invisible()->get();

// Check visibility status
Room::isVisible()->get();
Room::isInvisible()->get();
```
