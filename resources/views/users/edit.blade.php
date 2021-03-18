<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('User &raquo Edit &raquo') !!} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-5 bg-red-500 text-white font-bold rounded px-4 py-2" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.update', $user->id)}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="name" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Name </label>
                    <input type="text" value="{{ old('name') ?? $user->name }}" name="name" placeholder="Full Name" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="email" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Email </label>
                    <input type="email" value="{{ old('email') ?? $user->email }}" name="email" placeholder="Email" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="profile_photo_path" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Image </label>
                    <input type="file" disabled name="profile_photo_path" placeholder="Image" class="block appearance-none w-full bg-gray-100 border-none py-3 px-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="password" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Password </label>
                    <input type="password" disabled name="password" placeholder="Password" class="block appearance-none w-full bg-gray-100 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="password_confirmation" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> password confirmation </label>
                    <input type="password" disabled name="password_confirmation" placeholder="Password Confirmation" class="block appearance-none w-full bg-gray-100 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="address" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> address </label>
                    <input type="text" value="{{ old('address') ?? $user->address }}" name="address" placeholder="Address" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="roles" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> roles </label>
                    <select value="{{ old('roles') ?? $user->roles }}" name="roles" placeholder="Roles" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                        <option value="{{ $user->roles }}">{{ $user->roles }}</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="USER">USER</option>
                    </select>
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="houseNumber" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> House Number </label>
                    <input type="number" value="{{ old('houseNumber') ?? $user->houseNumber }}" name="houseNumber" placeholder="House Number" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="phoneNumber" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Phone Number </label>
                    <input type="number" value="{{ old('phoneNumber') ?? $user->phoneNumber }}" name="phoneNumber" placeholder="Phone Number" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="city" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> City </label>
                    <input type="text" value="{{ old('city') ?? $user->city }}" name="city" placeholder="City" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <div class="text-right w-full">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold px-4 py-2 rounded float-right">Save Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>