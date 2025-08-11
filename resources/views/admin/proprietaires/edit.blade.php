<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Owner') }}: {{ $proprietaire->type_proprietaire === 'personne_physique' ? $proprietaire->prenom . ' ' . $proprietaire->nom : $proprietaire->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('proprietaires.update', $proprietaire) }}" method="POST" x-data="{ type: '{{ old('type_proprietaire', $proprietaire->type_proprietaire) }}' }">
                        @csrf
                        @method('PUT')
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">{{ __('Owner Information') }}</h2>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                    <div class="sm:col-span-3">
                                        <label for="type_proprietaire" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Type of Owner') }}</label>
                                        <select id="type_proprietaire" name="type_proprietaire" @change="type = $event.target.value" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="personne_physique" @if(old('type_proprietaire', $proprietaire->type_proprietaire) == 'personne_physique') selected @endif>{{ __('Physical Person') }}</option>
                                            <option value="personne_morale" @if(old('type_proprietaire', $proprietaire->type_proprietaire) == 'personne_morale') selected @endif>{{ __('Legal Entity') }}</option>
                                        </select>
                                        @error('type_proprietaire')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="nom" class="block text-sm font-medium leading-6 text-gray-900" x-text="type === 'personne_physique' ? '{{ __('Last Name') }}' : '{{ __('Company Name') }}'"></label>
                                        <div class="mt-2"><input type="text" name="nom" id="nom" value="{{ old('nom', $proprietaire->nom) }}" class="block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                        @error('nom')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <template x-if="type === 'personne_physique'">
                                        <div class="contents">
                                            <div class="sm:col-span-2"><label for="civilite" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Civility') }}</label><input type="text" name="civilite" id="civilite" value="{{ old('civilite', $proprietaire->civilite) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                            <div class="sm:col-span-4"><label for="prenom" class="block text-sm font-medium leading-6 text-gray-900">{{ __('First Name') }}</label><input type="text" name="prenom" id="prenom" value="{{ old('prenom', $proprietaire->prenom) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                            <div class="sm:col-span-3"><label for="date_naissance" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Date of Birth') }}</label><input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', $proprietaire->date_naissance?->format('Y-m-d')) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                        </div>
                                    </template>

                                    <template x-if="type === 'personne_morale'">
                                        <div class="contents">
                                            <div class="sm:col-span-3"><label for="forme_juridique" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Legal Form') }}</label><input type="text" name="forme_juridique" id="forme_juridique" value="{{ old('forme_juridique', $proprietaire->forme_juridique) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                            <div class="sm:col-span-3"><label for="numero_siret" class="block text-sm font-medium leading-6 text-gray-900">{{ __('SIRET Number') }}</label><input type="text" name="numero_siret" id="numero_siret" value="{{ old('numero_siret', $proprietaire->numero_siret) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                        </div>
                                    </template>

                                    <div class="sm:col-span-3"><label for="email" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Email') }}</label><input type="email" name="email" id="email" value="{{ old('email', $proprietaire->email) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                    <div class="sm:col-span-3"><label for="telephone_contact" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Phone') }}</label><input type="text" name="telephone_contact" id="telephone_contact" value="{{ old('telephone_contact', $proprietaire->telephone_contact) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>

                                    <div class="sm:col-span-3">
                                        <label for="statut" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Status') }}</label>
                                        <select id="statut" name="statut" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="1" @if(old('statut', $proprietaire->statut) == 1) selected @endif>{{ __('Active') }}</option>
                                            <option value="0" @if(old('statut', $proprietaire->statut) == 0) selected @endif>{{ __('Inactive') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-span-full border-t pt-8 mt-4">
                                        <label for="id_utilisateur" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Link to User Account') }} ({{ __('Optional') }})</label>
                                        <p class="mt-1 text-sm text-gray-500">{{ __('Allows the owner to log in to the extranet.') }}</p>
                                        <select id="id_utilisateur" name="id_utilisateur" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="">-- {{ __('Do not link an account') }} --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if(old('id_utilisateur', $proprietaire->id_utilisateur) == $user->id) selected @endif>{{ $user->name }} ({{$user->email}})</option>
                                            @endforeach
                                        </select>
                                        @error('id_utilisateur')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="col-span-full">
                                        <label for="commentaires" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Comments') }} ({{ __('Optional') }})</label>
                                        <div class="mt-2">
                                            <textarea id="commentaires" name="commentaires" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">{{ old('commentaires', $proprietaire->commentaires) }}</textarea>
                                        </div>
                                        @error('commentaires')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('proprietaires.index') }}" class="text-sm font-semibold leading-6 text-gray-900">{{ __('Cancel') }}</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
