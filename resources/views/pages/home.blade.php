@extends('layouts.master')

@section('content')
    <div class="relative h-[600px] w-full bg-gray-900 overflow-hidden">
        <img src="images/arsitektur.jpg" class="absolute w-full h-full object-cover opacity-60">
        
        <div class="relative z-10 max-w-7xl mx-auto h-full flex flex-col justify-center px-6 text-white">
            <h1 class="text-6xl font-medium mb-2 tracking-[0.2em] uppercase">Keraton</h1>
            <h1 class="text-6xl md:text-7xl font-bold mb-6 uppercase leading-tight">
                Kasepuhan<br><span class="text-[#E89020]">Cirebon</span>
            </h1>
            <p class="max-w-xl text-lg opacity-90 mb-8 leading-relaxed font-light">
                Jelajahi keagungan Keraton Kasepuhan, warisan budaya yang menyimpan sejarah panjang peradaban Islam, Jawa, dan Tionghoa di Cirebon.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('tiket.index') }}" class="bg-[#E89020] text-white px-8 py-3 rounded font-bold hover:bg-orange-600 transition">Pesan Tiket</a>
                <a href="#sejarah" class="border border-white text-white px-8 py-3 rounded font-bold hover:bg-white hover:text-black transition">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </div>

<div id="sejarah" class="py-24 bg-[#F9F9F7]">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            
            <div>
                
                <div class="mb-8">
                    <h2 class="serif text-4xl font-bold text-[#103120]">Sejarah Keraton</h2>
                    
                    <div class="h-1 w-24 bg-[#E89020] mt-4"></div> 
                </div>

                <p class="text-gray-600 leading-loose mb-6 text-justify text-lg">
                    Berakar kuat sejak 1430 di Dalem Agung Pakungwati, sejarah ini dimulai dari visi Pangeran Cakrabuana dan mencapai puncak kejayaannya di bawah naungan Sunan Gunung Jati.
                </p>
                <p class="text-gray-600 leading-loose text-justify text-lg">
                    Sejak 1677, di bawah Sultan Sepuh I, ia dikenal sebagai Keraton Kasepuhan. Hingga detik ini, ia berdiri gagah—memadukan arsitektur lintas budaya dan menjaga marwah leluhur di setiap sudutnya.
                </p>
            </div>

            <div class="relative group">
                <div class="absolute -top-4 -left-4 w-full h-full border-2 border-[#103120] rounded-lg hidden md:block transition duration-500 group-hover:top-4 group-hover:left-4"></div>
                <img src="images/keraton-kasepuhan-cirebon.jpeg" class="relative z-10 w-full rounded-lg shadow-2xl transition duration-500 transform group-hover:scale-[1.02]">
            </div>
        </div>
    </div>  

<div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center" style="margin-bottom: 150px;">
                <h2 class="serif text-4xl font-bold text-[#103120] mb-4">Area Wisata Keraton</h2>
                <div class="h-1 w-24 bg-[#E89020] mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($areas as $area)
                <div class="group bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl transition duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="{{ $area['image'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="p-8 text-center">
                        <h3 class="font-bold text-xl text-[#103120] mb-3">{{ $area['title'] }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $area['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-24 bg-[#F5F5F5]">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="serif text-3xl font-bold text-[#103120] text-center mb-12">Informasi Kunjungan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-sm flex items-center gap-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                    <div>
                        <h4 class="font-bold text-xl text-[#103120]">JAM BUKA</h4>
                        <p class="text-gray-600">Senin - Minggu</p>
                        <p class="text-[#E89020] font-bold text-xl">08.00 - 17.00 WIB</p>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm flex items-center gap-6">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    <div>
                        <h4 class="font-bold text-xl text-[#103120]">Fasilitas</h4>
                        <ul class="text-sm text-gray-600 grid grid-cols-2 gap-x-8 gap-y-1 mt-1">
                            <li>• Toilet Bersih</li>
                            <li>• Mushola</li>
                            <li>• Pemandu Wisata</li>
                            <li>• Area Parkir Luas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection