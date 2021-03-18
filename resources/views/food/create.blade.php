<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!! __('Food &raquo Create') !!}
        </h2>
    </x-slot>

    <div class="py-12">
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

            <form action="{{ route('food.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="name" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Name </label>
                    <input type="text" value="{{ old('name') }}" name="name" placeholder="Food Name" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="description" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Description </label>
                    <input type="text" value="{{ old('description') }}" name="description" placeholder="Description" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="picturePath" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Image </label>
                    <input type="file" value="{{ old('picturePath') }}" name="picturePath" placeholder="Image" class="block appearance-none w-full bg-gray-200 border-none py-3 px-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="ingredients" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Ingredients </label>
                    <input type="text" value="{{ old('ingredients') }}" name="ingredients" placeholder="Ingredients" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                    <p class="t-gray-500, italic text-xs">Dipisahkan dengan koma, contoh: Bawang Merah, Paprika, Bawang Bombay, Timun</p>
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="price" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Price </label>
                    <input type="number" value="{{ old('price') }}" name="price" placeholder="Price" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="rate" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Rate </label>
                    <input type="number" value="{{ old('rate') }}" name="rate" placeholder="Rate" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <label for="types" class="block uppercase font-bold mb-2 text-gray-700 tracking-wide"> Types </label>
                    <input type="text" value="{{ old('types') }}" name="types" placeholder="types" class="block appearance-none w-full bg-gray-200 border-none py-3 focus:bg-white focus:border-gray-500 border border-gray-300">
                </div>
                <div class="mb-6 flex flex-wrap -mx-1">
                    <div class="text-right w-full">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold px-4 py-2 rounded float-right">Save Food</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>z