<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('user.create')}}" class="bg-green-500 hover:bg-green-700 text-white font-bold rounded px-4 py-2">
                    + Create User
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border px-6 py-4">ID</th>
                            <th class="border px-6 py-4">Name</th>
                            <th class="border px-6 py-4">Email</th>
                            <th class="border px-6 py-4">Roles</th>
                            <th class="border px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        @forelse ($users as $user)
                            <tr>
                                <td class="border px-6 py-4">{{ $i++ }}</td>
                                <td class="border px-6 py-4">{{ $user->name }}</td>
                                <td class="border px-6 py-4">{{ $user->email }}</td>
                                <td class="border px-6 py-4">{{ $user->roles }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('user.edit', $user->id) }}" class="inline-block px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded font-bold mr-5">Edit</a>
                                    <form action="{{ route('user.destroy', $user->id)}}" method="post" class="inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 font-bold rounded">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan='5' class="border text-center">Data Masih Kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- unutk pagination --}}
            <div class="text-center mt-5">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>