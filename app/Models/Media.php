<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    protected $fillable = [
        'url',
        'imageable_id',
        'imageable_type'
    ];

    /**
     * Get the parent imageable model (article, product).
     */
    public function imageable() {
        return $this->morphTo();
    }
}
