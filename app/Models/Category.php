<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @property int $id
 * @property string $title
 * @property int $order
 * @property bool $active
 * @property string $image
 * @property int|null $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Category|null $category
 * @property Collection|Category[] $categories
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Category extends Model
{
	const ID = 'id';
	const TITLE = 'title';
	const ORDER = 'order';
	const ACTIVE = 'active';
	const IMAGE = 'image';
	const PARENT_ID = 'parent_id';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $table = 'category';

	protected $casts = [
		self::ID => 'int',
		self::ORDER => 'int',
		self::ACTIVE => 'bool',
		self::PARENT_ID => 'int',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];

	protected $fillable = [
		self::TITLE,
		self::ORDER,
		self::ACTIVE,
		self::IMAGE,
		self::PARENT_ID
	];

	public function parentCategory(): BelongsTo
	{
		return $this->belongsTo(Category::class, Category::PARENT_ID);
	}

	public function subCategories(): HasMany
	{
		return $this->hasMany(Category::class, Category::PARENT_ID);
	}

	public function categoryProducts(): BelongsToMany
	{
		return $this->belongsToMany(Product::class);
	}
}
