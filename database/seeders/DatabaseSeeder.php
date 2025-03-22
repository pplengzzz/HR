<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HrEmployee;
use App\Models\HrPerformance;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminUserSeeder::class,
        ]);

        // สร้างข้อมูลพนักงานทดสอบ
        $departments = ['ธุรกิจ', 'ไอที', 'การค้า', 'การเงิน', 'เทคนิค', 'HR'];
        $titles = ['ผู้จัดการ', 'พนักงาน', 'หัวหน้าทีม', 'ที่ปรึกษา'];
        $divisions = ['Sales', 'IT', 'Finance', 'HR'];

        // สร้างข้อมูลพนักงาน 50 คน
        for ($i = 1; $i <= 50; $i++) {
            $employeeId = 'EMP' . str_pad($i, 5, '0', STR_PAD_LEFT);
            
            $employee = HrEmployee::create([
                'EmployeeID' => $employeeId,
                'StartDate' => now()->subDays(rand(1, 365))->format('Y-m-d'),
                'Title' => $titles[array_rand($titles)],
                'BusinessUnit' => 'Main Office',
                'EmployeeStatus' => rand(0, 10) > 2 ? 'Active' : 'Inactive',
                'EmployeeType' => 'Full Time',
                'PayZone' => 'Zone A',
                'EmployeeClassificationType' => 'Regular',
                'DepartmentType' => $departments[array_rand($departments)],
                'Division' => $divisions[array_rand($divisions)],
                'DOB' => now()->subYears(rand(25, 55))->format('Y-m-d'),
                'State' => 'BKK',
                'GenderCode' => rand(0, 1) ? 'M' : 'F',
                'RaceDesc' => 'Asian',
                'MaritalDesc' => rand(0, 1) ? 'Single' : 'Married',
                'Age' => rand(25, 55)
            ]);

            // สร้างข้อมูล Performance
            HrPerformance::create([
                'EmployeeID' => $employeeId,
                'PerformanceScore' => ['Outstanding', 'Good', 'Average', 'Poor'][array_rand(['Outstanding', 'Good', 'Average', 'Poor'])],
                'CurrentEmployeeRating' => rand(1, 5),
                'EngagementScore' => rand(1, 5),
                'SatisfactionScore' => rand(1, 5),
                'WorkLifeBalanceScore' => rand(1, 5)
            ]);
        }
    }
}
