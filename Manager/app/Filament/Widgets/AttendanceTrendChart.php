<?php
    namespace App\Filament\Admin\Widgets;

    use Filament\Widgets\ChartWidget;
    use App\Models\Attendance;
    use App\Models\Presence;
    use Carbon\Carbon;

    class AttendanceTrendChart extends ChartWidget
    {
        protected static ?string $heading = 'Attendance Trend (Last 7 Days)';

        protected function getData(): array
        {
            // Get the last 7 days
            $dates = collect();
            for ($i = 6; $i >= 0; $i--) {
                $dates->push(Carbon::today()->subDays($i));
            }

            // Get the number of employees present for each day
            $data = $dates->map(function ($date) {
                return Presence::where('date', $date)
                    ->where('status', 'present')
                    ->count();
            })->toArray();

            // Format the labels as day names (e.g., Mon, Tue, etc.)
            $labels = $dates->map(function ($date) {
                return $date->format('D');
            })->toArray();

            return [
                'datasets' => [
                    [
                        'label' => 'Employees Present',
                        'data' => $data,
                        'borderColor' => '#00f', // Orange to match the theme
                        'backgroundColor' => 'rgba(249, 115, 22, 0.2)',
                        'fill' => true,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        protected function getType(): string
        {
            return 'line'; // Use a line chart
        }
}
