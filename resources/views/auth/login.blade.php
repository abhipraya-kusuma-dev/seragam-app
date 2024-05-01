@extends('layout.main')

@section('content')
    <div class="h-screen flex justify-center bg-white items-center">
        <div class="login-container border border-gray-200 w-72 h-80 shadow-xl">
            <div class="content-container flex flex-col items-center mt-7">
                <h1 class="font-semibold text-2xl mb-6">Seragam <span class="bg-orange-400 text-white">Apps</span></h1>

                <form action="/login" method="POST" class="flex flex-col items-center">
                    @csrf
                    <input class="bg-gray-200 border border-2 border-gray-400 rounded w-48 p-1 mb-3" type="text"
                        placeholder="Username" name="name">
                    <input class="bg-gray-200 border border-2 border-gray-400 rounded w-48 p-1" type="password"
                        placeholder="Password" name="password">
                    <button
                        class="mt-10 w-20 pb-1 bg-orange-400 text-white font-semibold text-xl shadow-md border">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
