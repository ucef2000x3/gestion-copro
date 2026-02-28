<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajouter un Compte ou une Caisse</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div x-data="{ type: '{{ old('type_compte', 'banque') }}' }">
                        <form action="{{ route('comptes-bancaires.store') }}" method="POST">
                            @csrf
                            <div class="space-y-8">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                                    <div class="sm:col-span-4"><label for="id_copropriete">Copropriété</label><select name="id_copropriete" id="id_copropriete" required class="mt-2 block w-full ring-1">@foreach($coproprietes as $copro)<option value="{{$copro->id_copropriete}}">{{$copro->nom_copropriete}}</option>@endforeach</select></div>
                                    <div class="sm:col-span-2"><label for="type_compte">Type</label><select name="type_compte" id="type_compte" x-model="type" class="mt-2 block w-full ring-1"><option value="banque">Compte Bancaire</option><option value="caisse">Caisse</option></select></div>
                                    <div class="sm:col-span-full"><label for="nom_compte">Nom du Compte / de la Caisse</label><input type="text" name="nom_compte" id="nom_compte" value="{{ old('nom_compte') }}" required class="mt-2 block w-full ring-1"></div>

                                    <template x-if="type === 'banque'"><div class="contents">
                                            <div class="sm:col-span-3"><label for="nom_banque">Nom de la Banque</label><input type="text" name="nom_banque" id="nom_banque" value="{{ old('nom_banque') }}" class="mt-2 block w-full ring-1"></div>
                                            <div class="sm:col-span-3"><label for="iban">IBAN</label><input type="text" name="iban" id="iban" value="{{ old('iban') }}" class="mt-2 block w-full ring-1"></div>
                                        </div></template>

                                    <div class="sm:col-span-3"><label for="solde_initial">Solde Initial</label><input type="number" step="0.01" name="solde_initial" id="solde_initial" value="{{ old('solde_initial', '0.00') }}" required class="mt-2 block w-full ring-1"></div>
                                    <div class="sm:col-span-3"><label for="statut">Statut</label><select name="statut" id="statut" class="mt-2 block w-full ring-1"><option value="1" selected>Actif</option><option value="0">Inactif</option></select></div>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end gap-x-6">
                                <a href="{{ route('comptes-bancaires.index') }}" class="text-sm font-semibold">Annuler</a>
                                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Sauvegarder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
