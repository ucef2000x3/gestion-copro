<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AppelDeFondDetail;
use App\Models\LettragePaiement;
use App\Models\Proprietaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompteProprietaireController extends Controller
{
    public function index(Proprietaire $proprietaire)
    {
        // On récupère les quotes-parts d'appels non soldées pour ce propriétaire
        $detailsAppelsNonPayes = AppelDeFondDetail::where('id_proprietaire', $proprietaire->id_proprietaire)
            ->where('statut', '!=', 'Payé')
            ->with('appelDeFond') // Pour afficher le libellé de l'appel parent
            ->get();

        $reglementsNonLettres = $proprietaire->reglements()
            ->where('statut', '!=', 'Lettré')
            ->get();

        // Calcul du solde
        $totalDettes = AppelDeFondDetail::where('id_proprietaire', $proprietaire->id_proprietaire)->sum('montant_quote_part');
        $totalPaiements = $proprietaire->reglements()->sum('montant_regle');
        $solde = $totalPaiements - $totalDettes;

        return view('admin.comptes-proprietaires.index', compact('proprietaire', 'solde', 'detailsAppelsNonPayes', 'reglementsNonLettres'));
    }

    public function lettrer(Request $request, Proprietaire $proprietaire)
    {
        DB::transaction(function () use ($proprietaire) {
            $reglements = $proprietaire->reglements()->where('statut', '!=', 'Lettré')->orderBy('date_reglement')->get();

            $detailsAppels = AppelDeFondDetail::where('id_proprietaire', $proprietaire->id_proprietaire)
                ->where('statut', '!=', 'Payé')
                ->with('appelDeFond')
                ->orderBy('id') // On lette les plus anciens en premier
                ->get();

            foreach ($reglements as $reglement) {
                $montantRestantDuReglement = $reglement->montant_regle - $reglement->lettrages()->sum('montant_affecte');

                foreach ($detailsAppels as $detail) {
                    if ($montantRestantDuReglement <= 0.009) break;

                    $montantDejaPayePourCeDetail = $detail->reglementsLettres()->sum('montant_affecte');
                    $montantDu = $detail->montant_quote_part - $montantDejaPayePourCeDetail;

                    if ($montantDu > 0.009) {
                        $montantAAppliquer = min($montantRestantDuReglement, $montantDu);

                        LettragePaiement::create([
                            'id_reglement_proprio' => $reglement->id_reglement_proprio,
                            'id_appel_de_fond_detail' => $detail->id, // La clé est ici
                            'montant_affecte' => $montantAAppliquer
                        ]);

                        $montantRestantDuReglement -= $montantAAppliquer;
                    }
                }

                // Mettre à jour le statut du règlement
                $totalAffecte = $reglement->lettrages()->sum('montant_affecte');
                if(abs($totalAffecte - $reglement->montant_regle) < 0.01) {
                    $reglement->update(['statut' => 'Lettré']);
                } else if ($totalAffecte > 0) {
                    $reglement->update(['statut' => 'Partiellement lettré']);
                }
            }

            // Mettre à jour le statut de chaque quote-part
            foreach($detailsAppels as $detail) {
                $totalRecu = $detail->reglementsLettres()->sum('montant_affecte');
                if (abs($totalRecu - $detail->montant_quote_part) < 0.01) {
                    $detail->update(['statut' => 'Payé']);
                } else if ($totalRecu > 0) {
                    $detail->update(['statut' => 'Partiellement payé']);
                }
            }
        });

        return back()->with('success', 'Lettrage automatique effectué avec succès.');
    }
}
