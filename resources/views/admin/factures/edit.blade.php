<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter une Facture') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                            <p class="font-bold">Veuillez corriger les erreurs ci-dessous :</p>
                            <ul class="list-disc pl-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div x-data="factureForm">
                        <form action="{{ route('factures.update', $facture) }}" method="POST" x-data="factureForm({
    coproprietes: @json($coproprietes),
    initialCoproprieteId: '{{ old('id_copropriete', $facture->id_copropriete) }}',
    initialExerciceId: '{{ old('id_exercice', $facture->id_exercice) }}',
    initialPosteId: '{{ old('id_budget_poste', $facture->id_budget_poste) }}'
})">
                            @csrf
                            <div class="space-y-8">
                                <div>
                                    <h2 class="text-lg font-medium leading-6 text-gray-900">{{ __('Informations de la Facture') }}</h2>
                                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                        <div class="sm:col-span-4">
                                            <label for="id_fournisseur">{{ __('Fournisseur') }}</label>
                                            <select id="id_fournisseur" name="id_fournisseur" required class="mt-2 block w-full rounded-md ring-1">
                                                <option value="">-- {{ __('Choisir') }} --</option>
                                                @foreach($fournisseurs as $fournisseur)
                                                    <option value="{{ $fournisseur->id_fournisseur }}" @if(old('id_fournisseur', $fournisseur->id_fournisseur) == $fournisseur->id_fournisseur) selected @endif>{{ $fournisseur->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="sm:col-span-4">
                                            <label for="id_copropriete">{{ __('Copropriete') }}</label>
                                            <select id="id_copropriete" name="id_copropriete" x-model="selectedCoproprieteId" required class="mt-2 block w-full rounded-md ring-1">
                                                <option value="">-- {{ __('Choisir') }} --</option>
                                                @foreach($coproprietes as $copropriete)
                                                    <option value="{{ $copropriete->id_copropriete }}" @if(old('id_copropriete', $facture->id_copropriete) == $copropriete->id_copropriete) selected @endif>{{ $copropriete->nom_copropriete }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="sm:col-span-4">
                                            <label for="id_exercice">{{ __('Exercices') }}</label>
                                            <select id="id_exercice" name="id_exercice" x-model="selectedExerciceId" required class="mt-2 block w-full rounded-md ring-1">
                                                <option value="">-- {{ __('Sélectionner une copropriété d\'abord') }} --</option>
                                                <template x-for="exercice in exercices" :key="exercice.id_exercice">
                                                    <option :value="exercice.id_exercice" x-text="exercice.libelle"></option>
                                                </template>
                                            </select>
                                        </div>

                                        <div class="sm:col-span-4">
                                            <label for="id_budget_poste">{{ __('Imputer sur le Poste Budgétaire') }}</label>
                                            <select id="id_budget_poste" name="id_budget_poste" class="mt-2 block w-full rounded-md ring-1">
                                                <option value="">-- {{ __('Choisir un exercice d\'abord') }} --</option>
                                                <template x-for="poste in postes" :key="poste.id_poste">
                                                    <option :value="poste.id_poste" x-text="poste.type_de_poste.libelle"></option>
                                                </template>
                                            </select>
                                        </div>

                                        <div class="col-span-full"><label for="objet">{{ __('Objet') }}</label><input type="text" name="objet" id="objet" value="{{ old('objet', $facture->objet) }}" required class="mt-2 block w-full ring-1"></div>
                                        <div class="sm:col-span-3"><label for="numero_facture">{{ __('N° Facture') }}</label><input type="text" name="numero_facture" id="numero_facture" value="{{ old('numero_facture', $facture->numero_facture) }}" class="mt-2 block w-full ring-1"></div>
                                        <div class="sm:col-span-3"><label for="montant_ttc">{{ __('Montant TTC') }}</label><input type="number" step="0.01" min="0" name="montant_ttc" id="montant_ttc" value="{{ old('montant_ttc', $facture->montant_ttc) }}" required class="mt-2 block w-full ring-1"></div>
                                        <div class="sm:col-span-3"><label for="date_emission">{{ __('Date d\'émission') }}</label><input type="date" name="date_emission" id="date_emission" value="{{ old('date_emission', $facture->date_emission?->format('Y-m-d')) }}" required class="mt-2 block w-full ring-1"></div>
                                        <div class="sm:col-span-3"><label for="date_echeance">{{ __('Date d\'échéance') }}</label><input type="date" name="date_echeance" id="date_echeance" value="{{ old('date_echeance', $facture->date_echeance?->format('Y-m-d')) }}" class="mt-2 block w-full ring-1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <a href="{{ route('factures.index') }}" class="text-sm font-semibold leading-6 text-gray-900">{{ __('Cancel') }}</a>
                                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            const coproprietesData = @json($coproprietes);
            const oldValues = {
                copropriete: '{{ old('id_copropriete') }}',
                exercice: '{{ old('id_exercice') }}',
                poste: '{{ old('id_budget_poste') }}'
            };

            Alpine.data('factureForm', () => ({
                coproprietesData: coproprietesData,
                selectedCoproprieteId: oldValues.copropriete || null,
                selectedExerciceId: oldValues.exercice || null,
                exercices: [],
                postes: [],

                init() {
                    console.log('%c Alpine Component Initialisé ', 'background: #222; color: #bada55');
                    console.log('Données initiales reçues du serveur:', this.coproprietesData);

                    this.$watch('selectedCoproprieteId', (newCoproId) => this.updateExercices(newCoproId));
                    this.$watch('selectedExerciceId', (newExerciceId) => this.updatePostes(newExerciceId));

                    if (this.selectedCoproprieteId) {
                        this.updateExercices(this.selectedCoproprieteId, true);
                    }
                },

                updateExercices(coproId, isInitialLoad = false) {
                    console.log(`%c -> updateExercices déclenché avec l'ID: ${coproId}`, 'color: blue');
                    this.exercices = [];
                    this.postes = [];
                    if (!coproId) return;

                    const selectedCopro = this.coproprietesData.find(c => c.id_copropriete == coproId);
                    console.log('Objet Copropriété trouvé:', selectedCopro);

                    if (selectedCopro && selectedCopro.exercices_comptables) {
                        console.log('Exercices trouvés dans la copro:', selectedCopro.exercices_comptables);
                        this.exercices = selectedCopro.exercices_comptables;
                    } else {
                        console.error('Clé "exercices_comptables" non trouvée ou vide dans l\'objet copro.');
                    }

                    if (isInitialLoad && this.selectedExerciceId) {
                        this.$nextTick(() => {
                            document.getElementById('id_exercice').value = this.selectedExerciceId;
                            this.updatePostes(this.selectedExerciceId, true);
                        });
                    }
                },

                updatePostes(exerciceId, isInitialLoad = false) {
                    console.log(`%c -> updatePostes déclenché avec l'ID: ${exerciceId}`, 'color: green');
                    this.postes = [];
                    if (!exerciceId) return;

                    const selectedExercice = this.exercices.find(e => e.id_exercice == exerciceId);
                    console.log('Objet Exercice trouvé:', selectedExercice);

                    if (selectedExercice && selectedExercice.budget_postes) {
                        console.log('Postes trouvés dans l\'exercice:', selectedExercice.budget_postes);
                        this.postes = selectedExercice.budget_postes;
                    } else {
                        console.error('Clé "budget_postes" non trouvée ou vide dans l\'objet exercice.');
                    }

                    if (isInitialLoad && oldValues.poste) {
                        this.$nextTick(() => {
                            document.getElementById('id_budget_poste').value = oldValues.poste;
                        });
                    }
                }
            }));
        });
    </script>
</x-app-layout>
