<?php

namespace Sq\Card\Models;

use App\Support\HasCardInfo;
use App\Support\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintCard extends Model
{
    use HasFactory;
    use HasCardInfo;
    use HasUser;
    protected $guarded = [];
    protected $casts = [
        'issue' => 'date',
        'expire' => 'date'
    ];
    public function customPaperCard()
    {
        return $this->belongsTo(CustomPaperCard::class);
    }
    public function printCardFrame()
    {
        return $this->belongsTo(PrintCardFrame::class);
    }
}
