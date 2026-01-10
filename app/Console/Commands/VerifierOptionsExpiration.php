<?php

namespace App\Console\Commands;

use App\Models\AnnonceOption;
use App\Services\AnnonceOptionService;
use Illuminate\Console\Command;

class VerifierOptionsExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'annonces:verifier-options-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie et désactive les options d\'annonces expirées';

    /**
     * Execute the console command.
     */
    public function handle(AnnonceOptionService $service)
    {
        $this->info('Vérification des options expirées...');

        $options = AnnonceOption::where('a_la_une', true)
            ->orWhere('urgent', true)
            ->orWhere('video', true)
            ->get();

        $desactivees = 0;

        foreach ($options as $option) {
            $avant = [
                'a_la_une' => $option->a_la_une,
                'urgent' => $option->urgent,
                'video' => $option->video,
            ];

            $service->verifierExpiration($option);

            $option->refresh();

            if ($avant['a_la_une'] && !$option->a_la_une) {
                $desactivees++;
                $this->info("Option 'À la Une' désactivée pour l'annonce #{$option->annonce_id}");
            }

            if ($avant['urgent'] && !$option->urgent) {
                $desactivees++;
                $this->info("Option 'Urgent' désactivée pour l'annonce #{$option->annonce_id}");
            }

            if ($avant['video'] && !$option->video) {
                $desactivees++;
                $this->info("Option 'Vidéo' désactivée pour l'annonce #{$option->annonce_id}");
            }
        }

        $this->info("Vérification terminée. {$desactivees} option(s) désactivée(s).");
    }
}
