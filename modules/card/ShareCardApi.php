<?php
namespace Card;

use App\Models\Card\CardInfo as Employee;
use App\Models\PrintCardFrame as Frame;
use Card\Contracts\GunCardField;
use Card\Contracts\InfoField;
use Card\Contracts\MainCardField;
use Card\Contracts\VehicalCardField;
use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;

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
            foreach (collect(json_decode($cards))->select(["name", "gov_logo", "ministry_logo", "background_logo", "gov_logo_x", "gov_logo_y", "ministry_logo_x", "ministry_logo_y", "profile_logo_x", "profile_logo_y", "qr_code_logo_x", "qr_code_logo_y", "gov_name", "gov_name_font_size", "ministry_name", "ministry_name_font_size", "info_font_size", "color", "type", "deleted_at", "created_at", "updated_at", "remark", "font_color", "dim", "attribute", "details",]) as $card) {
                Frame::create($card);
            }
    }
}
