<x-guest-layout>
    <!-- Main Hero Content -->
    <div class="container max-w-lg px-4 py-32 mx-auto text-left bg-center bg-no-repeat bg-cover md:max-w-none md:text-center relative"
    style="background-image: url('https://cdn.pixabay.com/photo/2016/11/18/14/39/beans-1834984_960_720.jpg')">
    <!-- Overlay gelap -->
        <div class="absolute inset-0 bg-black/50"></div>
        <!-- Konten dengan z-index -->
        <div class="relative z-10">
            <h1 class="font-mono text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500 md:text-center sm:leading-none lg:text-5xl">
                <span class="inline md:block">Welcome To Famires</span>
            </h1>
            <div class="mx-auto mt-2 text-green-50 md:text-center lg:text-lg">
                Nikmati momen kebersamaan keluarga dengan pilihan area dalam (Front) yang hangat atau area luar (Inside) yang asri. 
                Reservasi mudah, menu lezat, dan suasana ramah anak.
            </div>
            <div class="flex flex-col items-center mt-12 text-center">
                <span class="relative inline-flex w-full md:w-auto">
                    <a href="{{ route('reservations.step.one') }}" type="button"
                        class="inline-flex items-center justify-center px-6 py-2 text-base font-bold leading-6 text-white bg-green-600 rounded-full lg:w-full md:w-auto hover:bg-green-500 focus:outline-none">
                        Make your Reservation
                    </a>
                </span>
            </div>
        </div>
    </div>
    <!-- End Main Hero Content -->
     <section class="bg-white mt-24">
        <div class="mt-4 text-center">
            <h3 class="text-2xl font-bold">Our Menu</h3>
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
                TODAY'S SPECIALITY</h2>
        </div>
        <div class="container w-full px-5 py-6 mx-auto">
            <div class="grid lg:grid-cols-4 gap-y-6">
                @foreach ($specials->menus as $special)    
                <div class="max-w-xs mx-4 mb-2 rounded-lg shadow-lg">
                    <img class="w-full h-48" src="{{ Storage::url($special->image) }}" alt="Image" />
                    <div class="px-2">
                        <h4 class="mb-3 text-xl font-semibold tracking-tight text-gray-600 uppercase">
                            {{ $special->name }}</h4>
                    </div>
                    <div class="flex items-center justify-between px-2 pb-4">
                        <span class="text-xl text-red-400">Rp. {{ $special->price }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

   <section class="px-2 mt-8 bg-white md:px-0">
        <div class="container items-center max-w-6xl px-8 mx-auto xl:px-5">
            <div class="flex flex-wrap items-center sm:-mx-3">
                <div class="w-full md:w-1/2 md:px-3">
                    <div class="w-full pb-6 space-y-4 sm:max-w-md lg:max-w-lg lg:space-y-4 lg:pr-0 md:pb-0">
                        <h3 class="text-xl text-green-600 font-semibold">OUR STORY</h3>
                        <h2 class="text-4xl text-gray-800">Tentang Famires</h2>
                        <p class="mx-auto text-base text-gray-500 sm:max-w-md lg:text-lg md:max-w-3xl">
                            Famires lahir dari sebuah mimpi sederhana: menciptakan restoran keluarga di mana setiap anggota, dari balita hingga kakek-nenek, bisa merasa nyaman dan bahagia. Kami percaya bahwa makan bersama adalah momen berharga, maka kami menyediakan dua pilihan suasana:
                            <strong class="text-green-600">Front</strong> (area dalam ber-AC) untuk keluarga yang menginginkan ketenangan dan privasi, serta 
                            <strong class="text-green-600">Inside</strong> (area luar dengan taman) bagi yang suka udara segar sambil anak-anak bermain.
                        </p>
                        <p class="mx-auto text-base text-gray-500 sm:max-w-md lg:text-lg md:max-w-3xl">
                            Setiap resep kami terinspirasi dari masakan rumahan yang sehat dan bergizi. Dengan layanan reservasi online yang mudah, Famires ingin menjadi tempat favorit untuk merayakan kebersamaan.
                        </p>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="w-full h-auto overflow-hidden rounded-md shadow-xl sm:rounded-xl">
                        <img src="https://cdn.pixabay.com/photo/2017/08/03/13/30/people-2576336_960_720.jpg" 
                            alt="Keluarga bahagia di Famires" 
                            class="object-cover w-full h-96">
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <section class="py-20 bg-gray-50 mt-8">
        <div class="container items-center max-w-6xl px-4 px-10 mx-auto sm:px-20 md:px-32 lg:px-16">
            <div class="flex flex-wrap items-center -mx-3">
                <div class="order-1 w-full px-3 lg:w-1/2 lg:order-0">
                    <div class="w-full lg:max-w-md">
                        <h2 class="mb-4 text-2xl font-bold">About Us</h2>
                        <h2
                            class="mb-4 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
                            WHY CHOOSE US?</h2>

                        <p class="mb-4 font-medium tracking-tight text-gray-400 xl:mb-6"><p class="mb-4 font-medium tracking-tight text-gray-400 xl:mb-6">
                            Famires dirancang khusus untuk keluarga. Anda bisa memilih suasana sesuai keinginan: 
                            <strong>Front</strong> (meja dalam) yang nyaman ber-AC atau <strong>Inside</strong> (meja luar) yang sejuk dengan taman kecil. 
                            Kami menyediakan kursi bayi, menu anak, area bermain, dan layanan reservasi instan.
                        </p>
                        <ul>
                            <li class="flex items-center py-2 space-x-4 xl:py-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="font-medium text-gray-500">Pilihan Area Dalam & Luar (Front & Inside)</span>
                            </li>
                            <li class="flex items-center py-2 space-x-4 xl:py-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium text-gray-500">Reservasi Online Cepat & Tanpa Ribet</span>
                            </li>
                            <li class="flex items-center py-2 space-x-4 xl:py-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium text-gray-500">Menu Ramah Anak & Harga Terjangkau</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full px-3 mb-12 lg:w-1/2 order-0 lg:order-1 lg:mb-0">
                    <img
                        class="mx-auto sm:max-w-sm lg:max-w-full"
                        src="https://cdn.pixabay.com/photo/2020/12/31/12/28/cook-5876388_960_720.png"
                        alt="feature image">
                </div>
            </div>
        </div>
    </section>
    
    <section class="pt-4 pb-12 bg-gray-800 mt-8">
        <div class="my-16 text-center">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
                Testimonial </h2>
            <p class="text-xl text-white">Apa kata mereka yang sudah merasakan pengalaman bersantap di Famires</p>
        </div>
        <div class="grid gap-2 lg:grid-cols-3 px-6">
           <div class="max-w-md p-4 bg-white rounded-lg shadow-lg">
                <div class="flex justify-center -mt-16 md:justify-end">
                    <img class="object-cover w-20 h-20 border-2 border-green-500 rounded-full"
                        src="https://cdn.pixabay.com/photo/2018/01/18/17/48/purchase-3090818__340.jpg">
                </div>
                <div>
                    <h2 class="text-3xl font-semibold text-gray-800">Menu Anak Juara!</h2>
                    <p class="mt-2 text-gray-600">“Anak saya yang susah makan habis chicken tenders dan pasta-nya. 
                    Harga bersahabat, porsinya pas. Kami sudah tiga kali ke Famires.”</p>
                </div>
                <div class="flex justify-end mt-4">
                    <a href="#" class="text-xl font-medium text-green-500">Ahmad Zaki</a>
                </div>
            </div>
            <div class="max-w-md p-4 bg-white rounded-lg shadow-lg">
                <div class="flex justify-center -mt-16 md:justify-end">
                    <img class="object-cover w-20 h-20 border-2 border-green-500 rounded-full"
                        src="https://cdn.pixabay.com/photo/2018/01/04/21/15/young-3061652__340.jpg">
                </div>
                <div>
                    <h2 class="text-3xl font-semibold text-gray-800">Nyaman di Area Inside</h2>
                    <p class="mt-2 text-gray-600">“Kami memilih area inside karena butuh AC untuk bayi. Staf menyediakan high chair dan menu anak. 
                    Makan malam jadi menyenangkan tanpa drama.”</p>
                </div>
                <div class="flex justify-end mt-4">
                    <a href="#" class="text-xl font-medium text-green-500">Sarah Wijaya</a>
                </div>
            </div>
            <div class="max-w-md p-4 bg-white rounded-lg shadow-lg">
                <div class="flex justify-center -mt-16 md:justify-end">
                    <img class="object-cover w-20 h-20 border-2 border-green-500 rounded-full"
                        src="https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80">
                </div>
                <div>
                    <h2 class="text-3xl font-semibold text-gray-800">Area Inside Favorit!</h2>
                    <p class="mt-2 text-gray-600">“Anak-anak senang bermain di halaman kecil area Inside, sementara kami makan tenang. 
                    Suasananya adem dan tidak panas. Reservasi via website sangat praktis.”</p>
                </div>
                <div class="flex justify-end mt-4">
                    <a href="#" class="text-xl font-medium text-green-500">Budi & Keluarga</a>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>