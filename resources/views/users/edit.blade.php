<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User » ' . $user->name . ' » Edit') }}
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
            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" class="w-100">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Name
                        </label>
                        <input value="{{ old('name') ?? $user->name }}" type="text" name="name" placeholder="User Name" id="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="email" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Email
                        </label>
                        <input value="{{ old('email') ?? $user->email }}" type="email" name="email" id="email" placeholder="User Email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="image" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Image
                        </label>
                        <input type="file" name="profile_photo_path" id="image" placeholder="User Image" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="password" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Password
                        </label>
                        <input type="password" name="password" id="password" placeholder="User Password" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="password_confirmation" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Password Confirmation
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="User Password Confirmation" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="address" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Address
                        </label>
                        <input value="{{ old('address') ?? $user->address }}" type="text" name="address" id="address" placeholder="User Address" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="roles" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Roles
                        </label>
                        <select name="roles" id="roles" placeholder="User Roles" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="USER" {{ old('roles') ?? $user->roles == 'USER' ? 'selected' : '' }}>USER</option>
                            <option value="ADMIN" {{ old('roles') ?? $user->roles == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="house_number" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            House Number
                        </label>
                        <input value="{{ old('house_number') ?? $user->house_number }}" type="text" name="house_number" id="house_number" placeholder="User House Number" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="phone_number" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Phone Number
                        </label>
                        <input value="{{ old('phone_number') ?? $user->phone_number }}" type="text" name="phone_number" id="phone_number" placeholder="User Phone Number" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="city" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            City
                        </label>
                        <input value="{{ old('city') ?? $user->city }}" type="text" name="city" id="city" placeholder="User City" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" >
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 text-right">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Update User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
