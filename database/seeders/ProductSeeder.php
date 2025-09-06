<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing products first
        Product::query()->delete();

        Product::create([
            'name' => 'Check Now HIV Self Test',
            'short_description' => 'ชุดตรวจ HIV ยี่ห้อ Check Now มาตรฐานสากล',
            'price' => 180,
            'description' => 'ชุดตรวจ HIV ด้วยตนเองยี่ห้อ Check Now จาก Abbott ได้รับการรับรองจาก FDA และ WHO ความแม่นยำสูงถึง 99.9% ใช้งานง่าย ผลออกภายใน 15 นาที มีคำแนะนำการใช้งานภาษาไทยครบถ้วน',
            'is_free_available' => true,
            'is_active' => true
        ]);
        
        Product::create([
            'name' => 'ชุดตรวจ HIV Oral Test',
            'short_description' => 'ชุดตรวจ HIV ด้วยน้ำลาย ใช้งานง่าย ผลแม่นยำ',
            'price' => 250,
            'description' => 'ชุดตรวจ HIV ด้วยตนเองแบบ Oral Test ใช้น้ำลายในการตรวจ ไม่ต้องเจาะเลือด ความแม่นยำสูง ผลออกภายใน 20 นาที สะดวกและปลอดภัย เหมาะสำหรับผู้ที่ต้องการความเป็นส่วนตัว',
            'is_free_available' => false,
            'is_active' => true
        ]);
    }
}
