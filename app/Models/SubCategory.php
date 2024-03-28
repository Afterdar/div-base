<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SubCategory
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property bool $active
 * @property int $order
 * @property int|null $categoryId
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 *
 * @property Category|null $category
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class SubCategory extends Model
{
	const ID = 'id';
	const TITLE = 'title';
	const IMAGE = 'image';
	const ACTIVE = 'active';
	const ORDER = 'order';
	const CATEGORY_ID = 'categoryId';
	const CREATED_AT = 'createdAt';
	const UPDATED_AT = 'updatedAt';
	protected $table = 'sub_categories';

	protected $casts = [
		self::ID => 'int',
		self::ACTIVE => 'bool',
		self::ORDER => 'int',
		self::CATEGORY_ID => 'int',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];

	protected $fillable = [
		self::TITLE,
		self::IMAGE,
		self::ACTIVE,
		self::ORDER,
		self::CATEGORY_ID
	];

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function products(): HasMany
	{
		return $this->hasMany(Product::class);
	}
}
