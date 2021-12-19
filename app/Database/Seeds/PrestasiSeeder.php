<?php

namespace App\Database\Seeds;

use App\Models\PrestasiModel;
use Carbon\Carbon;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PrestasiSeeder extends Seeder
{
    protected $prestasi;

    public function __construct()
    {
        $this->prestasi = new PrestasiModel();    
    }
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $kategori = ["siswa", "guru", "pegawai"];
        $tingkat = ["kec", "kab", "prov", "nas", "kota", "inter", "antar_sekolah"];

        for ($i=0; $i < 10; $i++) { 
            $timestamp = $faker->dateTimeBetween(Time::now()->subMonths(5), Time::now()->subDays(10))->format('Y-m-d H:i:s');

            $paragraphs = $faker->paragraphs(rand(10, 15));
            $title = $faker->realText(50);
            $post = "<h1>{$title}</h1>";
            foreach ($paragraphs as $para) {
                $post .= "<p>{$para}</p>";
            }

            $prestasi = [
                'nama' => $faker->name(),
                'kategori' => $kategori[rand(0,2)],
                'tingkat' => $tingkat[rand(0,6)],
                'deskripsi' => $faker->sentence(3),
                'konten' => $post,
                'thumbnail' => 'default/prestasi'.rand(1,6).'.jpg',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];

            $this->prestasi->insertData($prestasi);
        }
    }
}
