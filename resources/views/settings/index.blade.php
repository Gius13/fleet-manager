<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Impostazioni Sistema') }}
        </h2>
    </x-slot>

    @php
        // Controlliamo se abbiamo appena salvato (serve per svuotare la password)
        $isSaved = session()->has('success');
    @endphp

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div class="p-4 bg-green-600 text-white rounded-xl shadow-md font-bold flex items-center gap-2 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-red-600 text-white rounded-xl shadow-md font-bold flex items-center gap-2 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="h-2 w-full bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                
                <div class="p-6 sm:p-10">
                    <section>
                        <header class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                                {{ __('Notifiche e Server Mail') }}
                            </h2>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Configura l\'indirizzo di ricezione dei report e i parametri per l\'invio (SMTP) di Edil2.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('settings.update') }}" class="space-y-8">
                            @csrf
                            
                            <div class="p-6 bg-blue-50/50 dark:bg-gray-900/50 rounded-xl border border-blue-100 dark:border-gray-700 transition-colors">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <h3 class="text-md font-bold text-gray-900 dark:text-white">{{ __('Destinatario Report') }}</h3>
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email Destinatario Notifiche')" class="dark:text-gray-300" />
                                    <x-text-input id="email" name="email" type="email" 
                                        class="mt-1 block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600 focus:ring-blue-500 transition-shadow" 
                                        :value="old('email', $settings->value)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>

                            <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 transition-colors">
                                <div class="flex items-center gap-2 mb-6">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                                    <h3 class="text-md font-bold text-gray-900 dark:text-white">{{ __('Configurazione SMTP') }}</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                    <div class="md:col-span-6">
                                        <x-input-label for="mail_host" :value="__('Host SMTP')" class="dark:text-gray-300" />
                                        <x-text-input id="mail_host" name="mail_host" type="text" 
                                            class="mt-1 block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600" 
                                            :value="old('mail_host', $settings->mail_host)" />
                                    </div>

                                    <div class="md:col-span-3">
                                        <x-input-label for="mail_port" :value="__('Porta')" class="dark:text-gray-300" />
                                        <x-text-input id="mail_port" name="mail_port" type="text" 
                                            class="mt-1 block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600" 
                                            :value="old('mail_port', $settings->mail_port)" />
                                    </div>

                                    <div class="md:col-span-3">
                                        <x-input-label for="mail_encryption" :value="__('Crittografia')" class="dark:text-gray-300" />
                                        <select id="mail_encryption" name="mail_encryption" 
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm transition-shadow">
                                            <option value="ssl" {{ old('mail_encryption', $settings->mail_encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            <option value="tls" {{ old('mail_encryption', $settings->mail_encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="null" {{ old('mail_encryption', $settings->mail_encryption) == 'null' ? 'selected' : '' }}>Nessuna</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-12 border-t border-gray-200 dark:border-gray-700 my-2"></div>

                                    <div class="md:col-span-6">
                                        <x-input-label for="mail_username" :value="__('Username SMTP')" class="dark:text-gray-300" />
                                        <x-text-input id="mail_username" name="mail_username" type="text" 
                                            class="mt-1 block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600" 
                                            :value="old('mail_username', $settings->mail_username)" />
                                    </div>

                                    <div class="md:col-span-6">
                                        <x-input-label for="mail_password" :value="__('Password SMTP')" class="dark:text-gray-300" />
                                        <x-text-input id="mail_password" name="mail_password" type="password" 
                                            class="mt-1 block w-full dark:bg-gray-800 dark:text-white dark:border-gray-600" 
                                            :value="$isSaved ? '' : old('mail_password', $settings->mail_password)" 
                                            placeholder="••••••••••••" />
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lascia vuoto se non vuoi cambiarla.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-8">
                                <x-primary-button class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    {{ __('Salva Impostazioni') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Verifica Configurazione') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Invia una mail di prova per confermare che i parametri SMTP siano operativi.') }}
                        </p>
                    </div>
                    
                    <form method="post" action="{{ route('settings.test-email') }}" class="w-full sm:w-auto shrink-0">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            {{ __('Invia Mail di Test') }}
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>