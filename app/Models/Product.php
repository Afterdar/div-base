<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Product
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property string $image
 * @property bool $active
 * @property int $order
 * @property int $categoryId
 * @property int $subCategoryId
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 *
 * @property Category $category
 * @property SubCategory $subCategory
 *
 * @package App\Models
 */
class Product extends Model
{
	const ID = 'id';
	const TITLE = 'title';
	const PRICE = 'price';
	const IMAGE = 'image';
	const ACTIVE = 'active';
	const ORDER = 'order';
	const CATEGORY_ID = 'categoryId';
	const SUB_CATEGORY_ID = 'subCategoryId';
	const CREATED_AT = 'createdAt';
	const UPDATED_AT = 'updatedAt';
	protected $table = 'products';

	protected $casts = [
		self::ID => 'int',
		self::PRICE => 'float',
		self::ACTIVE => 'bool',
		self::ORDER => 'int',
		self::CATEGORY_ID => 'int',
		self::SUB_CATEGORY_ID => 'int',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];

	protected $fillable = [
		self::TITLE,
		self::PRICE,
		self::IMAGE,
		self::ACTIVE,
		self::ORDER,
		self::CATEGORY_ID,
		self::SUB_CATEGORY_ID
	];

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function sub_category(): BelongsTo
	{
		return $this->belongsTo(SubCategory::class);
	}
}
