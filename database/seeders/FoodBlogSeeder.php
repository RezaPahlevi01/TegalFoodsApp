<?php

namespace Database\Seeders;

use App\Models\FoodBlog;
use Illuminate\Database\Seeder;

class FoodBlogSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Kupat Glabed, Ikon Sarapan Khas Kota Tegal',
                'slug' => 'kupat-glabed-ikon-sarapan-khas-kota-tegal',
                'content' => "Kupat Glabed merupakan salah satu kuliner paling ikonik dari Kota Tegal. Hidangan ini terdiri dari ketupat yang dipotong kecil lalu disiram kuah kuning kental yang gurih, kemudian disajikan bersama suwiran ayam, kerupuk mie kuning, dan sambal. Kata glabed merujuk pada tekstur kuahnya yang kental dan lembut.\n\nBagi masyarakat Tegal, Kupat Glabed bukan sekadar makanan, tetapi juga bagian dari tradisi sarapan pagi. Rasanya ringan namun tetap mengenyangkan, dengan perpaduan rempah yang khas. Wisatawan yang datang ke Tegal hampir selalu mencari menu ini karena rasanya berbeda dari ketupat sayur di daerah lain.",
                'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Sate Blengong, Perpaduan Unik yang Jadi Kebanggaan Tegal',
                'slug' => 'sate-blengong-perpaduan-unik-yang-jadi-kebanggaan-tegal',
                'content' => "Sate Blengong adalah kuliner khas Tegal yang dibuat dari daging blengong, yaitu hasil persilangan bebek dan mentok. Tekstur dagingnya lebih padat dari ayam, tetapi tetap empuk jika dimasak dengan tepat. Sate ini biasanya dibumbui kecap, bawang merah, cabai, dan rempah sederhana yang menonjolkan rasa asli dagingnya.\n\nKeunikan Sate Blengong terletak pada rasa gurih yang lebih kuat dan aroma panggang yang khas. Kuliner ini sering menjadi pilihan wisatawan yang ingin mencoba sesuatu yang tidak mudah ditemukan di kota lain. Disajikan dengan lontong atau nasi hangat, sate ini sangat cocok dinikmati pada sore hingga malam hari.",
                'image' => 'https://images.unsplash.com/photo-1529563021893-cc83c992d75d?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Tahu Aci Tegal, Camilan Sederhana dengan Rasa Juara',
                'slug' => 'tahu-aci-tegal-camilan-sederhana-dengan-rasa-juara',
                'content' => "Tahu Aci adalah camilan khas Tegal yang sangat populer karena sederhana tetapi punya rasa yang kuat. Makanan ini dibuat dari tahu pong yang dibelah lalu diisi adonan aci berbumbu. Setelah itu tahu digoreng hingga bagian luar renyah sementara bagian isi tetap kenyal.\n\nBiasanya Tahu Aci dinikmati saat masih hangat bersama cabai rawit hijau atau sambal petis. Karena praktis dan mudah dibawa, camilan ini juga sering dijadikan oleh-oleh khas Tegal. Bagi banyak orang, Tahu Aci menjadi bukti bahwa makanan sederhana pun bisa meninggalkan kesan yang kuat.",
                'image' => 'https://images.unsplash.com/photo-1518779578993-ec3579fee39f?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Nasi Ponggol, Menu Praktis Favorit Warga Tegal',
                'slug' => 'nasi-ponggol-menu-praktis-favorit-warga-tegal',
                'content' => "Nasi Ponggol adalah makanan khas Tegal yang terkenal praktis, murah, dan mengenyangkan. Nasi ini dibungkus daun pisang dalam porsi kecil, lalu diisi lauk seperti oseng tempe, mie, sambal goreng, atau ikan. Meski tampil sederhana, kombinasi rasa gurih dan pedasnya sangat akrab di lidah masyarakat setempat.\n\nNasi Ponggol sering dijadikan bekal kerja, sarapan, hingga teman perjalanan. Bungkus kecilnya membuat makanan ini mudah dibawa dan dinikmati kapan saja. Kuliner ini menjadi contoh bagaimana budaya makan masyarakat Tegal sangat dekat dengan konsep praktis namun tetap lezat.",
                'image' => 'https://images.unsplash.com/photo-1505253758473-96b7015fcd40?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Rujak Teplak, Rasa Pedas Gurih yang Sulit Dilupakan',
                'slug' => 'rujak-teplak-rasa-pedas-gurih-yang-sulit-dilupakan',
                'content' => "Rujak Teplak merupakan salah satu kuliner tradisional Tegal yang punya karakter rasa kuat. Isinya terdiri dari berbagai sayuran rebus seperti kangkung, daun singkong, tauge, dan ketupat, lalu disiram sambal kacang pedas yang biasanya dibuat dengan tambahan singkong atau bahan lain sehingga teksturnya khas.\n\nBerbeda dari rujak pada umumnya yang cenderung manis segar, Rujak Teplak justru dikenal gurih, pedas, dan sedikit earthy. Hidangan ini populer di kalangan warga lokal karena murah, sehat, dan mengenyangkan. Rasanya yang unik membuat banyak orang langsung mengenalinya sebagai salah satu identitas kuliner Tegal.",
                'image' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
            ],
        ];

        foreach ($articles as $article) {
            FoodBlog::updateOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }
}
