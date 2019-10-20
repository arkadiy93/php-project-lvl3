<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $fillable = [
        'name',
        'content_length',
        'status_code',
        'body',
        'keywords',
        'description',
        'heading'
    ];
}
