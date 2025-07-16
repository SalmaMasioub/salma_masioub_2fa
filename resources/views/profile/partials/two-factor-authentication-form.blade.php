<div>
    <h3 class="text-lg font-medium text-gray-900">Two-Factor Authentication</h3>
    <div class="mt-2 max-w-xl text-sm text-gray-600">
        <p>Add additional security to your account using two-factor authentication.</p>
    </div>

    @if (auth()->user()->two_factor_enabled)
        <p class="mt-2 text-sm text-green-600">Two-factor authentication is enabled.</p>
    @else
        <form method="POST" action="{{ route('two-factor.enable') }}">
            @csrf
            <div class="mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Enable two factor authentication
                </button>
            </div>
        </form>
    @endif
</div>