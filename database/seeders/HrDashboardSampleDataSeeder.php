<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Project;
use App\Models\Worker;
use App\Models\WorkerAdvance;
use App\Services\PayrollService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HrDashboardSampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();
        $firstAttendanceDate = Carbon::now()->startOfMonth();
        $attendanceDates = collect();

        while ($firstAttendanceDate->lte($today) && $attendanceDates->count() < 3) {
            if ($firstAttendanceDate->isWeekday()) {
                $attendanceDates->push($firstAttendanceDate->copy());
            }

            $firstAttendanceDate->addDay();
        }

        if ($attendanceDates->isEmpty()) {
            $attendanceDates->push($today);
        }

        $dailyWorker = Worker::firstOrCreate(
            ['email' => 'demo.site.engineer@example.test'],
            [
                'name' => 'Demo HR - Site Engineer',
                'phone' => '0000000001',
                'department' => 'Construction',
                'designation' => 'Site Engineer',
                'date_of_joining' => $today->copy()->subMonths(3)->toDateString(),
                'status' => 'active',
                'rate_type' => 'daily',
                'rate' => 1200,
                'medical_issue_date' => $today->copy()->subMonths(2)->toDateString(),
                'medical_expiry_date' => $today->copy()->addDays(15)->toDateString(),
            ]
        );

        $hourlyWorker = Worker::firstOrCreate(
            ['email' => 'demo.electrician@example.test'],
            [
                'name' => 'Demo HR - Electrician',
                'phone' => '0000000002',
                'department' => 'Electrical',
                'designation' => 'Electrician',
                'date_of_joining' => $today->copy()->subMonths(2)->toDateString(),
                'status' => 'active',
                'rate_type' => 'hourly',
                'rate' => 150,
                'medical_issue_date' => $today->copy()->subMonth()->toDateString(),
                'medical_expiry_date' => $today->copy()->addYear()->toDateString(),
            ]
        );

        $ongoingProject = Project::firstOrCreate(
            ['project_code' => 'DEMO-HR-001'],
            [
                'name' => 'Demo HR - Riverside Office Fit-out',
                'client_name' => 'Demo Client One',
                'client_phone' => '0000000101',
                'client_email' => 'client.one@example.test',
                'location' => 'Demo Site A',
                'description' => 'Sample project for checking HR modules.',
                'contract_value' => 250000,
                'estimated_cost' => 190000,
                'start_date' => $today->copy()->subMonth()->toDateString(),
                'end_date' => $today->copy()->addMonths(5)->toDateString(),
                'status' => 'ongoing',
            ]
        );

        $planningProject = Project::firstOrCreate(
            ['project_code' => 'DEMO-HR-002'],
            [
                'name' => 'Demo HR - Community Clinic Extension',
                'client_name' => 'Demo Client Two',
                'client_phone' => '0000000102',
                'client_email' => 'client.two@example.test',
                'location' => 'Demo Site B',
                'description' => 'Sample planning project for HR module checks.',
                'contract_value' => 180000,
                'estimated_cost' => 140000,
                'start_date' => $today->copy()->addMonth()->toDateString(),
                'end_date' => $today->copy()->addMonths(7)->toDateString(),
                'status' => 'planning',
            ]
        );

        $this->assignWorker($dailyWorker, $ongoingProject, $today);
        $this->assignWorker($hourlyWorker, $planningProject, $today);

        foreach ($attendanceDates as $index => $date) {
            $dailyStatus = ['present', 'half_day', 'absent'][$index] ?? 'present';
            $dailyHours = ['present' => 9, 'half_day' => 4.5, 'absent' => 0][$dailyStatus];
            $this->recordAttendance(
                $dailyWorker,
                $ongoingProject,
                $date,
                $dailyStatus,
                $dailyHours,
                0,
                'daily',
                $dailyStatus === 'absent' ? 0 : ($dailyStatus === 'half_day' ? 4.5 : 9)
            );

            $hourlyHours = $index === 2 ? 10 : 8;
            $overtimeHours = $index === 2 ? 1 : 0;
            $this->recordAttendance(
                $hourlyWorker,
                $planningProject,
                $date,
                'present',
                $hourlyHours,
                $overtimeHours,
                'hourly',
                $hourlyHours
            );
        }

        $this->recordAdvance($dailyWorker, 600, 'pending', $today->copy()->subDays(2));
        $this->recordAdvance($hourlyWorker, 250, 'paid', $today->copy()->subDays(5));

        $batch = app(PayrollService::class)->generateSingleWorkerPayrollWithAdvanceDeduction(
            $dailyWorker,
            $today->year,
            $today->month,
            1.5,
            [
                'notes' => 'Demo HR sample payroll',
                'deduct_advance' => false,
                'manual_adjustment' => 0,
            ]
        );

        $this->command?->info(sprintf(
            'HR demo data ready: 2 workers, 2 projects, %d attendance records, 2 advances, payroll batch #%d.',
            $attendanceDates->count() * 2,
            $batch->id
        ));
    }

    private function assignWorker(Worker $worker, Project $project, Carbon $date): void
    {
        if (!$worker->projects()->where('projects.id', $project->id)->exists()) {
            $worker->projects()->attach($project->id, [
                'assigned_date' => $date->toDateString(),
                'status' => 'active',
            ]);
        }
    }

    private function recordAttendance(
        Worker $worker,
        Project $project,
        Carbon $date,
        string $status,
        float $hours,
        float $overtime,
        string $billingType,
        float $clientHours
    ): void {
        Attendance::firstOrCreate(
            [
                'worker_id' => $worker->id,
                'project_id' => $project->id,
                'date' => $date->toDateString(),
            ],
            [
                'check_in' => $status === 'absent' ? null : '08:00:00',
                'check_out' => $status === 'absent' ? null : ($hours > 9 ? '18:00:00' : '17:00:00'),
                'hours_worked' => $hours,
                'overtime_hours' => $overtime,
                'status' => $status,
                'client_billing_type' => $billingType,
                'client_hours' => $clientHours,
                'notes' => 'Demo HR sample attendance',
                'payroll_generated' => false,
            ]
        );
    }

    private function recordAdvance(Worker $worker, float $amount, string $status, Carbon $date): void
    {
        $exists = WorkerAdvance::where('worker_id', $worker->id)
            ->where('notes', 'Demo HR sample advance')
            ->exists();

        if (!$exists) {
            WorkerAdvance::create([
                'worker_id' => $worker->id,
                'amount' => $amount,
                'is_deduction' => false,
                'remaining_amount' => $status === 'pending' ? $amount : 0,
                'running_balance' => $status === 'pending' ? $amount : 0,
                'advance_date' => $date->toDateString(),
                'notes' => 'Demo HR sample advance',
                'status' => $status,
            ]);
        }
    }
}
