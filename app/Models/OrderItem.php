<?php

namespace App\Models;

use App\Traits\UploadTrait;
use App\Builders\CteBuilder;
use App\Traits\GalleryTrait;
use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * App\Models\OrderItem
 */
class OrderItem extends WeBaseModel
{
    use HasRecursiveRelationships;
    use \Staudenmeir\LaravelCte\Eloquent\QueriesExpressions;
    use AttributeTrait;
    use UploadTrait;
    use GalleryTrait;

    protected $table = 'order_items';

    protected $fillable = ['subject_id', 'subject_type', 'name', 'excerpt', 'base_price', 'discount_amount', 'subtotal_price', 'total_price', 'tax', 'quantity', 'ordering', 'serial_numbers', 'variant', 'created_at', 'updated_at'];

    protected $visible = ['id', 'subject_id', 'subject_type', 'name', 'excerpt', 'base_price', 'discount_amount', 'subtotal_price', 'total_price', 'tax', 'quantity', 'ordering', 'serial_numbers', 'variant', 'created_at', 'updated_at'];

    protected $guarded = [];

    protected $casts = [
        'serial_numbers' => 'array',
        'variant' => 'array',
    ];

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return CteBuilder|static
     */
    public function newEloquentBuilder($query)
    {
        return new CteBuilder($query);
    }

    public function getParentKeyName() {
        return 'parent_id';
    }

    public function getLocalKeyName() {
        return 'id';
    }

    public function getPathName()
    {
        return 'path';
    }

    public function getPathSeparator()
    {
        return '.';
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function subject()
    {
        return $this->morphTo('subject');
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }
}
