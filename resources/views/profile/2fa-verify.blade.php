<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Enter 2FA Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
            <form method="POST" action="{{ route('profile.2fa.check') }}">
                @csrf
                <div>
                    <label for="code" class="text-white">Enter the code you received in your email to enable 2fa</label>
                    <input id="code" name="code" type="text"
                        class="block w-full border border-gray-300 rounded px-2 py-1" autocomplete="off">
                </div>
                <div class="mt-4">
                    <x-primary-button>{{ __('Submit') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
