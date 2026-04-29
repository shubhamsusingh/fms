<?php
namespace Database\Seeders;
use App\Models\FeeStructure;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create(['name'=>'Admin','email'=>'admin@college.edu','password'=>Hash::make('admin123'),'role'=>'admin']);
        $u = User::create(['name'=>'Rahul Sharma','email'=>'student@college.edu','password'=>Hash::make('student123'),'role'=>'student']);
        Student::create(['user_id'=>$u->id,'enrollment_no'=>'BTech-CSE-2022-001','course'=>'B.Tech','branch'=>'CSE','semester'=>5,'batch'=>'2022-2026','phone'=>'9876543210']);
        $fees = [
            ['course'=>'B.Tech','branch'=>'CSE','semester'=>5,'tuition_fee'=>45000],
            ['course'=>'B.Tech','branch'=>'ECE','semester'=>5,'tuition_fee'=>44000],
            ['course'=>'B.Tech','branch'=>'ME', 'semester'=>5,'tuition_fee'=>42000],
            ['course'=>'MCA',   'branch'=>'MCA','semester'=>3,'tuition_fee'=>38000],
            ['course'=>'BCA',   'branch'=>'BCA','semester'=>3,'tuition_fee'=>28000],
        ];
        foreach ($fees as $f) {
            FeeStructure::create(array_merge($f, ['academic_year'=>'2024-25','exam_fee'=>2000,'library_fee'=>1000,'lab_fee'=>3000,'hostel_fee'=>0,'other_fee'=>500,'due_date'=>'2025-09-30']));
        }
    }
}
