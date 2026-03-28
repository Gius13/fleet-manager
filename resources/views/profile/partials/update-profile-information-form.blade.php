<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-wide">
            {{ __('Informazioni Profilo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            {{ __("Aggiorna le informazioni del tuo profilo e l'indirizzo email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nome')" class="dark:text-gray-200 font-bold" />
            <x-text-input id="name" name="name" type="text" 
                class="mt-1 block w-full bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 focus:ring-blue-500 shadow-sm" 
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-200 font-bold" />
            <x-text-input id="email" name="email" type="email" 
                class="mt-1 block w-full bg-white dark:bg-gray-900 text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 focus:ring-blue-500 shadow-sm" 
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Il tuo indirizzo email non è verificato.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            {{ __('Clicca qui per reinviare l\'email di verifica.') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-black px-6 py-2 rounded shadow-md transition">
                {{ __('SALVA') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 font-bold"
                >{{ __('Salvato con successo!') }}</p>
            @endif
        </div>
    </form>
</section>