<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class DirectorsFilter extends ApiFilter
{


    protected $safeParms = [
        'name' => ['eq'],
        'knowFor' => ['eq'],

    ];

    protected $columnMap = [
        'knowFor' => 'know_for'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];


}