<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Presence;
use Carbon\Carbon;

class ScanBadge extends Page
{
    protected static string $view = 'filament.pages.scan-badge';

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationLabel = 'Scan Badge';

    public $employee = null;
    public $message = '';

    public function mount()
    {
        $this->employee = null;
        $this->message = '';
    }

    public function processScan($employeeCode)
    {
        // Find the employee by employee_code
        $this->employee = User::where('employee_code', $employeeCode)
            ->where('role', 'employee')
            ->first();

        if (!$this->employee) {
            $this->message = 'Employee not found.';
            $this->employee = null;
            return;
        }

        $today = Carbon::today();
        $presence = Presence::where('user_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        // Check if the employee is on approved leave
        $onLeave = $this->employee->conges()
            ->where('status', 'approuve')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->exists();

        if ($onLeave) {
            $this->message = 'Employee is on approved leave and cannot check in.';
            if (!$presence) {
                Presence::create([
                    'user_id' => $this->employee->id,
                    'date' => $today,
                    'status' => 'on_leave',
                ]);
            } else {
                $presence->update(['status' => 'on_leave']);
            }
            return;
        }

        // Determine if this scan is a check-in or check-out
        if (!$presence || !$presence->check_in) {
            // Check-in
            $checkInTime = Carbon::now();
            $status = $checkInTime->hour >= 9 ? 'present' : 'present';

            if ($presence) {
                $presence->update([
                    'check_in' => $checkInTime,
                    'status' => $status,
                ]);
            } else {
                Presence::create([
                    'user_id' => $this->employee->id,
                    'date' => $today,
                    'check_in' => $checkInTime,
                    'status' => $status,
                ]);
            }

            $this->message = 'Check-in recorded for ' . $this->employee->name . ' at ' . $checkInTime->format('H:i') . '.';
        } elseif (!$presence->check_out) {
            // Check-out
            $checkOutTime = Carbon::now();
            $presence->update([
                'check_out' => $checkOutTime,
            ]);

            $this->message = 'Check-out recorded for ' . $this->employee->name . ' at ' . $checkOutTime->format('H:i') . '.';
        } else {
            $this->message = 'Employee has already checked in and out today.';
        }
    }

    public function resetScanner()
    {
        $this->employee = null;
        $this->message = '';
        $this->dispatch('reset-scanner');
    }
}
