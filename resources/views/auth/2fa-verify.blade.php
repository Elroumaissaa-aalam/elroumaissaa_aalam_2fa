<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Login</title>
    @vite('resources/css/app.css')
</head>
<body>
<div class="min-h-screen bg-neutral-900 flex items-center justify-center">
    <div class="bg-neutral-800 rounded-2xl shadow-lg p-8 w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">Check your email</h2>
            <p class="text-neutral-400 text-base">Enter the Two Factor Authentication code sent to your email</p>
            <p class="text-white font-semibold mt-2">{{ Auth::user()->email ?? 'your email' }}</p>
        </div>
        <form method="POST" action="{{ route('auth.2fa.check') }}">
            @csrf
            <div class="flex justify-center gap-x-3 mb-6" data-hs-pin-input='{"availableCharsRE": "^[0-9]+$"}'>
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" name="code[]" class="block w-12 h-14 text-center border-none rounded-md text-xl font-semibold bg-neutral-700 text-white focus:ring-2 focus:ring-[#12687b] outline-none" placeholder="-" data-hs-pin-input-item="">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" name="code[]" class="block w-12 h-14 text-center border-none rounded-md text-xl font-semibold bg-neutral-700 text-white focus:ring-2 focus:ring-[#12687b] outline-none" placeholder="-" data-hs-pin-input-item="">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" name="code[]" class="block w-12 h-14 text-center border-none rounded-md text-xl font-semibold bg-neutral-700 text-white focus:ring-2 focus:ring-[#12687b] outline-none" placeholder="-" data-hs-pin-input-item="">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" name="code[]" class="block w-12 h-14 text-center border-none rounded-md text-xl font-semibold bg-neutral-700 text-white focus:ring-2 focus:ring-[#12687b] outline-none" placeholder="-" data-hs-pin-input-item="">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" name="code[]" class="block w-12 h-14 text-center border-none rounded-md text-xl font-semibold bg-neutral-700 text-white focus:ring-2 focus:ring-[#12687b] outline-none" placeholder="-" data-hs-pin-input-item="">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" name="code[]" class="block w-12 h-14 text-center border-none rounded-md text-xl font-semibold bg-neutral-700 text-white focus:ring-2 focus:ring-[#12687b] outline-none" placeholder="-" data-hs-pin-input-item="">
            </div>
            <button type="submit" class="w-full py-3 rounded-lg text-white font-semibold text-lg transition" style="background-color: #12687b" onmouseover="this.style.backgroundColor='#0f5666'" onmouseout="this.style.backgroundColor='#12687b'">Login</button>
            <div class="text-center mt-4">
                <span class="text-neutral-400 text-sm">Resend code in <span id="timer">00:30</span></span>
            </div>
        </form>
    </div>
</div>
</body>
</html>