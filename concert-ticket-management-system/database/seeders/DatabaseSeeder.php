<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Event;
use App\Models\TicketCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [];
        foreach ([18, 20, 25, 30, 35, 40, 45, 50, 65] as $i => $age) {
            $users[] = User::create([
                'firstname' => ["Alice", "Bob", "Claire", "David", "Emma", "Frank", "Grace", "Henry", "Iris"][$i],
                'lastname' => ["Martin", "Dubois", "Leroy", "Moreau", "Simon", "Laurent", "Bernard", "Petit", "Robert"][$i],
                'email' => "user{$i}@example.com",
                'phone' => "+336123456" . str_pad($i, 2, '0', STR_PAD_LEFT),
                'date_of_birth' => now()->subYears($age)->format('Y-m-d'),
                'password' => Hash::make('Password123'),
            ]);
        }

        $companyData = [
            ['TechCorp Solutions', 'contact@techcorp.fr', '+33142853697', '123 Avenue des Champs-Élysées, Paris', 'FR12345678901'],
            ['Innovate Digital', 'info@innovate.fr', '+33142853698', '45 Rue de Rivoli, Paris', 'FR23456789012'],
            ['Creative Agency', 'hello@creative.fr', '+33142853699', '78 Boulevard Saint-Germain, Paris', 'FR34567890123'],
            ['StartupHub', 'team@startuphub.fr', '+33142853700', '156 Rue de la Paix, Lyon', 'FR45678901234'],
            ['EventPro Services', 'events@eventpro.fr', '+33142853701', '234 Cours Lafayette, Lyon', 'FR56789012345']
        ];

        foreach ($companyData as $data) {
            Company::create([
                'name' => $data[0],
                'email' => $data[1],
                'phone' => $data[2],
                'address' => $data[3],
                'tax_id' => $data[4]
            ]);
        }

        $ticketCategories = [];
        $categoryData = [
            ['VIP Premium', 'Accès exclusif avec meet & greet', 150.00, 50, 50, 1],
            ['VIP Standard', 'Places privilégiées et bar privé', 100.00, 100, 100, 2],
            ['Placement Numéroté', 'Places assises numérotées', 65.00, 500, 500, 3],
            ['Debout Fosse', 'Debout près de la scène', 45.00, 800, 800, 4],
            ['Debout Général', 'Debout placement libre', 35.00, 1000, 1000, 5],
            ['Étudiant', 'Tarif réduit avec justificatif', 25.00, 200, 200, 6]
        ];

        foreach ($categoryData as $data) {
            $ticketCategories[] = TicketCategory::create([
                'name' => $data[0],
                'description' => $data[1],
                'price' => $data[2],
                'max_quantity' => $data[3],
                'available_quantity' => $data[4],
                'position' => $data[5]
            ]);
        }

        $eventData = [
            [
                'name' => 'Festival Electro Summer 2024',
                'description' => 'Le plus grand festival électro de France avec David Guetta, Martin Garrix et Tiësto',
                'venu_name' => 'Stade de France',
                'venu_address' => 'Saint-Denis',
                'city' => 'Paris',
                'event_date' => '2024-07-15 20:00:00',
                'doors_open' => '2024-07-15 18:00:00',
                'sale_starts_at' => '2024-05-01 10:00:00',
                'sale_ends_at' => '2024-07-14 23:59:59',
                'min_age' => 16,
                'max_capacity' => 80000,
                'tickets_sold' => 75000,
                'status' => 'sold_out',
                'image_url' => 'https://example.com/electro-summer.jpg',
                'ticket_category_id' => $ticketCategories[2]->id
            ],
            [
                'name' => 'Concert Classique - Orchestre de Paris',
                'description' => 'Soirée exceptionnelle avec l\'Orchestre de Paris dirigé par Klaus Mäkelä',
                'venu_name' => 'Philharmonie de Paris',
                'venu_address' => '221 Avenue Jean Jaurès',
                'city' => 'Paris',
                'event_date' => '2024-12-20 19:30:00',
                'doors_open' => '2024-12-20 18:30:00',
                'sale_starts_at' => '2024-10-01 09:00:00',
                'sale_ends_at' => '2024-12-19 18:00:00',
                'min_age' => 0,
                'max_capacity' => 2400,
                'tickets_sold' => 2400,
                'status' => 'sold_out',
                'image_url' => 'https://example.com/orchestre-paris.jpg',
                'ticket_category_id' => $ticketCategories[0]->id
            ],

            [
                'name' => 'Rap Battle Championship 2025',
                'description' => 'Compétition de rap avec les meilleurs artistes français : Orelsan, Nekfeu, PNL',
                'venu_name' => 'AccorHotels Arena',
                'venu_address' => '8 Boulevard de Bercy',
                'city' => 'Paris',
                'event_date' => '2025-08-05 21:00:00',
                'doors_open' => '2025-08-05 19:30:00',
                'sale_starts_at' => '2025-06-01 10:00:00',
                'sale_ends_at' => '2025-08-04 20:00:00',
                'min_age' => 12,
                'max_capacity' => 20000,
                'tickets_sold' => 15000,
                'status' => 'active',
                'image_url' => 'https://example.com/rap-battle.jpg',
                'ticket_category_id' => $ticketCategories[3]->id
            ],
            [
                'name' => 'Jazz sous les Étoiles',
                'description' => 'Soirée jazz en plein air avec Ibrahim Maalouf et ses invités',
                'venu_name' => 'Théâtre Antique',
                'venu_address' => 'Rue du Théâtre Antique',
                'city' => 'Lyon',
                'event_date' => '2025-08-10 20:30:00',
                'doors_open' => '2025-08-10 19:00:00',
                'sale_starts_at' => '2025-06-15 12:00:00',
                'sale_ends_at' => '2025-08-09 23:59:59',
                'min_age' => 8,
                'max_capacity' => 5000,
                'tickets_sold' => 3200,
                'status' => 'active',
                'image_url' => 'https://example.com/jazz-etoiles.jpg',
                'ticket_category_id' => $ticketCategories[1]->id
            ],

            [
                'name' => 'Rock Legends Reunion',
                'description' => 'Retrouvailles exceptionnelles des légendes du rock français : Noir Désir, Téléphone, Trust',
                'venu_name' => 'Zénith',
                'venu_address' => 'Parc de la Villette',
                'city' => 'Paris',
                'event_date' => '2025-09-15 20:00:00',
                'doors_open' => '2025-09-15 18:30:00',
                'sale_starts_at' => '2025-08-01 10:00:00',
                'sale_ends_at' => '2025-09-14 20:00:00',
                'min_age' => 14,
                'max_capacity' => 6800,
                'tickets_sold' => 1200,
                'status' => 'active',
                'image_url' => 'https://example.com/rock-legends.jpg',
                'ticket_category_id' => $ticketCategories[2]->id
            ],
            [
                'name' => 'Festival Indie Pop 2025',
                'description' => 'Découvrez les nouveaux talents de la pop indé française et internationale',
                'venu_name' => 'Parc des Expositions',
                'venu_address' => 'Boulevard de l\'Europe',
                'city' => 'Marseille',
                'event_date' => '2025-10-22 19:00:00',
                'doors_open' => '2025-10-22 17:00:00',
                'sale_starts_at' => '2025-08-15 14:00:00',
                'sale_ends_at' => '2025-10-21 23:59:59',
                'min_age' => 16,
                'max_capacity' => 12000,
                'tickets_sold' => 2800,
                'status' => 'active',
                'image_url' => 'https://example.com/indie-pop.jpg',
                'ticket_category_id' => $ticketCategories[4]->id
            ],
            [
                'name' => 'Gala de Charité - Musiques du Monde',
                'description' => 'Soirée caritative avec des artistes internationaux pour une cause humanitaire',
                'venu_name' => 'Opéra National',
                'venu_address' => 'Place Stanislas',
                'city' => 'Nancy',
                'event_date' => '2025-11-30 19:00:00',
                'doors_open' => '2025-11-30 18:00:00',
                'sale_starts_at' => '2025-09-01 09:00:00',
                'sale_ends_at' => '2025-11-29 18:00:00',
                'min_age' => 0,
                'max_capacity' => 1800,
                'tickets_sold' => 450,
                'status' => 'active',
                'image_url' => 'https://example.com/gala-charite.jpg',
                'ticket_category_id' => $ticketCategories[0]->id
            ],
            [
                'name' => 'Techno Underground Night',
                'description' => 'Nuit techno avec les DJs les plus underground de la scène européenne',
                'venu_name' => 'Warehouse District',
                'venu_address' => 'Zone Industrielle Nord',
                'city' => 'Lille',
                'event_date' => '2025-12-31 23:00:00',
                'doors_open' => '2025-12-31 22:00:00',
                'sale_starts_at' => '2025-10-01 20:00:00',
                'sale_ends_at' => '2025-12-30 23:59:59',
                'min_age' => 18,
                'max_capacity' => 3000,
                'tickets_sold' => 890,
                'status' => 'active',
                'image_url' => 'https://example.com/techno-underground.jpg',
                'ticket_category_id' => $ticketCategories[3]->id
            ],
            [
                'name' => 'Concert Acoustique Intimiste',
                'description' => 'Soirée acoustique avec Zaz et ses invités dans un cadre intimiste',
                'venu_name' => 'Théâtre des Célestins',
                'venu_address' => '4 Rue Charles Dullin',
                'city' => 'Lyon',
                'event_date' => '2026-02-14 20:30:00',
                'doors_open' => '2026-02-14 19:30:00',
                'sale_starts_at' => '2025-12-01 10:00:00',
                'sale_ends_at' => '2026-02-13 20:00:00',
                'min_age' => 6,
                'max_capacity' => 800,
                'tickets_sold' => 120,
                'status' => 'active',
                'image_url' => 'https://example.com/acoustique-intimiste.jpg',
                'ticket_category_id' => $ticketCategories[1]->id
            ],
            [
                'name' => 'Festival Métal Extrême 2026',
                'description' => 'Le festival de métal le plus brutal avec Gojira, Dagoba et Mass Hysteria',
                'venu_name' => 'Hellfest Grounds',
                'venu_address' => 'Route de la Corniche',
                'city' => 'Nantes',
                'event_date' => '2026-06-20 16:00:00',
                'doors_open' => '2026-06-20 14:00:00',
                'sale_starts_at' => '2026-01-15 12:00:00',
                'sale_ends_at' => '2026-06-19 23:59:59',
                'min_age' => 16,
                'max_capacity' => 45000,
                'tickets_sold' => 3400,
                'status' => 'active',
                'image_url' => 'https://example.com/metal-extreme.jpg',
                'ticket_category_id' => $ticketCategories[4]->id
            ],
            [
                'name' => 'Concert Reporté - Artiste International',
                'description' => 'Concert reporté en raison de problèmes techniques - Nouvelles dates à venir',
                'venu_name' => 'Palais des Sports',
                'venu_address' => 'Avenue du Général de Gaulle',
                'city' => 'Toulouse',
                'event_date' => '2025-09-01 20:00:00',
                'doors_open' => '2025-09-01 19:00:00',
                'sale_starts_at' => '2025-06-01 10:00:00',
                'sale_ends_at' => '2025-08-31 20:00:00',
                'min_age' => 12,
                'max_capacity' => 8000,
                'tickets_sold' => 5600,
                'status' => 'postponed',
                'image_url' => 'https://example.com/concert-reporte.jpg',
                'ticket_category_id' => $ticketCategories[2]->id
            ]
        ];
        foreach ($eventData as $data) {
            Event::create($data);
        }
    }
}
