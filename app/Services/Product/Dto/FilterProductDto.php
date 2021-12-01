<?php


namespace App\Services\Product\Dto;


use Spatie\DataTransferObject\DataTransferObject;

class FilterProductDto extends DataTransferObject
{
    public int $perPage = 10;
    public array $onlyIds = [];
}
