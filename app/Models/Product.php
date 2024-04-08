<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Product
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property string $image
 * @property bool $active
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Category[] $categories
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
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $table = 'products';

	protected $casts = [
		self::ID => 'int',
		self::PRICE => 'float',
		self::ACTIVE => 'bool',
		self::ORDER => 'int',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];

	protected $fillable = [
		self::TITLE,
		self::PRICE,
		self::IMAGE,
		self::ACTIVE,
		self::ORDER
	];

	public function categories(): BelongsToMany
	{
		return $this->belongsToMany(Category::class);
	}

	public function favouriteUsers(): BelongsToMany
	{
        return $this->belongsToMany(User::class);
	}
}
