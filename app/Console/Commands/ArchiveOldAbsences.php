<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArchiveOldAbsences extends Command
{
    protected $signature = 'archive:old-absences'; // Nom de la commande
    protected $description = 'Archive les absences dépassant 12 mois';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Début de l\'archivage des anciennes absences...');

        $dateLimite = Carbon::now()->subMonths(12);

        DB::transaction(function () use ($dateLimite) {
            $absencesAArchiver = DB::table('absences')
                ->where('fin', '<=', $dateLimite)
                ->get();

            if ($absencesAArchiver->isNotEmpty()) {
                // Insérer les données dans la table des archives
                DB::table('archived_absences')->insert(
                    $absencesAArchiver->map(function ($absence) {
                        return array_merge((array) $absence, ['archived_at' => now()]);
                    })->toArray()
                );

                // Supprimer les données archivées de la table principale
                DB::table('absences')
                    ->whereIn('id', $absencesAArchiver->pluck('id'))
                    ->delete();
            }
        });

        $this->info('Archivage terminé.');
    }
}
