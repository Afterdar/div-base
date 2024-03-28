<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property bool $active
 * @property int $order
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 *
 * @property Collection|Product[] $products
 * @property Collection|SubCategory[] $sub_categories
 *
 * @package App\Models
 */
class Category extends Model
{
	const ID = 'id';
	const TITLE = 'title';
	const IMAGE = 'image';
	const ACTIVE = 'active';
	const ORDER = 'order';
	const CREATED_AT = 'createdAt';
	const UPDATED_AT = 'updatedAt';
	protected $table = 'categories';

	protected $casts = [
		self::ID => 'int',
		self::ACTIVE => 'bool',
		self::ORDER => 'int',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];

	protected $fillable = [
		self::TITLE,
		self::IMAGE,
		self::ACTIVE,
		self::ORDER
	];

	public function products(): HasMany
	{
		return $this->hasMany(Product::class);
	}

	public function sub_categories(): HasMany
	{
		return $this->hasMany(SubCategory::class);
	}
}
