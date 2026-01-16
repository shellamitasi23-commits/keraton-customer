@extends('customer.layouts.master')

@section('content')
    <div style="height: 100vh; min-height: 700px;" class="relative w-full bg-gray-900 overflow-hidden -mt-20">
        
        <img src="{{ asset('images/kasepuhan-1.jpg') }}" class="absolute w-full h-full object-cover opacity-60"
             onerror="this.src='https://images.unsplash.com/photo-1596401057633-565652b8ddbe?q=80&w=1920'"> 
        
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/80"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto h-full flex flex-col justify-center px-6 text-white text-center md:text-left pt-20">
            <h1 class="serif text-5xl md:text-8xl font-bold mb-6 text-[#A8D5BA] leading-tight drop-shadow-2xl">
                Museum Keraton<br>Kasepuhan
            </h1>
            <p class="text-xl md:text-2xl opacity-90 max-w-2xl font-light tracking-wide drop-shadow-md leading-relaxed">
                Jelajahi koleksi pusaka bersejarah dan warisan budaya Kesultanan Cirebon yang sarat makna.
            </p>
        </div>
    </div>

    <div class="relative z-20 max-w-7xl mx-auto px-6 -mt-32 mb-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-xl p-8 flex flex-col items-start border-b-4 border-[#103120] hover:-translate-y-2 transition duration-300">
                <div class="w-14 h-14 bg-[#103120] rounded-full flex items-center justify-center text-white mb-6 shrink-0 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h4 class="font-bold text-[#103120] text-xl mb-2">Jam Operasional</h4>
                <p class="text-sm text-gray-500">Senin - Minggu</p>
                <p class="text-sm text-gray-800 font-bold mt-1">08.00 - 17.00 WIB</p>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-8 flex flex-col items-start border-b-4 border-[#103120] hover:-translate-y-2 transition duration-300">
                <div class="w-14 h-14 bg-[#103120] rounded-full flex items-center justify-center text-white mb-6 shrink-0 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <h4 class="font-bold text-[#103120] text-xl mb-2">Lokasi</h4>
                <p class="text-sm text-gray-500">Jl. Kasepuhan No. 43</p>
                <p class="text-sm text-gray-500">Lemahwungkuk, Cirebon</p>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-8 flex flex-col items-start border-b-4 border-[#103120] hover:-translate-y-2 transition duration-300">
                <div class="w-14 h-14 bg-[#103120] rounded-full flex items-center justify-center text-white mb-6 shrink-0 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                </div>
                <h4 class="font-bold text-[#103120] text-xl mb-2">Kontak</h4>
                <p class="text-sm text-gray-500">+62 231 123456</p>
                <p class="text-sm text-gray-500">info@keraton.com</p>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-8 flex flex-col items-start border-b-4 border-[#103120] hover:-translate-y-2 transition duration-300">
                <div class="w-14 h-14 bg-[#103120] rounded-full flex items-center justify-center text-white mb-6 shrink-0 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h4 class="font-bold text-[#103120] text-xl mb-2">Pemandu</h4>
                <p class="text-sm text-gray-500">Tersedia Pemandu Gratis</p>
                <p class="text-sm text-gray-500">Hubungi Loket Utama</p>
            </div>
        </div>
    </div>

    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <div class="flex items-center gap-4 mb-6">
                     <h2 class="serif text-4xl font-bold text-[#103120]">Sejarah Museum</h2>
                     <div class="h-1 w-16 bg-[#E89020] mt-2"></div>
                </div>
                <p class="text-gray-600 leading-relaxed text-justify mb-6 text-lg">
                    Museum Pusaka Keraton Kasepuhan didirikan untuk menjaga dan merawat peninggalan leluhur. Di sini tersimpan berbagai benda bersejarah mulai dari Kereta Singa Barong yang melegenda hingga gamelan sekaten.
                </p>
                <p class="text-gray-600 leading-relaxed text-justify mb-6 text-lg">
                    Arsitektur museum mencerminkan perpaduan unik antara budaya Hindu, Islam, dan Tionghoa. Hal ini terlihat dari ornamen-ornamen pada bangunan, seperti motif naga, gajah putih, dan kaligrafi Arab.
                </p>
            </div>
            <div class="relative group">
                <img src="{{ asset('images/Silsilah-Keraton-Kasepuhan-Cirebon.jpg') }}" 
                     class="w-full rounded-xl shadow-2xl object-cover h-[500px] transition duration-500 group-hover:scale-[1.02]"
                     onerror="this.src='https://images.unsplash.com/photo-1628498835825-f5b248443567?q=80&w=800'">
                <div class="absolute -z-10 top-6 -right-6 w-full h-full border-2 border-[#103120] rounded-xl hidden md:block transition duration-500 group-hover:top-4 group-hover:-right-4"></div>
            </div>
        </div>
    </div>

    <div class="py-24 bg-[#F5F5F5]">
        <div class="max-w-7xl mx-auto px-6" >
            <div class="text-center mb-16">
                <h2 class="serif text-4xl font-bold text-[#103120] mb-3">Koleksi Museum</h2>
                <div class="h-1 w-20 bg-[#E89020] mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($museums as $item)
                <div class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition duration-500 border border-gray-100 flex flex-col">
                    <div class="h-72 bg-gray-200 overflow-hidden relative">
                        
                        <img src="{{ asset('storage/' . $item->foto) }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                             alt="{{ $item->nama }}"
                             onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                             
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition duration-300"></div>
                    </div>
                    <div class="p-8 flex-1">
                        <h3 class="serif font-bold text-xl text-[#103120] mb-3">{{ $item->nama }}</h3>
                        <p class="text-gray-600 leading-relaxed line-clamp-3">{{ $item->deskripsi }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">Tidak ada koleksi museum yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection