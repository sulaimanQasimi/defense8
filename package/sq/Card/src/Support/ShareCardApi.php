<?php

namespace Sq\Card\Support;

use Sq\Card\Models\PrintCardFrame as Frame;
use Illuminate\Support\Facades\Http;

final class ShareCardApi
{
    public function share()
    {
        return Frame::all()->toJson(JSON_UNESCAPED_UNICODE);
    }
    public function fetch(string $ip)
    {
        $cards = Http::get("http://$ip/api/design-cards");
        if ($cards->successful())
            foreach (collect(json_decode($cards))->toArray() as $card) {
                $data = collect($card);
                $data->shift();
                dd($data, Frame::create($data->toArray()));
                Frame::create($data->toArray());
            }
    }
}
