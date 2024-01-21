<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Logo extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'file_name',
        'original_file_name'

    ];

    /**
     * Retrieves the company
     *
     * @return App\Models\Company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
