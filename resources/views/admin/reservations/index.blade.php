<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between px-6 pt-6 text-gray-900 dark:text-gray-100">
                    <div>Reservations</div>
                    <div><a href="{{ route('admin.reservations.create') }}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Create</a></div>
                </div>
                <div class="flex justify-between items-center p-6">
                    {{-- Search Form --}}
                    <form method="GET" action="{{ route('admin.reservations.index') }}" class="flex">
                        <input 
                            type="text" 
                            name="search"  
                            placeholder="Search by name or email..." 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 transition"
                        >
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.reservations.index') }}" class="ml-2 px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone Number
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Time
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Table
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Guest Number
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $reservation->first_name }} {{ $reservation->last_name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $reservation->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $reservation->phone_number }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('H:i') }}
                                </td>
                            
                                @if ($reservation->table->name)
                                <td class="px-6 py-4">
                                    {{ $reservation->table->name }}
                                </td>
                                @else
                                <td class="px-6 py-4">
                                    Table does not exist
                                </td>
                                @endif
                                <td class="px-6 py-4">
                                    {{ $reservation->guest_number }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex">
                                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg text-white">Edit</a>
                                        <form 
                                            class="px-4 py-2 ml-2 bg-red-500 hover:bg-red-700 rounded-lg text-white" 
                                            method="POST" 
                                            action="{{ route('admin.reservations.destroy', $reservation->id) }}" 
                                            onSubmit="return confirm('Are you sure ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
