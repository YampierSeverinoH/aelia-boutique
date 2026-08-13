<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Banner;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ContentModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Banners
        Banner::create([
            'nombre' => 'Banner Principal Primavera / Verano',
            'titulo' => 'Nueva Colección Aelia 2026',
            'imagen' => 'banners/hero-spring.jpg',
            'descripcion' => 'Descubre piezas exclusivas diseñadas con la máxima elegancia y confort.',
        ]);

        // 2. Seed Nosotros (About)
        About::create([
            'trayectoria' => '<p>Aelia Boutique nació con la visión de transformar la moda femenina en Perú, uniendo diseño exclusivo, acabados de alta costura y materiales de la más alta calidad.</p>',
            'anios' => '8+',
            'patentes' => '15+',
            'paises' => '3',
            'imagen_1' => 'about/about-1.jpg',
            'imagen_2' => 'about/about-2.jpg',
            'imagen_3' => 'about/about-3.jpg',
            'imagen_4' => 'about/about-4.jpg',
            'mision' => 'Empoderar a la mujer contemporánea brindándole prendas de vestir sofisticadas que transmitan confianza y elegancia atemporal.',
            'vision' => 'Consolidarnos como la boutique referente de moda alta gama y experiencia de compra personalizada en la región.',
            'valores' => 'Excelencia en confección, atención al detalle, sostenibilidad y pasión por el diseño boutique.',
            'imagen_talento' => 'about/team.jpg',
            'titulo_talento' => 'Nuestro Equipo Creativo',
            'descripcion_talento' => 'Diseñadoras, patronistas y estilistas apasionadas por crear prendas con personalidad propia.',
            'subtitulo_1' => 'Confección Artesanal',
            'subtitulo_1_descripcion' => 'Cada pieza es supervisada minuciosamente para garantizar costuras perfectas y caídas impecables.',
            'subtitulo_2' => 'Materiales de Selección',
            'subtitulo_2_descripcion' => 'Utilizamos sedas, linos y algodones pima peruanos de la más alta exigencia.',
        ]);

        // 3. Seed Empresa (Company)
        Company::create([
            'logo' => 'company/logo-aelia.png',
            'descripcion' => 'Boutique de moda femenina dedicada al diseño exclusivo y piezas de edición limitada.',
            'ruc' => '20601234567',
            'direccion' => 'Av. Conquistadores 789, San Isidro, Lima - Perú',
            'telefono' => '+51 987 654 321',
            'correo' => 'contacto@aeliaboutique.pe',
            'correo_notificaciones' => 'pedidos@aeliaboutique.pe',
            'ubicacion' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.45!2d-77.03!3d-12.09!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTLCsDA1JzI0LjAiUyA3N8KwMDEnNDggLjAiVw!5e0!3m2!1ses!2spe!4v1600000000000!5m2!1ses!2spe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'horario' => 'Lunes a Sábado: 10:00 AM - 8:00 PM',
            'terminos_condiciones' => '<h2>Términos y Condiciones de Uso</h2><p>Bienvenido a Aelia Boutique. Al realizar compras en nuestra plataforma web aceptas las siguientes condiciones comerciales...</p>',
            'politicas_privacidad' => '<h2>Política de Privacidad de Datos</h2><p>En Aelia Boutique garantizamos la confidencialidad y protección de tus datos personales conforme a la Ley N° 29733...</p>',
            'mensaje_cinta' => '✨ Aelia Boutique - Elegancia Sin Esfuerzo ✨',
            'link_facebook' => 'https://facebook.com/aeliaboutique',
            'link_instagram' => 'https://instagram.com/aeliaboutique',
            'link_tiktok' => 'https://tiktok.com/@aeliaboutique',
            'link_youtube' => 'https://youtube.com/@aeliaboutique',
            'link_linkedin' => 'https://linkedin.com/company/aelia-boutique',
        ]);
    }
}
