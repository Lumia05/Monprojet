<?php

namespace App\Filament\Widgets;

use App\Models\Presence;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeesOverview extends BaseWidget
{
    protected function getStats(): array
    { 
        $totalEmployees = User::where('role', 'employee')->count();

        // Employees Present Today
        $today = Carbon::today();
        $presentToday = Presence::where('date', $today)
            ->where('status', 'present')
            ->count();

        $absentToday = $totalEmployees - $presentToday;   

        return [
            Stat::make('Total Employees', $totalEmployees)
                ->description('Number of registered employees')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Present Today', $presentToday)
                ->description('Employees who checked in today')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Absent Today', $absentToday)
                ->description('Employees absent today')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
