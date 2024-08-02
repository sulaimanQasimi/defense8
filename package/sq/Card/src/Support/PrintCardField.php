<?php
namespace Sq\Card\Support;

use App\Models\Card\CardInfo as Employee;
use Sq\Card\Models\PrintCardFrame as Frame;
use Sq\Card\Support\GunCardField;
use Sq\Card\Support\InfoField;
use Sq\Card\Support\MainCardField;
use Sq\Card\Support\VehicalCardField;
use Closure;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;

final class PrintCardField
{

    use GunCardField;
    use InfoField;
    use MainCardField;
    use VehicalCardField;

    public $version;

    public function __construct(private Employee $employee, private Frame $frame,public $vehical = null){
        $this->version=app()->version();
    }
    private function replace(string $context)
    {
        return
            Pipeline::send($context)->through([
                    fn($context, Closure $next) => $next($this->info_render($context)),
                    fn($context, Closure $next) => $next($this->main_render($context)),
                    fn($context, Closure $next) => $next($this->gun_render($context)),
                    fn($context, Closure $next) => $next($this->vehical_render($context,$this->vehical)),
                ])
                ->then(fn($context) => $context);
    }

    public function __get($name)
    {
        if ($name == 'details') {
            return $this->replace($this->frame->details ?? "");
        }
        if ($name == 'remark') {
            return $this->replace($this->frame->remark??"");
        }
    }
}
