<?php

namespace App\Models;

use App\Models\GeneratedRelations\PasswordResetTokenRelations;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use PasswordResetTokenRelations;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_reset_tokens';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
