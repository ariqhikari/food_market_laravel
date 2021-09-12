<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Food » Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div>
                @if ($errors->any())
                    <div class="mb-5" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <form action="{{ route('food.store') }}" method="POST" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Name
                        </label>
                        <input value="{{ old('name') }}" type="text" name="name" placeholder="Food Name" id="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="image" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Image
                        </label>
                        <input type="file" name="picture_path" id="image" placeholder="Food Image" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="description" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" placeholder="Food Description" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="ingredients" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Ingredients
                        </label>
                        <input value="{{ old('ingredients') }}" type="text" name="ingredients" placeholder="Food Ingredients" id="ingredients" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                        <p class="text-grey-600 text-xs italic">Dipisahkan dengan koma, contoh: Bawang Merah, Paprika, Bawang Bombay, Timun</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="price" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Price
                        </label>
                        <input value="{{ old('price') }}" type="number" name="price" placeholder="Food Price" id="price" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="rate" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Rate
                        </label>
                        <input value="{{ old('rate') }}" type="number" name="rate" placeholder="Food Rate" step="0.01" max="5" id="rate" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="types" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Types
                        </label>
                        <input value="{{ old('types') }}" type="text" name="types" placeholder="Food Types" id="types" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                        <p class="text-grey-600 text-xs italic">Dipisahkan dengan koma, contoh: recommended, popular, new_food</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 text-right">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Save Food
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
