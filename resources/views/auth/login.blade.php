<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('icon.svg') }}">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="h-screen flex justify-center bg-white items-center ">
        <div class="login-container border border-gray-200 py-16 px-20 shadow-xl rounded-xl">
            <div class="content-container flex flex-col  ">
                <h1 class="font-semibold text-2xl mb-6">Seragam <span class="bg-[#FF4343] text-white">Apps</span></h1>

                    
                <form action="/login" method="POST" class="flex flex-col">
                    @csrf
                    @error('password')
                        <div id="errMsg" class="text-red-600 alert alert-danger">Password salah*</div>    
                    @enderror
                    @error('name')
                        <div id="errMsg" class="text-red-600 alert alert-danger">Username tidak ditemukan*</div>    
                    @enderror
                    
                    <input id="username" class="bg-gray-200 border border-2 border-gray-400 rounded w-48 p-1 mb-3 px-3" type="text"
                        placeholder="Username" name="name">
                    <input id="password" class="bg-gray-200 border border-2 border-gray-400 rounded w-48 p-1 px-3" type="password"
                        placeholder="Password" name="password">
                    <marquee class="select-none w-48">kunci kesehatan cuman satu, yaitu jangan sakit😘</marquee>
                    <button
                        id="login-button" class="mt-8 w-48 pb-1 bg-[#FF4343] text-white font-semibold text-xl shadow-md border rounded">Login</button>
                </form>
                <div class="flex flex-col w-48 items-center mt-3 justify-center">
                    <span class=" text-xs  text-gray-400">Sekolah Wijaya Kusuma</span>
                    <span class=" text-xs  text-gray-400">&copy;Abhiprayakusuma-Dev.2024</span>
                </div>
            </div>
        </div>
    </div>
</body>

    <script>
        document.getElementById('login-button').addEventListener('click', function(e){

            const username = document.getElementById('username');
            const password = document.getElementById('password');

            let fulfilled = username.value != '' && password.value != '';

            if(!fulfilled){
                alert('Harap isi Username dan Password');
                e.preventDefault();
            }
            
            
        });
    </script>

