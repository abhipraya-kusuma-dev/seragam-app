@extends('layout.main')

@section('content')
    <div class="h-screen flex justify-center bg-white items-center ">
        <div class="login-container border border-gray-200 py-20 px-20 shadow-xl rounded-xl">
            <div class="content-container flex flex-col  ">
                <h1 class="font-semibold text-2xl mb-6">Seragam <span class="bg-[#FF4343] text-white">Apps</span></h1>

                <form action="/login" method="POST" class="flex flex-col ">
                    @csrf
                    <input class="bg-gray-200 border border-2 border-gray-400 rounded w-48 p-1 mb-3 px-3" type="text"
                        placeholder="Username" name="name">
                    <input class="bg-gray-200 border border-2 border-gray-400 rounded w-48 p-1 px-3" type="password"
                        placeholder="Password" name="password">
                    <button
                        class="mt-10 w-full pb-1 bg-[#FF4343] text-white font-semibold text-xl shadow-md border rounded">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
