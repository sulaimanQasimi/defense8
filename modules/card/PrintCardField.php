<?php
namespace Card;

use App\Models\Card\CardInfo as Employee;
use App\Models\PrintCardFrame as Frame;
use Card\Contracts\GunCardField;
use Card\Contracts\InfoField;
use Card\Contracts\MainCardField;
use Closure;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;

final class PrintCardField
{

    use GunCardField;
    use InfoField;
    use MainCardField;
    public function __construct(private Employee $employee, private Frame $frame)
    {

    }
    private function replace(string $context)
    {
        return
            Pipeline::send($context)->through(
                [
                    fn($context, Closure $next) => $next($this->info_render($context)),
                    fn($context, Closure $next) => $next($this->main_render($context)),
                    fn($context, Closure $next) => $next($this->gun_render($context)),
                ]
            )
                ->then(fn($context) => $context);
    }

    public function __get($name)
    {
        if ($name == 'details') {
            return $this->replace($this->frame->details);
        }
        if ($name == 'remark') {
            return $this->replace($this->frame->remark);
        }
    }
}
