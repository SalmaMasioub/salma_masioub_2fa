@extends("index")

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-900 via-blue-800 to-blue-700 px-4">
  <div class="max-w-md w-full bg-white bg-opacity-90 rounded-xl shadow-lg p-8">
    <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6">Two-Factor Authentication</h2>
    <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-6">
      @csrf
      <div>
        <label for="code" class="block text-gray-700 font-semibold mb-2">Enter your 6-digit code</label>
        <input
          id="code" name="code" type="text" required autofocus placeholder="******"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-xl tracking-widest font-mono placeholder-gray-400">
      </div>

      <button
        type="submit"
        class="w-full bg-blue-700 hover:bg-blue-800 transition-colors duration-200 text-white font-bold py-3 rounded-lg shadow-md focus:outline-none focus:ring-4 focus:ring-blue-400">
        Verify Code
      </button>
    </form>
  </div>
</div>
@endsection
