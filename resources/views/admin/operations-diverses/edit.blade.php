<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Modifier l\'Opération Diverse :') }} {{ $operation->libelle }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div x-data="operationForm({
                        coproprietes: @json($coproprietes),
                        initialCoproId: '{{ old('id_copropriete', $operation->id_copropriete) }}',
                        initialExerciceId: '{{ old('id_exercice', $operation->id_exercice) }}',
                        initialPosteId: '{{ old('id_type_poste', $operation->id_type_poste) }}'
                    })">
                        <form action="{{ route('operations-diverses.update', $operation) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-8">
                                <div>
                                    <h2 class="text-lg font-medium leading-6 text-gray-900">{{ __('Détails de l\'Opération') }}</h2>
                                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-4">
                                            <label for="id_copropriete">Copropriété</label>
                                            <select id="id_copropriete" name="id_copropriete" x-model="selectedCoproprieteId" required class="mt-2 block w-full rounded-md ring-1">
                                                @foreach($coproprietes as $copropriete)
                                                    <option value="{{ $copropriete->id_copropriete }}">{{ $copropriete->nom_copropriete }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="sm:col-span-3">
                                            <label for="id_exercice">Exercice Comptable</label>
                                            <select id="id_exercice" name="id_exercice" x-model="selectedExerciceId" required class="mt-2 block w-full rounded-md ring-1">
                                                <option value="">-- Choisir copro --</option>
                                                <template x-for="exercice in exercices" :key="exercice.id_exercice"><option :value="exercice.id_exercice" x-text="exercice.libelle"></option></template>
                                            </select>
                                        </div>
                                        <div class="sm:col-span-3">
                                            <label for="id_type_poste">Catégorie / Poste</label>
                                            <select id="id_type_poste" name="id_type_poste" x-model="selectedPosteId" required class="mt-2 block w-full rounded-md ring-1">
                                                <option value="">-- Choisir copro --</option>
                                                <template x-for="poste in postes" :key="poste.id_type_poste"><option :value="poste.id_type_poste" x-text="poste.libelle"></option></template>
                                            </select>
                                        </div>
                                        <div class="col-span-full"><label for="libelle">Libellé</label><input type="text" name="libelle" id="libelle" value="{{ old('libelle', $operation->libelle) }}" required class="mt-2 block w-full ring-1"></div>
                                        <div class="sm:col-span-2"><label for="type_operation">Type</label><select id="type_operation" name="type_operation" class="mt-2 block w-full rounded-md ring-1"><option @if(old('type_operation', $operation->type_operation) == 'Depense') selected @endif>Depense</option><option @if(old('type_operation', $operation->type_operation) == 'Recette') selected @endif>Recette</option></select></div>
                                        <div class="sm:col-span-2"><label for="montant">Montant</label><input type="number" step="0.01" min="0.01" name="montant" id="montant" value="{{ old('montant', $operation->montant) }}" required class="mt-2 block w-full ring-1"></div>
                                        <div class="sm:col-span-2"><label for="date_operation">Date</label><input type="date" name="date_operation" id="date_operation" value="{{ old('date_operation', $operation->date_operation->format('Y-m-d')) }}" required class="mt-2 block w-full ring-1"></div>
                                        <div class="sm:col-span-full"><label for="tiers">Tiers (Optionnel)</label><input type="text" name="tiers" id="tiers" value="{{ old('tiers', $operation->tiers) }}" class="mt-2 block w-full ring-1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end gap-x-6">
                                <a href="{{ route('operations-diverses.index') }}" class="text-sm font-semibold">Annuler</a>
                                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('operationForm', (data) => ({
                    coproprietesData: data.coproprietes, selectedCoproprieteId: data.initialCoproId,
                    selectedExerciceId: data.initialExerciceId, selectedPosteId: data.initialPosteId,
                    exercices: [], postes: [],
                    init() {
                        this.$watch('selectedCoproprieteId', (newId) => this.updateLists(newId));
                        if (this.selectedCoproprieteId) { this.updateLists(this.selectedCoproprieteId, true); }
                    },
                    updateLists(coproId, isInitialLoad = false) {
                        this.exercices = []; this.postes = [];
                        if (!isInitialLoad) { this.selectedExerciceId = null; this.selectedPosteId = null; }
                        if (!coproId) return;
                        const selectedCopro = this.coproprietesData.find(c => c.id_copropriete == coproId);
                        if (selectedCopro) {
                            this.exercices = selectedCopro.exercices || [];
                            this.postes = selectedCopro.types_de_poste || [];
                        }
                        if (isInitialLoad) {
                            this.$nextTick(() => {
                                if(this.selectedExerciceId) document.getElementById('id_exercice').value = this.selectedExerciceId;
                                if(this.selectedPosteId) document.getElementById('id_type_poste').value = this.selectedPosteId;
                            });
                        }
                    }
                }));
            });
        </script>
</x-app-layout>
