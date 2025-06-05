

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard - Manajer</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/da509c75-7411-4882-9c23-ee77089c6054-Photoroom.png')}}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        @media print {
        
        body * {
            visibility: hidden;
            margin: 0;
            padding: 0;
        }

        .print-area, .print-area * {
            visibility: visible;
        }
        .print-area {
        margin: 0;
        padding: 0;
    }


    @page {
        size: auto;
        margin: 10mm;
    }
    
    }
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

        .status-approved {
            color: #00ff5e; /* Hijau */
        }
        .status-pending {
            color: #facc15; /* Kuning */
        }
        .status-rejected {
            color: #ef4444; /* Merah */
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
        #dropdown {
        transition: opacity 0.3s ease-in-out, max-height 0.3s ease-in-out;
    }
    </style>
</head>
<body>

            @php
            $startDate = request('start_date');
            $endDate = request('end_date');
            $searchQuery = request('query');

            // Query untuk memfilter data barang
            $filteredData = \App\Models\Barang::query()
                // Filter berdasarkan rentang tanggal 'tgl_insert' jika start_date dan end_date tersedia
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('tgl_insert', [$startDate, $endDate]);
                })
                // Filter berdasarkan pencarian 'nama_barang'
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
                    <aside id="logo-sidebar" class="fixed overflow-hidden top-0 left-0 z-40 w-64 h-screen transition-transform m-0 -translate-x-full sm:translate-x-0" aria-label="Sidebar">
                    <div class="h-full px-5 py-6 overflow-y-auto" style="background-color: #000000;">
        <ul>
            <a href="{{ route('manajer.dashboard') }}" class="flex items-center ps-2.5 mb-5">
                <span class="self-center text-xl font-semibold whitespace-nowrap text-white"><img src="{{ asset('image/da509c75-7411-4882-9c23-ee77089c6054-Photoroom.png') }}" alt=""></span>
            </a>
            <li>
                <button class="text-white bg-green-600/90 rounded-md hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500" type="button">
                    <a href="{{ route('manajer.dashboard') }}" class="flex items-center justify-center gap-4 text-white">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                        </svg>
                        Home
                    </a>
                </button>
            </li>
                            <li class="space-y-2 font-medium">
                                <button class="add-admin text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" id="openModal">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 8H4m8 3.5v5M9.5 14h5M4 6v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z"/>
                                    </svg>
                                    Tambah User
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
                                <button class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="modalTambahLokasi">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 8H4m8 3.5v5M9.5 14h5M4 6v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z"/>
                                    </svg>
                                    <a href="#">Tambah Lokasi</a>
                                </button>
                            </li>
                            <li>
                                <button class="text-white flex hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <a href="{{route('user-log')}}" class="flex items-center gap-4">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" fill="white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z" clip-rule="evenodd"/>
                                    </svg>
                                    Log User
                                </a>
                                </button>
                            </li>
                            <li>
                                
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="text-white hover:bg-blue-400 absolute bottom-4  focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-md font-medium text-sm px-5 py-2.5 text-center w-fit flex gap-4 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-6 h-6 text-white" fill="white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.757 6 3.24 10.95a1.05 1.05 0 0 0 0 1.549l5.611 5.088m5.73-3.214v1.615a.948.948 0 0 1-1.524.845l-5.108-4.251a1.1 1.1 0 0 1 0-1.646l5.108-4.251a.95.95 0 0 1 1.524.846v1.7c3.312 0 6 2.979 6 6.654v1.329a.7.7 0 0 1-1.345.353 5.174 5.174 0 0 0-4.652-3.191l-.003-.003Z"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    </aside>
                    </li>
                            <button id="theme-toggle" class="absolute bottom-16 text-white p-2 rounded-md">
                                <svg class="w-6 h-6 text-white" fill="white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                                </svg>
                            </button>
                            <li>

                <div id="modalTambahLokasi" tabindex="-1" class="hidden bg-black/80 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                Tambah Lokasi
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalTambahLokasi">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close</span>
                            </button>
                        </div>
                        <div class="p-6 space-y-6">
                            <form action="{{ route('lokasi.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="nama_lokasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nama Lokasi</label>
                                    <input type="text" id="nama_lokasi" name="nama_lokasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan nama lokasi" required>
                                </div>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <div class="toggle-theme absolute left-0 bottom-2 right-5">
            
        </div>
            

                <div class="p-4 sm:ml-64">
                    <div class="p-4">
                        <div class="gap-4 mb-4 w-5/6 m-auto sm:scroll">
                            {{--table data section  --}}
                                
                            <div class="inline p-4 h-auto mb-4 rounded-lg lg:w-3/4 w-auto md:w-auto sm:w-auto mx-auto mt-48">
                                {{-- menunjukan pesan sukses --}}
                            @if(session('success'))
                                <div class="bg-green-800 text-white p-3 rounded mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="grid grid-cols-3 gap-4 mb-4 flex-wrap sm:block lg:grid sm:mt-3 md:block">
                                <div class="flex flex-col p-3 gap-5 h-auto rounded bg-gray-700/50 md:h-auto md:block">
                                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                                    </svg>
                                    </p>
                                    <div class="flex justify-between items-center mt-14">
                                     <p class="font-poppins text-white">Jumlah Data Barang : {{$jumlahBarang}}</p>   
                                    </div>
                                   
                                </div>
                                <div class="flex flex-col sm:flex-wrap p-3 gap-5 h-auto rounded bg-gray-700/50 md:h-auto md:block">
                                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                      <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd"/>
                                    </svg>
                                    </p>
                                    <div class="flex flex-wrap mt-2 justify-between items-center md:block">
                                        <p class="font-poppins text-white">Jumlah Data User : {{$userList}}</p>
                                        <p>
                                            <button id="openUserDataModalButton" class="flex text-white bg-gray-500 p-1 mt-2 rounded-md w-fit hover:bg-green-700 transition-all">
                                                Lihat
                                                <svg class="w-6 h-6 text-white text-2xl dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col p-4 gap-5 h-auto rounded bg-gray-700/50 md:h-auto md:block">
                                    <p class="text-2xl text-gray-400 dark:text-gray-500">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 18v2H4V4h6v2m4 12v2h6V4h-6v2m-6.49543 8.4954L10 12m0 0L7.50457 9.50457M10 12H4.05191m12.50199 2.5539L14 12m0 0 2.5539-2.55392M14 12h5.8319"/>
                                    </svg>
                                    </p>
                                    <div class="flex flex-wrap mt-2 justify-between items-center md:block">
                                        <p class="font-poppins text-white">Jumlah Data Lokasi : {{$lokasiList}}</p>
                                        <p>
                                            <a href="#" id="openLokasiModalButton" class="flex text-white mt-2 bg-gray-500 p-1 w-fit rounded-md hover:bg-green-700 transition-all">Lihat
                                                <svg class="w-6 h-6 text-white text-2xl dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        </p>
                                    </div>   
                                </div>
                            </div>
                           
                                <div class="flex justify-between">
                                    <div class="flex items-center justify-center h-24 rounded">
                                            <form class="flex mt-6 mr-2 lg:mt-0 items-center max-w-sm mx-auto" method="GET">
                                                <label for="simple-search" class="sr-only">Search</label>
                                                <div class="relative w-full">
                                                    <input type="text" name="query" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-auto p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari Nama Barang..." value="{{ request('query') }}" required />
                                                </div>
                                                <button type="submit" class="p-3 ms-2 text-sm font-medium text-white rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="background-color: #4E9F3D">
                                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                                    </svg>
                                                    <span class="sr-only">Search</span>
                                                </button>
                                            </form>
                                            </div>
                                                <div class="flex items-center align-middle justify-center h-24 rounded mt-4 lg:mt-0">
                                                    <form method="GET" class="flex items-center gap-3">
                                                        <!-- Filter by Date Range -->
                                                        <label for="start_date" class="text-white">Start</label>
                                                        <input type="date" name="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600">

                                                        <label for="end_date" class="text-white">End</label>
                                                        <input type="date" name="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600">

                                                        <!-- Filter Button -->
                                                        <button class="p-2 w-24 rounded-md text-white" style="background-color:#4E9F3D;">Filter</button>

                                                        <!-- Reset Button -->
                                                        <a href="{{ route('redirect.user') }}" class="p-2 w-auto rounded-md text-white bg-gray-500 hover:bg-gray-600 text-center">Reset Filter</a>
                                                    </form>
                                                </div>
                                                <div class="flex items-center justify-center h-24 rounded">
                                                    {{-- diganti menjadi nama user yg sedang login --}}
                                                    <p class="lg:block lg:text-3xl md:hidden sm:hidden ml-3"style="font-family: 'Pacifico'; font-weight: 500; color:#4E9F3D; display:flex; flex-wrap:wrap; gap:5px;"><span class="font-poppins font-semibold">Welcome, </span> {{ Auth::user()->username }}!</p>
                                                </div> 
                                            </div> 
                                        <table class="w-full text-sm text-center h-full rtl:text-right">
                                        <thead class="text-md text-white text-center capitalize">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">ID Barang</th>
                                                <th scope="col" class="px-6 py-3">Kode Barang</th>
                                                <th scope="col" class="px-6 py-3">Nama Barang</th>
                                                <th scope="col" class="px-6 py-3">Tanggal Penambahan</th>
                                                <th scope="col" class="px-6 py-3">Stok</th>
                                                <th scope="col" class="px-6 py-3">Sumber</th>
                                                <th scope="col" class="px-6 py-3 hidden">ID Lokasi</th>
                                                <th scope="col" class="px-6 py-3">Lokasi Barang</th>
                                                <th scope="col" class="px-6 py-3">Kondisi</th>
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
                                            <tr class="border-b-2 text-white text-md capitalize rounded-lg dark:border-black hover:bg-green-600 hover:text-white dark:hover:bg-gray-300">
                                                <th scope="row" class="px-6 py-6 font-medium text-white whitespace-nowrap dark:text-white hover:text-white">
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
                                                <td class="px-4 py-3 hidden">
                                                    {{ $item->id_lokasi }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ $item->lokasi->nama_lokasi ?? 'Lokasi tidak ditemukan' }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ $item->kondisi }}
                                                </td>
                                                <td class="px-4 py-3 
                                                    {{ $item->status == 'Approved' ? 'text-green-500' : '' }}
                                                    {{ $item->status == 'Pending' ? 'text-yellow-500' : '' }}">
                                                    {{ ucfirst($item->status) }}
                                                </td>
                                                <td class="px-4 py-3 text-center align-middle">
                                                <div class="flex gap-3 justify-center align-middle">
                                                    <!-- Tombol Acc -->
                                                    <form action="{{ route('barang.approve', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin meng-ACC barang ini?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                            class="bg-green-500 p-2 rounded-md h-12 text-white hover:bg-blue-400 
                                                            {{ $item->status == 'Approved' ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                                            {{ $item->status == 'Approved' ? 'disabled' : '' }}>
                                                            Acc
                                                        </button>
                                                    </form>

                                                                                                <!-- Tombol Revisi -->
                                                    <form action="{{ route('barang.revisi', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin merevisi barang ini?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                            class="bg-orange-500 p-2 rounded-md h-12 text-white hover:bg-orange-400
                                                            {{ $item->status == 'Revisi' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                            {{ $item->status == 'Revisi' ? 'disabled' : '' }}>
                                                            Revisi
                                                        </button>
                                                    </form>

                                                    <!-- Tombol Cetak Label -->
                                                    <button id="printButton-{{ $item->id }}" 
                                                        class="bg-yellow-300 p-1 rounded-md h-12 text-black hover:bg-yellow-400 hover:text-white" 
                                                        onclick="printLabel('{{ $item->nama_barang }}', '{{ $item->kode_barang }}')">
                                                        Cetak Label
                                                    </button>
                                                </div>
                                            </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        </table>
                                            <!-- Elemen untuk mencetak hanya informasi barang tertentu -->
                                            <div id="print-area" class="print-area" style="display: none;">
                                                <h2>Detail Barang</h2>
                                                <p><strong>Nama Barang:</strong> <span id="print-nama-barang"></span></p>
                                                <p><strong>Kode Barang:</strong> <span id="print-kode-barang"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

        
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
                                                </div>
                                                <div class="col-span-2 sm:col-span-1">
                                                    <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                                                    <input type="number" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Jumlah" required="">
                                                </div>
                                                <div class="col-span-2 sm:col-span-1">
                                                    <label for="sumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sumber</label>
                                                    <input type="text" name="sumber" id="sumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Sumber" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="nama_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi Barang</label>
                                                    <input type="text" name="nama_lokasi" id="nama_lokasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Lokasi Barang" required="">
                                                </div>
                                            </div>
                                            <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Tambahkan Barang
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                                <!-- Modal HTML menggunakan Flowbite -->
                            <div id="userModal" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden h-full bg-black/80">
                                <div class="relative w-full h-full max-w-2xl md:h-auto">
                                    <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Tambah Pengguna</h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" onclick="closeModal()">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 9.293l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414L10 9.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <form id="addUserForm" class="p-6 space-y-6" method="POST" action="{{ route('users') }}">
                                            @csrf
                                            <div>
                                                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                                <input type="text" id="username" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                @error('username')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                                <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                @error('password')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                                <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                    <option value="" disabled selected>Pilih Role</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="manajer">Manajer</option>
                                                </select>
                                                @error('role')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Show User -->
                            <div id="userDataModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden w-autp h-full flex justify-center items-center bg-black bg-opacity-80">
                                <div class="relative w-full max-w-4xl h-full md:h-auto overflow-y-auto">
                                    <div class="relative bg-white rounded-lg shadow max-h-[90vh] overflow-y-auto">
                                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-700">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Data User
                                            </h3>
                                            <button type="button" id="closeUserDataModalButton" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-6 space-y-6">
                                            <table class="min-w-full text-center bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                                <thead>
                                                    <tr>
                                                        <th class="py-2 px-4 border-b">Username</th>
                                                        <th class="py-2 px-4 border-b">Role</th>
                                                        <th class="py-2 px-4 border-b">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($userListShow as $user)
                                                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                                                        <td class="py-2 px-4 border-b">{{ $user->username }}</td>
                                                        <td class="py-2 px-4 border-b">{{ $user->role }}</td>
                                                        <td class="py-2 px-4 border-b">
                                                            <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapusnya?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-white text-center bg-red-600 hover:bg-red-700 p-2 rounded-md">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="flex items-center justify-end p-6 border-t border-gray-200 dark:border-gray-700">
                                            <button id="closeUserModalFooterButton" class="text-white bg-blue-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal Show Lokasi -->
                            <div id="lokasiModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden w-full h-full flex justify-center items-center bg-black bg-opacity-80">
                                <div class="relative w-full max-w-4xl h-full md:h-auto overflow-y-auto">
                                    <div class="relative bg-white rounded-lg shadow max-h-[90vh] overflow-y-auto">
                                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-700">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Data Lokasi
                                            </h3>
                                            <button type="button" id="closeLokasiModalButton" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-6 space-y-6">
                                            <table class="min-w-full bg-white dark:bg-gray-700 text-left text-gray-900 dark:text-white">
                                                <thead>
                                                    <tr>
                                                        <th class="py-2 px-4 border-b">ID Lokasi</th>
                                                        <th class="py-2 px-4 border-b">Nama Lokasi</th>
                                                        <th class="py-2 px-4 border-b">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($showLokasi as $lokasi)
                                                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                                                        <td class="py-2 px-4 border-b">{{ $lokasi->id_lokasi }}</td>
                                                        <td class="py-2 px-4 border-b">{{ $lokasi->nama_lokasi }}</td>
                                                        <td class="py-2 px-4 border-b">
                                                            <form action="{{ route('lokasi.destroy', $lokasi->id_lokasi) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapusnya?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 p-2 rounded-md">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="flex items-center justify-end p-6 border-t border-gray-200 dark:border-gray-700">
                                            <button id="closeLokasiModalFooterButton" class="text-white bg-blue-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // theme.js

// Cek tema yang tersimpan di localStorage saat halaman dimuat
if (localStorage.getItem('theme') === 'light') {
    document.body.classList.add('light-theme');
}

// Fungsi untuk toggle tema
function toggleTheme() {
    document.body.classList.toggle('light-theme');

    // Simpan tema yang dipilih ke localStorage
    if (document.body.classList.contains('light-theme')) {
        localStorage.setItem('theme', 'light');
    } else {
        localStorage.setItem('theme', 'dark');
    }
}

// Event listener untuk tombol toggle
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }
});
                            </script>


                            <script>
                                
                            const lokasiModal = document.getElementById('lokasiModal');
                            const openLokasiModalButton = document.getElementById('openLokasiModalButton');
                            const closeLokasiModalButton = document.getElementById('closeLokasiModalButton');
                            const closeLokasiModalFooterButton = document.getElementById('closeLokasiModalFooterButton');

                            
                            openLokasiModalButton.addEventListener('click', () => {
                                lokasiModal.classList.remove('hidden');
                            });

                            closeLokasiModalButton.addEventListener('click', () => {
                                lokasiModal.classList.add('hidden');
                            });

                            closeLokasiModalFooterButton.addEventListener('click', () => {
                                lokasiModal.classList.add('hidden');
                            });

                            </script>

                            <script>

                                const userDataModal = document.getElementById('userDataModal');
                                const openUserDataModalButton = document.getElementById('openUserDataModalButton');
                                const closeUserDataModalButton = document.getElementById('closeUserDataModalButton');
                                const closeUserModalFooterButton = document.getElementById('closeUserModalFooterButton');

                                function openUserDataModal() {
                                    userDataModal.classList.remove('hidden');
                                }

                                function closeUserDataModal() {
                                    userDataModal.classList.add('hidden');
                                }

                                openUserDataModalButton.addEventListener('click', openUserDataModal);

                                closeUserDataModalButton.addEventListener('click', closeUserDataModal);

                                closeUserModalFooterButton.addEventListener('click', closeUserDataModal);
                            </script>


                            <script>
                                const openModalButton = document.getElementById('openModal');
                                const userModal = document.getElementById('userModal');

                                if (openModalButton) {
                                    openModalButton.addEventListener('click', () => {
                                        openUserModal();
                                    });
                                }

                                function openUserModal() {
                                    userModal.classList.remove('hidden');
                                    userModal.classList.add('block');
                                }

                                function closeModal() {
                                    userModal.classList.remove('block');
                                    userModal.classList.add('hidden');
                                }

                                @if ($errors->any())
                                    document.addEventListener('DOMContentLoaded', (event) => {
                                        openUserModal();
                                    });
                                @endif
                            </script>


                            <script>
                                function printLabel(nama, kode) {
                                document.getElementById('print-nama-barang').textContent = nama;
                                document.getElementById('print-kode-barang').textContent = kode;

                                document.getElementById('print-area').style.display = 'block';

                                window.print();

                                document.getElementById('print-area').style.display = 'none';
                            }

                            </script>
                        <script>
                        function toggleDropdown() {
                            const dropdown = document.getElementById("dropdown");
                            
                            if (dropdown.classList.contains('opacity-0')) {
                                dropdown.classList.remove('opacity-0', 'max-h-0');
                                dropdown.classList.add('opacity-100', 'max-h-40');
                            } else {
                        
                                dropdown.classList.remove('opacity-100', 'max-h-40');
                                dropdown.classList.add('opacity-0', 'max-h-0');
                            }
                        }
                        </script>

                        {{-- script for tambah lokasi --}}
                            <script>
                            var modal = document.getElementById('modalTambahLokasi');

                            var btn = document.querySelector('[data-modal-toggle="modalTambahLokasi"]');

                            var closeModalBtn = document.querySelector('[data-modal-hide="modalTambahLokasi"]');

                            btn.onclick = function() {
                                modal.classList.remove('hidden');
                            }

                            closeModalBtn.onclick = function() {
                                modal.classList.add('hidden');
                            }

                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    modal.classList.add('hidden');
                                }
                            }
                        </script>
            </body>
</html>