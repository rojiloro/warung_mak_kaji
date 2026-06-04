<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Warung Mak Kaji</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F6F7F2] font-sans antialiased">

  <!-- Navbar -->
  <nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="text-2xl font-bold text-[#5E8B4A] tracking-wide">
        WARUNG MAK KAJI
      </div>
      <!-- Tombol Kembali -->
      <a href="/" class="border border-[#5E8B4A] text-[#5E8B4A] px-5 py-2 rounded-xl hover:bg-[#5E8B4A] hover:text-white transition font-medium">
        &larr; Kembali
      </a>
    </div>
  </nav>

  <!-- Konten Utama Register -->
  <div class="min-h-[calc(100vh-73px)] flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-lg w-full max-w-7xl overflow-hidden flex flex-col md:flex-row">

      <!-- Sisi Kiri: Informasi / Branding -->
      <div class="md:w-3/5 bg-[#DDE8CF] p-8 md:p-14 flex flex-col justify-center">
        <h1 class="text-5xl font-bold text-gray-900">
          Warung Mak Kaji
        </h1>
        <p class="mt-4 text-lg text-gray-700 leading-relaxed">
          Daftarkan akun untuk mulai menggunakan sistem kasir dan manajemen warung.
        </p>
      </div>

      <!-- Sisi Kanan: Form Pendaftaran -->
      <div class="md:w-2/5 p-6 md:p-10 flex flex-col justify-center">
        <h2 class="text-3xl font-bold mb-4 text-gray-900">
          Daftar
        </h2>

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <!-- Input Nama -->
          <div class="mb-4">
            <x-input-label for="name" value="Nama" />
            <x-text-input 
              id="name" 
              name="name" 
              type="text" 
              class="w-full rounded-xl mt-2 border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A]" 
              :value="old('name')" 
              required 
              autofocus 
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
          </div>

          <!-- Input Email -->
          <div class="mb-4">
            <x-input-label for="email" value="Email" />
            <x-text-input 
              id="email" 
              name="email" 
              type="email" 
              class="w-full rounded-xl mt-2 border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A]" 
              :value="old('email')" 
              required 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>

          <!-- Input Password -->
          <div class="mb-4">
            <x-input-label for="password" value="Password" />
            <x-text-input 
              id="password" 
              name="password" 
              type="password" 
              class="w-full rounded-xl mt-2 border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A]" 
              required 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </div>

          <!-- Input Konfirmasi Password -->
          <div class="mb-6">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input 
              id="password_confirmation" 
              name="password_confirmation" 
              type="password" 
              class="w-full rounded-xl mt-2 border-2 border-[#5E8B4A] focus:border-[#5E8B4A] focus:ring-[#5E8B4A]" 
              required 
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
          </div>

          <!-- Tombol Submit -->
          <button type="submit" class="w-full bg-[#5E8B4A] text-white font-semibold rounded-xl py-3 shadow-md hover:bg-[#4a6e3a] transition transform active:scale-[0.99]">
            Daftar
          </button>

          <!-- Tautan Login -->
          <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-[#5E8B4A] hover:underline font-medium">
              Sudah punya akun?
            </a>
          </div>
        </form>
      </div>

    </div>
  </div>

</body>
</html>
