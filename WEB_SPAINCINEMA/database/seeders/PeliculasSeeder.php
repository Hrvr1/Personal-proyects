<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peliculas;

class PeliculasSeeder extends Seeder
{
    public function run(): void
    {
        Peliculas::create([
            'nombre' => 'Avengers: Endgame',
            'fecha_estreno' => '2019-04-26',
            'genero' => 'Acción',
            'descripcion' => 'Los Vengadores intentan revertir el chasquido de Thanos.',
            'duracion' => 181,
            'imagen' => 'avengers.jpg',
            'precio' => 10.50,
            'trailer' => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
        ]);

        Peliculas::create([
            'nombre' => 'Interstellar',
            'fecha_estreno' => '2014-11-07',
            'genero' => 'Ciencia Ficción',
            'descripcion' => 'Un equipo de astronautas viaja a través de un agujero de gusano en busca de un nuevo hogar para la humanidad.',
            'duracion' => 169,
            'imagen' => 'interstellar.jpg',
            'precio' => 12.00,
            'trailer' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
        ]);

        Peliculas::create([
            'nombre' => 'Oppenheimer',
            'fecha_estreno' => '2023-07-21',
            'genero' => 'Drama, Historia',
            'descripcion' => 'La historia de J. Robert Oppenheimer y el desarrollo de la bomba atómica.',
            'duracion' => 180,
            'imagen' => 'oppenheimer.jpg',
            'precio' => 15.00,
            'trailer' => 'https://www.youtube.com/watch?v=uYPbbksJxIg',
        ]);

        Peliculas::create([
            'nombre' => 'El Padrino',
            'fecha_estreno' => '1972-03-24',
            'genero' => 'Crimen, Drama',
            'descripcion' => 'La historia de la familia mafiosa Corleone.',
            'duracion' => 175,
            'imagen' => 'elpadrino.jpg',
            'precio' => 8.50,
            'trailer' => 'https://www.youtube.com/watch?v=sY1S34973zA',
        ]);

        Peliculas::create([
            'nombre' => 'Avatar',
            'fecha_estreno' => '2009-12-18',
            'genero' => 'Ciencia Ficción, Aventura',
            'descripcion' => 'Un humano en un cuerpo alienígena lucha por salvar el planeta Pandora.',
            'duracion' => 162,
            'imagen' => 'avatar.jpeg',
            'precio' => 11.00,
            'trailer' => 'https://www.youtube.com/watch?v=5PSNL1qE6VY',
        ]);

        Peliculas::create([
            'nombre' => 'Harry Potter y la Piedra Filosofal',
            'fecha_estreno' => '2001-11-16',
            'genero' => 'Fantasía, Aventura',
            'descripcion' => 'Harry Potter descubre que es un mago y comienza su aventura en Hogwarts.',
            'duracion' => 152,
            'imagen' => 'harry-potter.jpeg',
            'precio' => 9.50,
            'trailer' => 'https://www.youtube.com/watch?v=VyHV0BRtdxo',
        ]);

        Peliculas::create([
            'nombre' => 'Inside Out',
            'fecha_estreno' => '2015-06-19',
            'genero' => 'Animación, Familia',
            'descripcion' => 'Las emociones de una niña toman vida mientras enfrenta cambios en su vida.',
            'duracion' => 95,
            'imagen' => 'inside-out.jpeg',
            'precio' => 7.00,
            'trailer' => 'https://www.youtube.com/watch?v=seMwpP0yeu4',
        ]);

        Peliculas::create([
            'nombre' => 'Rápidos y Furiosos',
            'fecha_estreno' => '2001-06-22',
            'genero' => 'Acción, Crimen',
            'descripcion' => 'Carreras callejeras y robos en una saga llena de adrenalina.',
            'duracion' => 106,
            'imagen' => 'rapidos-y-furiosos.jpeg',
            'precio' => 8.00,
            'trailer' => 'https://www.youtube.com/watch?v=2TAOizOnNPo',
        ]);

        Peliculas::create([
            'nombre' => 'Star Wars: Una Nueva Esperanza',
            'fecha_estreno' => '1977-05-25',
            'genero' => 'Ciencia Ficción, Aventura',
            'descripcion' => 'Luke Skywalker se une a la lucha contra el Imperio Galáctico.',
            'duracion' => 121,
            'imagen' => 'star-wars.jpeg',
            'precio' => 10.00,
            'trailer' => 'https://www.youtube.com/watch?v=vZ734NWnAHA',
        ]);

        Peliculas::create([
            'nombre' => 'Spider-Man: Brand New Day',
            'fecha_estreno' => '2026-07-03',
            'genero' => 'Acción, Aventura',
            'descripcion' => 'Peter Parker enfrenta nuevos desafíos mientras equilibra su vida personal y su responsabilidad como Spider-Man.',
            'duracion' => 130,
            'precio' => 10.50,
            'imagen' => 'spiderman.jpeg',
        ]);

        Peliculas::create([
            'nombre' => 'The Mandalorian & Grogu',
            'fecha_estreno' => '2026-12-18',
            'genero' => 'Ciencia Ficción, Aventura',
            'descripcion' => 'El Mandaloriano y su compañero Grogu emprenden una nueva aventura en la galaxia enfrentando un nuevo enemigo del Imperio.',
            'duracion' => 140,
            'precio' => 11.00,
            'imagen' => 'mandalorian_grogu.jpeg',
        ]);
        Peliculas::create([
            'nombre' => 'Toy Story 5',
            'fecha_estreno' => '2026-06-19',
            'genero' => 'Animación, Comedia',
            'descripcion' => 'Woody, Buzz y los juguetes exploran un nuevo mundo donde descubren lo que significa ser un juguete de verdad.',
            'duracion' => 100,
            'precio' => 9.75,
            'imagen' => 'toy_story_5.jpeg',
        ]);
        Peliculas::create([
            'nombre' => 'Supergirl: Woman of Tomorrow',
            'fecha_estreno' => '2026-03-27',
            'genero' => 'Acción, Ciencia Ficción',
            'descripcion' => 'Kara Zor-El, prima de Superman, viaja a través del cosmos para encontrar su lugar en la Tierra mientras combate una amenaza alienígena.',
            'duracion' => 125,
            'precio' => 10.00,
            'imagen' => 'supergirl.jpeg',
        ]);
        Peliculas::create([
            'nombre' => 'The Hunger Games: Sunrise on the Reaping',
            'fecha_estreno' => '2026-11-20',
            'genero' => 'Drama, Ciencia Ficción',
            'descripcion' => 'Una precuela que muestra el amanecer de los Juegos del Hambre y cómo se formó el sistema brutal de Panem.',
            'duracion' => 135,
            'precio' => 11.50,
            'imagen' => 'hunger_games.jpeg',
        ]);
        Peliculas::create([
            'nombre' => 'Avengers: Doomsday',
            'fecha_estreno' => '2026-05-01',
            'genero' => 'Acción, Aventura',
            'descripcion' => 'Los Vengadores deben reunirse una vez más para enfrentar una amenaza cósmica que podría significar el fin del multiverso.',
            'duracion' => 150,
            'precio' => 12.00,
            'imagen' => 'avengers_doomsday.jpeg',
        ]);
    }
}