<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 px-4">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

            <!-- Titre principal -->
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-2">
                Réinitialisation du mot de passe
            </h2>
            <p class="text-center text-gray-500 mb-6">
                Entrez votre email et votre nouveau mot de passe
            </p>

            <!-- Affichage des erreurs -->
            <x-auth-validation-errors class="mb-4 text-sm text-red-600" :errors="$errors" />

            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                <!-- Token caché -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <x-label for="email" value="Adresse email" class="font-semibold text-gray-700"/>
                    <x-input
                        id="email"
                        class="block mt-2 w-full rounded-xl border-gray-300 text-lg focus:ring-indigo-500 focus:border-indigo-500"
                        type="email"
                        name="email"
                        :value="old('email', $request->email)"
                        required
                        autofocus
                    />
                </div>

                <!-- Nouveau mot de passe -->
                <div>
                    <x-label for="password" value="Nouveau mot de passe" class="font-semibold text-gray-700"/>
                    <x-input
                        id="password"
                        class="block mt-2 w-full rounded-xl border-gray-300 text-lg focus:ring-indigo-500 focus:border-indigo-500"
                        type="password"
                        name="password"
                        required
                    />
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <x-label for="password_confirmation" value="Confirmer le mot de passe" class="font-semibold text-gray-700"/>
                    <x-input
                        id="password_confirmation"
                        class="block mt-2 w-full rounded-xl border-gray-300 text-lg focus:ring-indigo-500 focus:border-indigo-500"
                        type="password"
                        name="password_confirmation"
                        required
                    />
                </div>

                <!-- Bouton de réinitialisation -->
                <div class="pt-4">
                    <x-button class="w-full justify-center py-3 text-lg rounded-xl bg-indigo-600 hover:bg-indigo-700 transition duration-200">
                        Réinitialiser le mot de passe
                    </x-button>
                </div>
            </form>

            <!-- Lien retour à la connexion -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium transition">
                    Retour à la page de connexion
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
