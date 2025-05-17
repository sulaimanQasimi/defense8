<?php

namespace Sq\Guest\Policies;

use App\Models\User;
use Sq\Guest\Models\PatientGatePass;

class PatientGatePassPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasRole('super-admin');
    }
    public function view(User $user, PatientGatePass $patientGatePass)
    {
        return false;
    }
    public function create(User $user)
    {
        return false;
    }
    public function update(User $user, PatientGatePass $patientGatePass)
    {
        return false;
    }
    public function delete(User $user, PatientGatePass $patientGatePass)
    {
        return false;
    }
    public function restore(User $user, PatientGatePass $patientGatePass)
    {
        return false;
    }
    public function forceDelete(User $user, PatientGatePass $patientGatePass)
    {
        return false;
    }
}
