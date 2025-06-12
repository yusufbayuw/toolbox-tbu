<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <style>
        .custom-hover {
            background-color: {{ $variable[1] }}
        }
        .custom-hover:hover {
            background-color: {{ $variable[3] }}
        }
    </style>
    <title>{{ $linkx->name }}</title>
</head>
<body class="min-h-full items-center text-center" style="background-color: {{ $variable[0] }}">
    <div class="p-4 mb-5" style="background-color: {{ $variable[2] }}">
        <h1 class="text-white text-2xl sm:text-4xl font-bold">{{ $linkx->name }}</h1>
    </div>
    <div>
        <ul class="flex flex-wrap justify-center">
            @foreach ($linkx->links as $link)
            <a class="w-full md:w-1/2 p-3 mx-3 my-2 duration-300 items-center rounded-lg drop-shadow-lg hover:ring-transparent hover:ring-4 custom-hover" href="{{$link["link_url"]}}" target="_blank" rel="noopener noreferrer">
                <li>
                    <h1 class="text-xl sm:text-2xl font-bold duration-300 text-slate-50 hover:text-2xl hover:sm:text-3xl drop-shadow-md hover:animate-pulse">{{$link["link_name"]}}</h1>
                    <p class="text-white hover:animate-pulse">{{$link["link_desc"]}}</p>
                </li>
            </a>
            @endforeach
        </ul>
    </div>
</body>
</html>



