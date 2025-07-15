<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Two Factor Authentication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Add additional security to your account using two factor authentication.') }}
        </p>
    </header>

    <div class="flex items-center gap-4">
        @if (auth()->user()->two_factor_enabled)
            <form method="POST" action="{{ route('profile.2fa.disable') }}">
                @csrf
                <x-primary-button>{{ __('Disable') }}</x-primary-button>
            </form>
        @else
            <form method="POST" action="{{ route('profile.2fa.enable') }}">
                @csrf
                <x-primary-button>{{ __('Enable') }}</x-primary-button>
            </form>
        @endif
    </div>
</section>
