<?php
namespace Sq\Query\Resource;
use Illuminate\Support\Facades\Cache;
use Sq\Employee\Models\CardInfo;
// use Cache;
class NameSugestion
{
    public static function make(): array
    {
        Cache::remember('name_sugestion', now()->addDay(), function () {
           return CardInfo::query()->distinct()->pluck('name')->toArray();
        });
        return Cache::get('name_sugestion');
    }
}
