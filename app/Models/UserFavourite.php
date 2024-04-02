<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserFavourite
 * 
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property User $user
 *
 * @package App\Models
 */
class UserFavourite extends Model
{
	const ID = 'id';
	const USER_ID = 'user_id';
	const PRODUCT_ID = 'product_id';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $table = 'user_favourites';

	protected $casts = [
		self::ID => 'int',
		self::USER_ID => 'int',
		self::PRODUCT_ID => 'int',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];

	protected $fillable = [
		self::USER_ID,
		self::PRODUCT_ID
	];

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
