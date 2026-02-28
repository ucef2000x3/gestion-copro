<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier : {{ $compteBancaire->nom_compte }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div x-data="{ type: '{{ old('type_compte', $compteBancaire->type_compte) }}' }">
                        <form action="{{ route('comptes-bancaires.update', $compteBancaire) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-8">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                                    <div class="sm:col-span-4"><label for="id_copropriete">Copropriété</label><select name="id_copropriete" id="id_copropriete" required class="mt-2 block w-full ring-1">@foreach($coproprietes as $copro)<option value="{{$copro->id_copropriete}}" @if(old('id_copropriete', $compteBancaire->id_copropriete) == $copro->id_copropriete) selected @endif>{{$copro->nom_copropriete}}</option>@endforeach</select></div>
                                    <div class="sm:col-span-2"><label for="type_compte">Type</label><select name="type_compte" id="type_compte" x-model="type" class="mt-2 block w-full ring-1"><option value="banque" @if(old('type_compte', $compteBancaire->type_compte) == 'banque') selected @endif>Compte Bancaire</option><option value="caisse" @if(old('type_compte', $compteBancaire->type_compte) == 'caisse') selected @endif>Caisse</option></select></div>
                                    <div class="sm:col-span-full"><label for="nom_compte">Nom</label><input type="text" name="nom_compte" id="nom_compte" value="{{ old('nom_compte', $compteBancaire->nom_compte) }}" required class="mt-2 block w-full ring-1"></div>

                                    <template x-if="type === 'banque'"><div class="contents">
                                            <div class="sm:col-span-3"><label for="nom_banque">Banque</label><input type="text" name="nom_banque" id="nom_banque" value="{{ old('nom_banque', $compteBancaire->nom_banque) }}" class="mt-2 block w-full ring-1"></div>
                                            <div class="sm:col-span-3"><label for="iban">IBAN</label><input type="text" name="iban" id="iban" value="{{ old('iban', $compteBancaire->iban) }}" class="mt-2 block w-full ring-1"></div>
                                        </div></template>

                                    <div class="sm:col-span-3"><label for="solde_initial">Solde Initial</label><input type="number" step="0.01" name="solde_initial" id="solde_initial" value="{{ old('solde_initial', $compteBancaire->solde_initial) }}" required class="mt-2 block w-full ring-1"></div>
                                    <div class="sm:col-span-3"><label for="statut">Statut</label><select name="statut" id="statut" class="mt-2 block w-full ring-1"><option value="1" @if(old('statut', $compteBancaire->statut)) selected @endif>Actif</option><option value="0" @if(!old('statut', $compteBancaire->statut)) selected @endif>Inactif</option></select></div>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end gap-x-6">
                                <a href="{{ route('comptes-bancaires.index') }}" class="text-sm font-semibold">Annuler</a>
                                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
