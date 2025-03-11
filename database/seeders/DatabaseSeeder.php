<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Round;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //===========================================================================//
        // ROUND 3-6-9 SEEDER
        //===========================================================================//
        $round = Round::find(1);
        $round369 = [
            "questions" => [
                "Who was the first King of Belgium?",
                "When did Belgium gain independence?",
                "How many official languages does Belgium have?",
                "What is the capital of Belgium?",
                "Who was the famous Belgian king during World War I?",
                "What major battle occurred in Belgium during World War I?",
                "Which Belgian city is known for its medieval architecture and canals?",
                "What is the Atomium and where is it located?",
                "Who painted The Arnolfini Portrait?",
                "What major event occurred in Belgium in 1960?",
                "Which famous chocolate brand is Belgian?",
                "What is the historical significance of Waterloo in Belgium?",
                "When did Belgium become a constitutional monarchy?",
                "What was the significance of the Battle of the Bulge during World War II?",
                "What is the national day of Belgium?",
            ],
            "answers" => [
                "Leopold I",
                "October 4, 1830",
                "3",
                "Brussels",
                "King Albert I",
                "The Battle of Ypres",
                "Bruges",
                "A landmark in Brussels, symbolizing an iron crystal",
                "Jan van Eyck",
                "Independence of the Congo",
                "Godiva",
                "Napoleon's defeat in 1815",
                "1831",
                "Last major German offensive in 1944-45",
                "July 21st",
            ],
        ];

        foreach ($round369['questions'] as $index => $questionText) {
            $question = Question::createOrUpdate($round->id, $questionText);
            Answer::createOrUpdate($question->id, $round369['answers'][$index]);
        }

        //===========================================================================//
        // ROUND OPEN DEUR SEEDER
        //===========================================================================//
        $round = Round::find(2);
        $opendeur = [
            "images" => [
                asset('images/assorted-mixed-fruits.jpg'),
                asset('images/vegetables.jpg'),
                asset('images/fruits-v2.jpg'),
                asset('images/vegetables-v2.jpg'),
            ],
            "questions" => [
                "What is the Netherlands known for?",
                "Which animal is associated with Australia?",
                "What is Italy famous for?",
                "What is Japan famous for?",
            ],
            "answers" => [
                ["Tulips", "Cheese", "Windmills", "Clogs"],
                ["Kangaroo", "Koala", "Emu", "Platypus"],
                ["Pizza", "Pasta", "Colosseum", "Venice Canals"],
                ["Sushi", "Mount Fuji", "Cherry Blossoms", "Sumo Wrestling"],
            ],
        ];

        foreach ($opendeur['questions'] as $index => $questionText) {
            $image = $opendeur['images'][$index] ?? null;
            $answers = $opendeur['answers'][$index] ?? [];

            $question = Question::create([
                'round_id' => $round->id,
                'text' => $questionText
            ]);

            // Save the image if provided
            if ($image) {
                $imagePath = $this->saveImage($image);
                $question->update(['file_path' => $imagePath]);
            }

            foreach ($answers as $answer) {
                Answer::create([
                    'question_id' => $question->id,
                    'text' => $answer
                ]);
            }
        }

        //===========================================================================//
        // ROUND PUZZEL SEEDER
        //===========================================================================//
        $round = Round::find(3);
        $puzzel = [
            "answers" => [
                "Kings",
                "Science",
                "Music",
                "Space",
                "Heroes",
                "Pirates",
                "Mythology",
                "Art",
                "Animals",
                "Nature",
            ],
            "keywords" => [
                ["Leopold", "Mufasa", "Arthur", "Alexander"],
                ["Newton", "Darwin", "Curie", "Einstein"],
                ["Beethoven", "Mozart", "Chopin", "Bach"],
                ["Nebula", "Mars", "Comet", "Satellite"],
                ["Hercules", "Achilles", "Thor", "Beowulf"],
                ["Blackbeard", "Treasure", "Shipwreck", "Corsair"],
                ["Zeus", "Odin", "Ra", "Hera"],
                ["Van Gogh", "Picasso", "Monet", "Dali"],
                ["Elephant", "Leopard", "Dolphin", "Owl"],
                ["Mountain", "River", "Forest", "Desert"],
            ],
        ];

        foreach ($puzzel['answers'] as $index => $category) {
            $question = Question::createOrUpdate($round->id, $category);

            foreach ($puzzel['keywords'][$index] as $keyword) {
                Answer::createOrUpdate($question->id, $keyword);
            }
        }

        //===========================================================================//
        // ROUND INGELIJST SEEDER
        //===========================================================================//
        $round = Round::find(4);

        $ingelijst = [
            "questions" => [
                "Wie zijn de belangrijkste personages uit de stripreeks ‘Kuifje’?",
                "Welke munteenheden zijn met de komst van de euro verdwenen?",
                "Kan je in het Frans tot 10 tellen?",
                "Welke belgische provincies ken je?",
            ],
            "answers" => [
                ["Kuifje", "Jansen", "Janssen", "Bobbie", "Professor Zonnebloem", "Kapitein Haddock", "Bianca Castafiore", "Abdallah", "Irma", "Nestor",],
                ["Drachme", "Lire", "Mark", "Escudo", "Peseta", "Frank", "Gulden", "Shilling", "Dinar", "Kroon",],
                ["Un", "Deux", "Trois", "Quatre", "Cinq", "Six", "Sept", "Huit", "Neuf", "Dix",],
                ["Limburg", "Luik", "Vlaams-Brabant", "West-Vlaanderen", "Oost-Vlaanderen", "Antwerpen", "Namen", "Henegouwen", "Waals-Brabant", "Luxemburg",],
            ],
        ];

        foreach ($ingelijst['questions'] as $index => $category) {
            $question = Question::createOrUpdate($round->id, $category);

            foreach ($ingelijst['answers'][$index] as $keyword) {
                Answer::createOrUpdate($question->id, $keyword);
            }
        }

        //===========================================================================//
        // ROUND FINALE SEEDER
        //===========================================================================//
        $round = Round::find(5);

        $finale = [
            "questions" => [
                "Aan welke vijf woorden denk je bij het horen van het woord ‘postzegel’?",
                "Wat weet je over 11 november?",
                "Wat weet je over Rembrandt?",
                "Wat is grappa?",
                "Welke mensen maken deel uit van een gemeenteraad?",
                "Welke vlakken van een dobbelsteen zijn zichtbaar als je een zes gooit?",
                "Wat weet je over een groot staatsman genaamd Churchill?",
                "Wat zijn de vijf kleinste even veelvouden van 15?",
                "Wat weet je over Urbanus?",
                "Wat weet je over Machu Picchu?",
            ],
            "answers" => [
                ["Brief", "Post", "Envelop", "Likken", "Koning",],
                ["Treinwagon", "11.11.11", "Wereldoorlog 1", "Wapenstilstand", "Onbekende soldaat",],
                ["Nederland", "Schilder", "Van Rijn", "De Nachtwacht", "17e eeuw",],
                ["Italiaans", "Drank", "Druiven", "Alcohol", "Doorzichtig",],
                ["Burgemeester", "Schepen", "Voorzitter", "Gemeenteraadsleden", "Oppositie",],
                ["Zes", "Vijf", "Vier", "Drie", "Twee",],
                ["Winston", "Brit", "Nobelprijs", "Wereldoorlog 2", "Sigaar",],
                ["30", "60", "90", "120", "150",],
                ["Urbain Servranckx", "Tollembeek", "Van Anus", "Koko Flanel", "Stripreeks",],
                ["Inca's", "Peru", "Werelderfgoed", "Stad", "Bergen",],
            ],
        ];

        foreach ($finale['questions'] as $index => $category) {
            $question = Question::createOrUpdate($round->id, $category);

            foreach ($finale['answers'][$index] as $keyword) {
                Answer::createOrUpdate($question->id, $keyword);
            }
        }
    }

    private function saveImage($imageUrl)
    {
        // Ensure the image exists on the local file system
        if (file_exists(public_path($imageUrl))) {
            // Extract the image name (basename)
            $imageName = basename($imageUrl);

            // Define the storage path
            $storagePath = 'public/' . $imageName;

            // Copy the image from the public directory to storage
            copy(public_path($imageUrl), storage_path('app/' . $storagePath));

            // Return the URL for the image in the storage
            return Storage::url($storagePath);
        }

        // Return null if the image doesn't exist
        return null;
    }
}
