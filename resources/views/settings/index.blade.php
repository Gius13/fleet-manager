<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Impostazioni Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="p-4 bg-green-600 text-white rounded-lg shadow-md font-bold">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-red-600 text-white rounded-lg shadow-md font-bold">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border dark:border-gray-700">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-wide">
                                {{ __('Configurazione Notifiche Mail') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                {{ __('Gestisci l\'email del destinatario e i parametri del server SMTP.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('settings.update') }}" class="mt-6 space-y-6">
                            @csrf
                            
                            <div>
                                <x-input-label for="email" :value="__('Email Destinatario Notifiche')" class="dark:text-gray-200 font-semibold" />
                                <x-text-input id="email" name="email" type="email" 
                                    class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-700 focus:ring-blue-500" 
                                    :value="old('email', $settings->value)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-sm font-black text-blue-500 dark:text-blue-400 mb-4 uppercase tracking-widest text-xs">Parametri Server SMTP</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <x-input-label for="mail_host" :value="__('Host SMTP')" class="dark:text-gray-200" />
                                        <x-text-input id="mail_host" name="mail_host" type="text" 
                                            class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-700" 
                                            :value="old('mail_host', $settings->mail_host)" />
                                    </div>

                                    <div>
                                        <x-input-label for="mail_port" :value="__('Porta')" class="dark:text-gray-200" />
                                        <x-text-input id="mail_port" name="mail_port" type="text" 
                                            class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-700" 
                                            :value="old('mail_port', $settings->mail_port)" />
                                    </div>

                                    <div>
                                        <x-input-label for="mail_encryption" :value="__('Crittografia')" class="dark:text-gray-200" />
                                        <select id="mail_encryption" name="mail_encryption" 
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                            <option value="ssl" {{ $settings->mail_encryption == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            <option value="tls" {{ $settings->mail_encryption == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="null" {{ $settings->mail_encryption == 'null' ? 'selected' : '' }}>Nessuna</option>
                                        </select>
                                    </div>

                                    <div>
                                        <x-input-label for="mail_username" :value="__('Username SMTP')" class="dark:text-gray-200" />
                                        <x-text-input id="mail_username" name="mail_username" type="text" 
                                            class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-700" 
                                            :value="old('mail_username', $settings->mail_username)" />
                                    </div>

                                    <div>
                                        <x-input-label for="mail_password" :value="__('Password SMTP')" class="dark:text-gray-200" />
                                        <x-text-input id="mail_password" name="mail_password" type="password" 
                                            class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-700" 
                                            :value="old('mail_password', $settings->mail_password)" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-6">
                                <x-primary-button class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                    {{ __('Salva Impostazioni') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border dark:border-gray-700">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-wide">
                                {{ __('Verifica Configurazione') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                {{ __('Invia una mail di prova all\'indirizzo sopra indicato per confermare che i parametri siano corretti.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('settings.test-email') }}" class="mt-6">
                            @csrf
                            <x-secondary-button type="submit" class="dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 border-gray-600">
                                🚀 {{ __('Invia Mail di Test') }}
                            </x-secondary-button>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>