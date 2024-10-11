<?php
namespace Sq\Employee\Models\Contracts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Sq\Employee\Models\Attendance;
trait AttendanceRelationship
{

    public function current_gate_attendance(): HasOne
    {
        return $this->hasOne(related: Attendance::class)->where(column: 'date', operator: now()->format(format: 'Y-m-d'));
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    // Today Attendance
    public function today_attendance()
    {
        return $this->hasOne(Attendance::class)
        ->ofMany(column: [
            'id' => 'max'
        ], aggregate: function (Builder $query) {
            $query->whereDate('date', now());
        });
    }


    // Employee Entered to Ministry
    public function today_attendance_present_not_exit()
    {
        return $this->hasOne(Attendance::class)
            ->ofMany(column: [
                'id' => 'max'
            ], aggregate: function (Builder $query) {
                $query->whereDate('date', now())
                    ->whereNotNull('enter')
                    ->whereNull('exit');
            });
    }

    // Employee Entered to Ministry
    public function today_attendance_present_exit()
    {
        return $this->hasOne(Attendance::class)
            ->ofMany(column: [
                'id' => 'max'
            ], aggregate: function (Builder $query) {
                $query->whereDate('date', now())
                    ->whereNotNull('enter')
                    ->whereNotNull('exit');
            });
    }// Employee Entered to Ministry
    public function today_attendance_not_present_exit()
    {
        return $this->hasOne(Attendance::class)
            ->ofMany(column: [
                'id' => 'max'
            ], aggregate: function (Builder $query) {
                $query->whereDate('date', now())
                    ->whereNull('enter')
                    ->whereNull('exit');
            });
    }
}
