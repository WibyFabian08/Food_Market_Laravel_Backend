<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Foods') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('food.create')}}" class="bg-green-500 hover:bg-green-700 text-white font-bold rounded px-4 py-2">
                    + Create Food
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border px-6 py-4">ID</th>
                            <th class="border px-6 py-4">Name</th>
                            <th class="border px-6 py-4">Price</th>
                            <th class="border px-6 py-4">Rate</th>
                            <th class="border px-6 py-4">Types</th>
                            <th class="border px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        @forelse ($foods as $food)
                            <tr>
                                <td class="border px-6 py-4">{{ $i++ }}</td>
                                <td class="border px-6 py-4">{{ $food->name }}</td>
                                <td class="border px-6 py-4 text-right">Rp. {{ number_format($food->price) }}</td>
                                <td class="border px-6 py-4 text-center">{{ $food->rate }}</td>
                                <td class="border px-6 py-4">{{ $food->types }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('food.edit', $food->id) }}" class="inline-block px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded font-bold mr-5">Edit</a>
                                    <form action="{{ route('food.destroy', $food->id)}}" method="post" class="inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 font-bold rounded">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan='6' class="border text-center py-4 font-bold">Data Masih Kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- unutk pagination --}}
            <div class="text-center mt-5">
                {{ $foods->links() }}
            </div>
        </div>
    </div>
</x-app-layout>