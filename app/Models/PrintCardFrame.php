<?php

namespace App\Models;

use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintCardFrame extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $casts = [
        'attribute' => 'array',
    ];
    protected $fillable=["name",
        "gov_logo",
        "ministry_logo",
        "background_logo",
        "gov_logo_x",
        "gov_logo_y",
        "ministry_logo_x",
        "ministry_logo_y",
        "profile_logo_x",
        "profile_logo_y",
        "qr_code_logo_x",
        "qr_code_logo_y",
        "gov_name",
        "gov_name_font_size",
        "ministry_name",
        "ministry_name_font_size",
        "info_font_size",
        "color",
        "type",
        "deleted_at",
        "created_at",
        "updated_at",
        "remark",
        "font_color",
        "dim",
        "attribute",
        "details",];
}
