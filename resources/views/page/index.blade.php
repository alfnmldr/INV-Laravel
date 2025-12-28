<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard - Admin</title>
    <style>
        body {
            background-color: #131313;
            scroll-behavior: smooth;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 49;
            display: none;
        }

        .modal-open .modal-overlay {
            display: block;
        }

        ::-webkit-scrollbar {
            width: 10px;
            }

        ::-webkit-scrollbar-thumb {
            background: #B4B4B8;
            border-radius: 10px;
        }

        .status-approved {
            color: #029437; /* Hijau */
        }
        .status-pending {
            color: #facc15; /* Kuning */
        }
        .status-rejected {
            color: #ef4444; /* Merah */
        }

        /* Status */
        .status-approved {
            color: #029437;
        }
        .status-pending {
            color: #facc15;
        }
        .status-rejected {
            color: #ef4444;
        }

        /* Default sidebar */
        #logo-sidebar {
            color: white;
            transition: color 0.3s ease;
        }

        body.light-theme #logo-sidebar {
            color: black;
        }


    </style>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/da509c75-7411-4882-9c23-ee77089c6054-Photoroom.png')}}">
</head>
<body>
    
        @php
        $startDate = request('start_date');
        $endDate = request('end_date');
        $searchQuery = request('query');

        $filteredData = \App\Models\Barang::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('tgl_insert', [$startDate, $endDate]);
            })
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('nama_barang', 'like', "%{$searchQuery}%");
            })
            ->get();
        @endphp


        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>
        
        {{-- sidebar --}}
        <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-5 py-6 overflow-y-auto" style="background-color: #000000;">
            <a href="{{ route('index') }}" class="flex items-center ps-2.5 mb-5">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white"><img src="{{asset('image/Adobe Express - file.png')}}" alt=""></span>
            </a>
            <ul>
                    <button class="text-white bg-green-600/90 rounded-md hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        <a href="{{ route('index') }}" class="flex items-center justify-center gap-4">
                           <svg class="w-6 h-6 text-white dark:text-white" fill="white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                            </svg>
                        Home
                        </a>
                    </button>
                </li>
            <ul class="space-y-2 font-medium">
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        <svg class="w-6 h-6 text-white dark:text-white" fill="white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 8H4m8 3.5v5M9.5 14h5M4 6v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z"/>
                        </svg>
                        Tambah Barang
                    </button>
                </li>
                <li>
                    <button class="text-white hover:bg-blue-400 focus:ring-4 text-sm focus:outline-none rounded-md focus:ring-blue-300 font-medium px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M6 5a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L15.249 6H19a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2v-5a3 3 0 0 0-3-3h-3.22l-1.14-1.682A3 3 0 0 0 9.157 6H6V5Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M3 9a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L12.249 10H3V9Zm0 3v7a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-7H3Z" clip-rule="evenodd"/>
                        </svg>
                        <a href="#" onclick="openModal('barangKeluarModal')">Keluarkan Barang</a>
                    </button>
                </li>
               <li>
                    <button class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-xs items-center px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M6 5a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L15.249 6H19a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2v-5a3 3 0 0 0-3-3h-3.22l-1.14-1.682A3 3 0 0 0 9.157 6H6V5Z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M3 9a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L12.249 10H3V9Zm0 3v7a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-7H3Z" clip-rule="evenodd"/>
                        </svg>
                    <a href="{{route('barang.out')}}">Data Barang Keluar</a>
                    </button>
                </li>
                <li>
                    <button class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm2-2a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm0 3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm-6 4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-6Zm8 1v1h-2v-1h2Zm0 3h-2v1h2v-1Zm-4-3v1H9v-1h2Zm0 3H9v1h2v-1Z" clip-rule="evenodd"/>
                        </svg>
                        <a href="{{ route('fotos.index') }}">Data Foto</a>
                    </button>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="text-white hover:bg-blue-400 absolute bottom-4  focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-md font-medium text-sm px-5 py-2.5 text-center w-fit flex gap-4 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-6 h-6 text-white dark:text-white" fill="white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.757 6 3.24 10.95a1.05 1.05 0 0 0 0 1.549l5.611 5.088m5.73-3.214v1.615a.948.948 0 0 1-1.524.845l-5.108-4.251a1.1 1.1 0 0 1 0-1.646l5.108-4.251a.95.95 0 0 1 1.524.846v1.7c3.312 0 6 2.979 6 6.654v1.329a.7.7 0 0 1-1.345.353 5.174 5.174 0 0 0-4.652-3.191l-.003-.003Z"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        </aside>


        @if (session('success'))
            <div id="alert-success" class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="alert-error" class="alert">
                {{ session('error') }}
            </div>
        @endif
                {{-- top table content --}}
                <div class="p-4 sm:ml-64">
                    <div class="p-4">
                        <div class="gap-4 mb-4 w-5/6 m-auto sm:scroll">
                        {{-- canvas for graphic --}}
                        <canvas id="barangMasukChart" width="400" height="100"></canvas>
                            {{--table data section  --}}
                            <div class="inline p-4 h-auto mb-4 rounded-lg lg:w-3/4 w-auto md:w-auto sm:w-auto mx-auto mt-48">
                                <div class="flex flex-col lg:flex-row justify-between items-center">
                                                <!-- Bagian Pencarian -->
                                                <div class="flex items-center justify-center h-24 rounded">
                                                    <form class="flex items-center" method="GET">
                                                        <!-- Search by Item Name -->
                                                        <label for="simple-search" class="sr-only">Search</label>
                                                        <div class="relative w-full">
                                                            <input type="text" name="query" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" placeholder="Cari Nama Barang..." required />
                                                        </div>
                                                        <button type="submit" class="p-3 ms-2 text-sm font-medium text-white rounded-lg" style="background-color: #4E9F3D;">
                                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                                            </svg>
                                                            <span class="sr-only">Search</span>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Bagian Filter Tanggal -->
                                                <div class="flex items-center justify-center h-24 rounded mt-4 lg:mt-0">
                                                    <form method="GET" class="flex items-center flex-wrap lg:flex-nowrap gap-2">
                                                        <!-- Filter by Date Range -->
                                                        <label for="start_date" class="text-white">Start</label>
                                                        <input type="date" name="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600">

                                                        <label for="end_date" class="text-white">End</label>
                                                        <input type="date" name="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600">

                                                        <!-- Filter Button -->
                                                        <button class="p-2 w-24 rounded-md text-white" style="background-color:#4E9F3D;">Filter</button>

                                                        <!-- Reset Button -->
                                                        <a href="{{ route('index') }}" class="p-2 w-max text-md rounded-md bg-gray-500 hover:bg-gray-600 text-center" style="color: #fff;">Reset Filter</a>
                                                    </form>
                                                </div>

                                                <!-- Bagian Selamat Datang -->
                                                <div class="flex items-center justify-center sm:none h-24 rounded">
                                                    <p class="hidden lg:block lg:text-4xl md:text-3xl" style="font-family: 'Pacifico'; font-weight: 500; color:#4E9F3D;">
                                                        <span class="font-poppins font-semibold">Welcome, </span>{{ Auth::user()->username }}!
                                                    </p>
                                                </div>
                                            </div>


                                            {{-- ALERT FOR ALL DATA --}}
                                            @if (session('success'))
                                                <div id="success-alert" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 relative" role="alert">
                                                    <span class="font-medium">Berhasil!</span> {{ session('success') }}
                                                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#success-alert" aria-label="Close">
                                                        <span class="sr-only">Close</span>
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif


                                            @if ($errors->any())
                                                <div id="error-alert" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 relative" role="alert">
                                                    <span class="font-medium">Error!</span> {{ $errors->first() }}
                                                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#error-alert" aria-label="Close">
                                                        <span class="sr-only">Close</span>
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        <table class="w-full text-sm text-center h-full rtl:text-right text-white">
                                                <thead class="text-md text-white text-center capitalize">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3">ID Barang</th>
                                                        <th scope="col" class="px-6 py-3">Kode Barang</th>
                                                        <th scope="col" class="px-6 py-3">Nama Barang</th>
                                                        <th scope="col" class="px-6 py-3">Tanggal Penambahan</th>
                                                        <th scope="col" class="px-6 py-3">Stok</th>
                                                        <th scope="col" class="px-6 py-3">Sumber</th>
                                                        <th scope="col" class="px-6 py-3">Kondisi</th>
                                                        <th scope="col" class="px-6 py-3 hidden">ID Lokasi</th>
                                                        <th scope="col" class="px-6 py-3">Lokasi Barang</th>
                                                        <th scope="col" class="px-6 py-3">Status</th>
                                                        <th scope="col" class="px-6 py-3">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($filteredData->isEmpty())
                                                    <tr>
                                                        <td colspan="10" class="px-6 py-4 text-center text-red-500">
                                                            Data Tidak Tersedia.
                                                        </td>
                                                    </tr>
                                                    @else
                                                    @foreach($filteredData as $item)
                                                    <tr class="border-b text-white text-md capitalize rounded-lg dark:border-gray-700 hover:bg-green-600 dark:hover:bg-gray-600">
                                                        <th scope="row" class="px-6 py-6 font-medium text-white whitespace-nowrap dark:text-white">
                                                            {{ $item->id }}
                                                        </th>
                                                        <td class="px-4 py-3">
                                                            {{ $item->kode_barang }}
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            {{ $item->nama_barang }}
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            {{ \Carbon\Carbon::parse($item->tgl_insert)->format('d-m-Y') }}
                                                        </td>
                                                        <td class="px-4 py-3 {{ $item->jumlah < 3 ? 'text-rose-700 text-lg font-bold' : '' }}">
                                                            {{ $item->jumlah }}
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            {{ $item->sumber }}
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            {{ $item->kondisi }}
                                                        </td>
                                                        <td class="px-4 py-3 hidden">
                                                            {{ $item->id_lokasi }}
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            {{ $item->lokasi->nama_lokasi ?? 'Lokasi tidak ditemukan' }}
                                                        </td>
                                                        <td class="px-4 py-3 
                                                            {{ $item->status == 'Approved' ? 'status-approved' : '' }}
                                                            {{ $item->status == 'Pending' ? 'status-pending' : '' }}">
                                                            {{ ucfirst($item->status) }}
                                                        </td>
                                                        <td class="px-4 py-3 text-center flex gap-3 align-middle justify-center">
                                                            <!-- Tombol Edit -->
                                                            <a href="javascript:void(0);" 
                                                                class="font-medium text-gray-600 hover:bg-yellow-500 transition-all dark:text-blue-500 hover:underline bg-yellow-300 p-3 rounded-md {{ $item->status != 'Revisi' && $item->status != 'Approved' ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                                                onclick="openEditModal({{ $item->id }}, '{{ $item->kode_barang }}', '{{ $item->nama_barang }}', '{{ $item->tgl_insert }}', '{{ $item->jumlah }}', '{{ $item->sumber }}', '{{ ucfirst($item->kondisi) }}', '{{ $item->id_lokasi }}')">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white hover:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                                                </svg>
                                                            </a>
                                                            
                                                            <!-- Tombol Hapus -->
                                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="font-medium text-white dark:text-blue-500 transition-all hover:underline bg-red-600 hover:bg-red-800 p-3 rounded-md {{ $item->status != 'Revisi' && $item->status != 'Approved' ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- modals for add data --}}
                            <div id="crud-modal-overlay" class="modal-overlay"></div>
                                <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] bg-black/80 h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-gray-200 rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Tambah Barang
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-5">
                                                @csrf
                                                <div class="grid gap-4 mb-4 grid-cols-2">
                                                    <div class="col-span-2">
                                                        <label for="kode_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Barang</label>
                                                        <input type="text" name="kode_barang" id="kode_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Kode Barang" required="">
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Barang</label>
                                                        <input type="text" name="nama_barang" id="nama_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama Barang" required="">
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label for="tgl_insert" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Masuk</label>
                                                        <input type="date" name="tgl_insert" id="tgl_insert" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label for="foto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Barang</label>
                                                        <input type="file" name="foto" id="foto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                        <p class="ml-1 text-sm mt-1">Max size : 2048 Megabyte</p>
                                                    </div>
                                                    <div class="col-span-2 sm:col-span-1">
                                                        <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                                                        <input type="number" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Jumlah" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required="">
                                                    </div>
                                                    <div class="col-span-2 sm:col-span-1">
                                                        <label for="sumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sumber</label>
                                                        <select name="sumber" id="sumber" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                            <option value="">Pilih Sumber</option>
                                                            <option value="Beli">Beli</option>
                                                            <option value="Hibah">Hibah</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label for="kondisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Barang</label>
                                                        <select name="kondisi" id="kondisi" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                            <option value="Baik">Baik</option>
                                                            <option value="Rusak">Rusak</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label for="id_lokasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi Barang</label>
                                                        <select name="id_lokasi" id="id_lokasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                            <option value="">Pilih Lokasi</option>
                                                            @foreach($lokasi as $lok)
                                                                <option value="{{ $lok->id_lokasi }}">{{ $lok->nama_lokasi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    Tambahkan Barang
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            {{-- for edit data --}}
                            <div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden flex justify-center items-center fixed top-0 right-0 left-0 z-50 w-full md:inset-0 min-h-screen bg-black/80">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-gray-200 rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Edit Barang
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeEditModal()">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                    <form id="edit-form" action="{{ route('barang.update', ['id' => '$id']) }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-5">
                                            @csrf
                                            @method('PUT')
                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                <div class="col-span-2">
                                                    <label for="edit_kode_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Barang</label>
                                                    <input type="text" name="kode_barang" id="edit_kode_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_nama_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Barang</label>
                                                    <input type="text" name="nama_barang" id="edit_nama_barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_tgl_insert" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Masuk</label>
                                                    <input type="date" name="tgl_insert" id="edit_tgl_insert" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="edit_foto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Barang</label>
                                                    <input type="file" name="foto" id="edit_foto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <p class="ml-1 text-sm mt-1">Max size : 2048 Megabyte</p>
                                                </div>
                                                <div class="col-span-2 sm:col-span-1">
                                                    <label for="edit_jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                                                    <input type="number" name="jumlah" id="edit_jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required="">
                                                </div>
                                                <div class="col-span-2 sm:col-span-1">
                                                    <label for="edit_sumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sumber</label>
                                                        <select name="sumber" id="edit_sumber" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                            <option value="">Pilih Sumber</option>
                                                            <option value="Beli">Beli</option>
                                                            <option value="Hibah">Hibah</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-span-2">
                                                        <label for="edit_kondisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi Barang</label>
                                                        <select name="kondisi" id="edit_kondisi" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                            <option value="Baik">Baik</option>
                                                            <option value="Rusak">Rusak</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label for="nama_lokasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi Barang</label>
                                                        <select name="id_lokasi" id="edit_nama_lokasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                            @php
                                                            $count = 0;
                                                            @endphp
                                                            @foreach($lokasi as $lok)
                                                            <option value="{{ $lok->id_lokasi }}" {{ $count == 0 ? 'selected' : '' }}>{{ $lok->nama_lokasi }}</option>
                                                            @php
                                                            $count += 1;
                                                            @endphp
                                                   
                                                            @endforeach
                                                        </select>
                                                    </div>
                                            </div>
                                            <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Update Barang
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        {{-- modals for barang keluar --}}
                        <div class="container mx-auto">
                            <div id="barangKeluarModal" class="hidden fixed inset-0 bg-black/90 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
                                <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
                                    <h3 class="text-lg font-bold mb-4">Barang Keluar</h3>
                                    <form id="barangKeluarForm">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Kode Barang</label>
                                            <select name="id" id="kd_barang" class="w-full p-2 border rounded-md" required>
                                                @foreach($barangMasuk as $barang)
                                                    @if($barang->status === 'Approved')
                                                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                            <input type="number" name="jumlah" id="jumlah" class="w-full p-2 border rounded-md" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Tanggal Keluar</label>
                                            <input type="date" name="tgl_keluar" id="tgl_keluar" class="w-full p-2 border rounded-md" required>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="button" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded-md" onclick="closeModal('barangKeluarModal')">Batal</button>
                                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        

                        <script>
                            document.getElementById('barangKeluarForm').addEventListener('submit', function(event) {
                                event.preventDefault(); 

                                let formData = new FormData(this);

                                fetch('{{ route('barang-keluar.store') }}', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.error) {
                                        // Tampilkan alert jika ada error
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.error,
                                        });
                                    } else {
                                        // Tampilkan alert sukses
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sukses',
                                            text: data.success,
                                        });

                                        // Tutup modal
                                        closeModal('barangKeluarModal');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Terjadi kesalahan pada server!',
                                    });
                                });
                            });

                            function closeModal(modalId) {
                                document.getElementById(modalId).classList.add('hidden');
                            }
                        </script>


                            <script>
                                function openModal(modalId) {
                                    document.getElementById(modalId).classList.remove('hidden');
                                }

                                function closeModal(modalId) {
                                    document.getElementById(modalId).classList.add('hidden');
                                }
                            </script>

                            <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

                        <script>
                            setTimeout(function() {
                                let successAlert = document.getElementById('success-alert');
                                let errorAlert = document.getElementById('error-alert');

                                if (successAlert) {
                                    successAlert.style.transition = "opacity 0.5s ease";
                                    successAlert.style.opacity = "0";
                                    setTimeout(() => successAlert.remove(), 500);
                                }

                                if (errorAlert) {
                                    errorAlert.style.transition = "opacity 0.5s ease";
                                    errorAlert.style.opacity = "0";
                                    setTimeout(() => errorAlert.remove(), 500);
                                }
                            }, 5000);
                        </script>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const modalElement = document.getElementById('modal-barang-keluar');
                                    const modalInstance = new Flowbite.Modal(modalElement);
                                    
                                    // Event listener untuk tombol membuka modal
                                    const tombolModal = document.querySelector('button[data-modal-toggle="modal-barang-keluar"]');
                                    tombolModal.addEventListener('click', (event) => {
                                        const id_barang = event.target.getAttribute('data-id');
                                        document.getElementById('id').value = id_barang;
                                        modalInstance.show();
                                    });

                                    // Event listener untuk menutup modal
                                    modalElement.addEventListener('click', (event) => {
                                        if (event.target === modalElement) {
                                            modalInstance.hide();
                                        }
                                    });
                                });
                            </script>

                            <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const dismissButtons = document.querySelectorAll('[data-dismiss-target]');
                                
                                dismissButtons.forEach(button => {
                                    button.addEventListener('click', function () {
                                        const target = document.querySelector(button.getAttribute('data-dismiss-target'));
                                        target.remove();
                                    });
                                });
                            });
                        </script>

                            {{-- script for graphic --}}
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var labelsBulan = @json($labels);
                                    var dataBarangMasuk = @json($data);

                                    var ctx = document.getElementById('barangMasukChart').getContext('2d');
                                    var barangMasukChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: labelsBulan,
                                            datasets: [{
                                                label: 'Barang Masuk per Bulan',
                                                data: dataBarangMasuk,
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>

                            {{-- script for edit data --}}
                            <script>
                                    function openEditModal(id, kodeBarang, namaBarang, tglInsert, jumlah, sumber, kondisi, id_lokasi) {
                                        // Set values to the form fields
                                        console.log([
                                            id, kodeBarang, namaBarang, tglInsert, jumlah, sumber, kondisi, id_lokasi
                                        ]);
                                        document.getElementById('edit_kode_barang').value = kodeBarang;
                                        document.getElementById('edit_nama_barang').value = namaBarang;
                                        document.getElementById('edit_tgl_insert').value = tglInsert;
                                        document.getElementById('edit_jumlah').value = jumlah;
                                        document.getElementById('edit_nama_lokasi').value = id_lokasi;

                                        document.getElementById('edit_sumber').value = sumber;
                                        document.getElementById('edit_kondisi').value = kondisi; 

                                        const form = document.getElementById('edit-form');
                                        form.action = `/barang/update/${id}`;

                                        document.getElementById('edit-modal').classList.remove('hidden');
                                    }

                                    function closeEditModal() {
                                        document.getElementById('edit-modal').classList.add('hidden');
                                    }
                                </script>

                                {{-- script for modals --}}
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                    const modal = document.getElementById('crud-modal');
                                    const overlay = document.getElementById('crud-modal-overlay');
                                    const modalToggleButtons = document.querySelectorAll('[data-modal-toggle="crud-modal"]');
                                    
                                    modalToggleButtons.forEach(button => {
                                        button.addEventListener('click', function () {
                                            const isHidden = modal.classList.contains('hidden');
                                            if (isHidden) {
                                                modal.classList.remove('hidden');
                                                overlay.classList.add('modal-open');
                                                modal.querySelector('input, button').focus();
                                            } else {
                                                modal.classList.add('hidden');
                                                overlay.classList.remove('modal-open');
                                            }
                                        });
                                    });
                                });
                                </script>

</body>
</html>