<x-guest-layout>
    @foreach ($categories as $category)
        <!-- Header Kategori -->
        <div class="flex items-center justify-between px-6 mt-12 text-center first:mt-0">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
                {{ $category->name }}
            </h2>
            <a href="{{ route('categories.show', $category->id) }}" 
               class="text-md px-3 py-3 bg-green-600 rounded-lg text-white hover:bg-green-800">
               Lihat Selengkapnya >>
            </a>
        </div>

        <!-- Daftar Menu dalam Kategori -->
        <div class="container w-full px-5 py-6 mx-auto">
            <div class="grid lg:grid-cols-4 gap-y-6">
                @forelse ($category->menus as $menu)
                    <div class="max-w-xs mx-4 mb-2 rounded-lg shadow-lg">
                        <img class="w-full h-48 object-cover rounded-t-lg" 
                             src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" />
                        <div class="px-2 py-2">
                            <h4 class="mb-2 text-xl font-semibold tracking-tight text-green-600 uppercase">
                                {{ $menu->name }}
                            </h4>
                            <div class="flex items-center justify-between">
                                <span class="text-lg text-red-600 font-bold">
                                    Rp. {{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-8">
                        Belum ada menu untuk kategori ini.
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
</x-guest-layout>