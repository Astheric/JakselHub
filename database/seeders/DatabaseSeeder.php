<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SmartCityMetric;
use App\Models\Destination;
use App\Models\Timeline;
use App\Models\CultureGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Administrator User
        User::create([
            'name' => 'Admin Jaksel Hub',
            'email' => 'admin@jakselhub.go.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Seed Default User for testing
        User::create([
            'name' => 'Turis Lokal',
            'email' => 'turis@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // 3. Seed Smart City Metrics
        SmartCityMetric::create([
            'aqi' => 45, // Good quality (0-50)
            'green_spaces_count' => 156, // Taman & Hutan Kota
            'public_transport_count' => 38, // MRT, LRT, TransJakarta routes
        ]);

        // 4. Seed Destinations
        $destinations = [
            [
                'name' => 'Taman Langsat',
                'description' => 'Taman rindang yang luas dengan pepohonan rindang, danau teratai kecil, trek lari, tempat bermain anak-anak, & habitat burung liar. Oase ketenangan di tengah hiruk-pikuk kota Jakarta Selatan.',
                'category' => 'Ruang Terbuka Hijau',
                'address' => 'Jl. Langsat No.1, Kramat Pela, Kec. Kebayoran Baru, Kota Jakarta Selatan',
                'latitude' => -6.244302,
                'longitude' => 106.793739,
                'mrt_integrated' => true, // Dekat Stasiun MRT Blok M BCA
                'walkable' => true,
                'image_path' => null,
            ],
            [
                'name' => 'Taman Ayodia',
                'description' => 'Taman kota dengan kolam buatan seluas 1.500 meter persegi di tengahnya. Menawarkan suasana santai dengan bangku taman, air mancur, lampu hias gantung, dan rute pejalan kaki yang ramah lingkungan.',
                'category' => 'Ruang Terbuka Hijau',
                'address' => 'Jl. Lamandau III, Kramat Pela, Kec. Kebayoran Baru, Kota Jakarta Selatan',
                'latitude' => -6.244973,
                'longitude' => 106.791244,
                'mrt_integrated' => true,
                'walkable' => true,
                'image_path' => null,
            ],
            [
                'name' => 'Perkampungan Budaya Betawi Setu Babakan',
                'description' => 'Pusat pelestarian dan pengembangan budaya Betawi. Pengunjung dapat menikmati danau alami, rumah adat khas Betawi, pertunjukan kesenian tradisional, dan mencicipi kuliner khas seperti kerak telor dan bir pletok.',
                'category' => 'Heritage',
                'address' => 'Jl. RM. Kahfi II, Srengseng Sawah, Kec. Jagakarsa, Kota Jakarta Selatan',
                'latitude' => -6.342131,
                'longitude' => 106.822839,
                'mrt_integrated' => false,
                'walkable' => true,
                'image_path' => null,
            ],
            [
                'name' => 'Senopati Culinary Hub',
                'description' => 'Kawasan kuliner hits dan premium yang menjadi pusat cafe-hopping anak muda Jaksel. Menampilkan jejeran restoran estetis, artisan bakery, coffee shop bernuansa industrial, hingga pusat hiburan kreatif.',
                'category' => 'Aesthetic Cafe',
                'address' => 'Jl. Senopati, Selong, Kec. Kebayoran Baru, Kota Jakarta Selatan',
                'latitude' => -6.223846,
                'longitude' => 106.808757,
                'mrt_integrated' => true, // Dekat Stasiun MRT Senayan
                'walkable' => true,
                'image_path' => null,
            ],
            [
                'name' => 'Soto Betawi H. Husein',
                'description' => 'Kuliner legendaris Jakarta Selatan yang menyajikan hidangan soto daging sapi khas Betawi dengan kuah santan berempah kuning pucat gurih alami yang melegenda sejak tahun 1964.',
                'category' => 'Heritage',
                'address' => 'Jl. Padang Panjang No. 4C, Kec. Tebet, Kota Jakarta Selatan',
                'latitude' => -6.216390,
                'longitude' => 106.840250,
                'mrt_integrated' => false,
                'walkable' => false,
                'image_path' => null,
            ],
            [
                'name' => 'Kemang Creative Area',
                'description' => 'Pusat berkumpulnya galeri seni, co-working space, dan kafe berarsitektur tropis modern. Destinasi populer bagi ekspatriat dan komunitas industri kreatif lokal untuk berjejaring dan berkarya.',
                'category' => 'Aesthetic Cafe',
                'address' => 'Jl. Kemang Raya, Bangka, Kec. Mampang Prapatan, Kota Jakarta Selatan',
                'latitude' => -6.255531,
                'longitude' => 106.815239,
                'mrt_integrated' => false,
                'walkable' => true,
                'image_path' => null,
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::create($dest);
        }

        // 5. Seed Timelines
        $timelines = [
            [
                'year' => '1970-an',
                'title' => 'Paru-Paru Kota & Wilayah Resapan Air',
                'description' => 'Jakarta Selatan dikukuhkan sebagai kawasan hijau pelestarian lingkungan dan resapan air alami Jakarta. Wilayah Kebayoran Baru didominasi pepohonan rindang dan kebun Betawi tradisional.',
                'order' => 1,
                'image_path' => null,
            ],
            [
                'year' => '1990-an',
                'title' => 'Urbanisasi & Pusat Kreatif Muda',
                'description' => 'Modernisasi melanda kawasan Kemang yang mulai bertransformasi menjadi pusat kuliner dan seni bertaraf internasional, menarik minat komunitas pemuda kreatif dan ekspatriat.',
                'order' => 2,
                'image_path' => null,
            ],
            [
                'year' => '2010-an',
                'title' => 'Metropolis Finansial & Megastruktur SCBD',
                'description' => 'Pembangunan Sudirman Central Business District (SCBD) memantapkan peran Jakarta Selatan sebagai episentrum finansial modern. Gedung pencakar langit berpadu dengan inisiatif efisiensi energi hijau.',
                'order' => 3,
                'image_path' => null,
            ],
            [
                'year' => '2026',
                'title' => 'Nusantara Digital City: Jakarta Selatan Terintegrasi',
                'description' => 'Era modern integrasi transportasi massal (MRT & TransJakarta) beremisi rendah, revitalisasi ruang terbuka hijau digital, dan harmoni budaya Betawi Setu Babakan yang lestari berbasis teknologi.',
                'order' => 4,
                'image_path' => null,
            ],
        ];

        foreach ($timelines as $time) {
            Timeline::create($time);
        }

        // 6. Seed Culture Galleries
        $galleries = [
            [
                'title' => 'Kesenian Ondel-Ondel Raksasa',
                'description' => 'Boneka khas kebudayaan Betawi yang memiliki tinggi sekitar 2,5 meter dan melambangkan pelindung desa. Hingga kini, kesenian Ondel-ondel menjadi ikon kemeriahan festival-festival kreatif anak muda Jakarta Selatan.',
                'category' => 'Kesenian',
                'image_path' => null,
            ],
            [
                'title' => 'Festival Lebaran Betawi Setu Babakan',
                'description' => 'Perayaan tahunan budaya pasca-Lebaran yang diadakan di Perkampungan Budaya Betawi Setu Babakan. Diisi dengan pagelaran musik gambang kromong, prosesi hantaran antarkecamatan, dan kompetisi silat tradisional.',
                'category' => 'Festival',
                'image_path' => null,
            ],
            [
                'title' => 'Workshop Kuliner Tradisional Kerak Telor',
                'description' => 'Event edukasi rutin yang diadakan untuk generasi muda di Setu Babakan, mengajarkan tata cara memasak hidangan kerak telor tradisional menggunakan wajan tanah liat dan anglo arang kelapa.',
                'category' => 'Event',
                'image_path' => null,
            ],
        ];

        foreach ($galleries as $gal) {
            CultureGallery::create($gal);
        }
    }
}
