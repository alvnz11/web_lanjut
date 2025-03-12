<?php

namespace App\Models;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level';

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }
}
