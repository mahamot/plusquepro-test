<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

use Illuminate\Console\Command;

class getfilm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:film';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'recuperer les film (puis apres on verra pour le save dans la bdd)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // API URL
        $url = 'https://api.themoviedb.org/3/trending/all/day';
        $language = 'fr-FR';
        //$apiKey = env('KEY_BEARER'); // Remplacez par votre clé API TMDb

        //require_once('vendor/autoload.php');


        
        // Faire la requête HTTP
        $response = Http::withHeaders([
            'Authorization' => env('KEY_BEARER'),
            'Accept' => 'application/json',
        ])->get($url, [
            'language' => $language,
        ]);

        // Initialiser Guzzle client
        $client = new Client();

        try {
            // Faire la requête HTTP avec Guzzle
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('KEY_BEARER'), // token a utiliser (stocker dans la variable d envirronement)
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'language' => $language, //langage recuperer en fr
                    'day' => '7', //mis a 7 jour de recuperation
                ],
            ]);

            // Vérifier si la requête a réussi
            if ($response->getStatusCode() === 200) {
                // Récupérer le contenu JSON de la réponse
                $data = json_decode($response->getBody(), true);

                // Chemin du fichier texte où les données seront stockées
                $filePath = 'trending_movies.txt'; //par defaut dans le dossier storage app

                // Convertir les données en texte et les enregistrer dans le fichier
                Storage::put($filePath, json_encode($data, JSON_PRETTY_PRINT));

                //texte informùatif permettant de savoir dans quel boucle/operation nous sommes 
                $this->info('Les films tendances ont été récupérés et stockés dans trending_movies.txt');
            } else {
                $this->error('Erreur lors de la récupération des films tendances.');
            }
        } catch (\Exception $e) {
            $this->error('Erreur : ' . $e->getMessage());
        }

        return 0;

    }
}
