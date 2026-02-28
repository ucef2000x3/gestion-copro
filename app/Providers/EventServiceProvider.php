<?php

namespace App\Providers;

// Importez les modèles et les observers que vous souhaitez enregistrer
use App\Models\LettragePaiement;
use App\Models\ReglementFacture;
use App\Models\ReglementProprietaire;
use App\Observers\LettragePaiementObserver;
use App\Observers\ReglementFactureObserver;
use App\Observers\ReglementProprietaireObserver;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        /*
        ReglementFacture::class => [ReglementFactureObserver::class],
        ReglementProprietaire::class => [ReglementProprietaireObserver::class],
        LettragePaiement::class => [LettragePaiementObserver::class],
        */
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        ReglementFacture::observe(ReglementFactureObserver::class);
        ReglementProprietaire::observe(ReglementProprietaireObserver::class);
        LettragePaiement::observe(LettragePaiementObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
