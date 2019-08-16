<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'domains';

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
