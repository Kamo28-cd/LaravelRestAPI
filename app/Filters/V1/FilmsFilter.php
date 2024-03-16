<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class FilmsFilter extends ApiFilter
{


    protected $safeParms = [
        'title' => ['eq'],
        'description' => ['eq'],
        'posterImage' => ['eq'],
        'rating' => ['eq', 'gt', 'lt', 'lte', 'gte'],
        'releaseDate' => ['eq', 'gt', 'lt', 'lte', 'gte'],
        'directorId' => ['eq'],
    ];

    protected $columnMap = [
        'releaseDate' => 'release_date',
        'posterImage' => 'poster_image',
        'directorId' => 'director_id'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];


}