<?php
namespace Sq\Card\Support;

use Sq\Employee\Models\CardInfo as Employee;
use Sq\Card\Support\GunCardField;
use Sq\Card\Support\InfoField;
use Sq\Card\Support\MainCardField;
use Sq\Card\Support\VehicalCardField;
use Closure;
use Illuminate\Support\Facades\Pipeline;

final class PrintCardField
{

    use GunCardField;
    use InfoField;
    use MainCardField;
    use VehicalCardField;

    public $version;

    public function __construct(private Employee $employee, private  $frame, public $vehical = null, public $gun = null,public $mainCard)
    {
        $this->version = app()->version();
    }
    private function replace(string $context)
    {
        return
            Pipeline::send($context)->through([
                fn($context, Closure $next) => $next($this->info_render(context: $context)),
                fn($context, Closure $next) => $next($this->main_render($context)),
                fn($context, Closure $next) => $next($this->gun_render($context, $this->gun)),
                fn($context, Closure $next) => $next($this->vehical_render($context, $this->vehical)),
            ])
                ->then(destination: fn($context): mixed => $context);
    }

    public function __get($name)
    {
        if ($name == 'details') {
            return $this->replace($this->frame->details ?? "");
        }
        if ($name == 'remark') {
            return $this->replace($this->frame->remark ?? "");
        }
        if ($name == 'header') {
            return $this->replace(context: $this->frame->attr['government']['title'] ?? "");
        }
    }
    public static function ltr($text)
    {
        return "<span dir='ltr'>".$text."</span>";
    }
}
