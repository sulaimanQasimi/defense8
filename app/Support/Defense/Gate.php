<?php

namespace App\Support\Defense;

use App\Models\User;

class Gate
{

    public $mainGate;
    public function __construct(public User $user)
    {

    }

    public function gate_permission()
    {
        $gate = [];
        if ($this->user->hasPermissionTo(GatePermissionEumn::Kalid)) {
            $gate[GateEumn::Kalid] = ['label' => __(GateTranslationEnum::Kalid)];
        }
        if ($this->user->hasPermissionTo(GatePermissionEumn::Obaeda)) {
            $gate[GateEumn::Obaeda] = ['label' => __(GateTranslationEnum::Obaeda)];
        }
        if ($this->user->hasPermissionTo(GatePermissionEumn::SideWalk)) {
            $gate[GateEumn::SideWalk] = ['label' => __(GateTranslationEnum::SideWalk)];
        }
        if ($this->user->hasPermissionTo(GatePermissionEumn::Exit )) {
            $gate[GateEumn::Exit] = ['label' => __(GateTranslationEnum::Exit )];
        }
        if ($this->user->hasPermissionTo(GatePermissionEumn::All)) {
            $gate[GateEumn::All] = ['label' => __(GateTranslationEnum::All)];
        }
        return $gate;
    }
    public static function gate_options()
    {
        $gate = new static(auth()->user());
        return $gate->gate_permission();
    }
    public static function key_value_filter_options()
    {
        $gate = [];
        $gate[GateEumn::Kalid] = __(GateTranslationEnum::Kalid);
        $gate[GateEumn::Obaeda] = __(GateTranslationEnum::Obaeda);
        $gate[GateEumn::SideWalk] = __(GateTranslationEnum::SideWalk);
        $gate[GateEumn::Exit] = __(GateTranslationEnum::Exit );
        $gate[GateEumn::All] = __(GateTranslationEnum::All);
        return $gate;
    }
}
