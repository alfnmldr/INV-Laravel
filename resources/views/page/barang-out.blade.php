<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barang Keluar</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/da509c75-7411-4882-9c23-ee77089c6054-Photoroom.png')}}">
    <style>
        body {
            background-color: #131313;
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 10px;
            }

        ::-webkit-scrollbar-thumb {
            background: #B4B4B8;
            border-radius: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>

                    {{-- sidebar --}}
                    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform m-0 -translate-x-full sm:translate-x-0" aria-label="Sidebar">
                    <div class="h-full px-5 py-6 overflow-y-auto dark:bg-gray-800" style="background-color: #000000; background-image:url(asset('image/peakpx.jpg'));">
                    <ul>
                        <a href="{{ route('redirect.user') }}" class="flex items-center ps-2.5 mb-5">
                            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white"><img src="{{asset('image/Adobe Express - file.png')}}" alt=""></span>
                        </a>
                        <li>
                                <button class="text-white bg-green-600/90 rounded-md hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <a href="{{ route('redirect.user') }}" class="flex items-center justify-center gap-4">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                                        </svg>
                                    Home
                                    </a>
                                </button>
                            </li>
                             <ul class="space-y-2 font-medium">
                                <li class="@if(Auth::user()->role === 'manajer') hidden @endif">
                                    <button id="tambahBarangBtn" class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 8H4m8 3.5v5M9.5 14h5M4 6v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z"/>
                                        </svg>
                                        Tambah Barang
                                    </button>
                                </li>
                            </ul>
                            <li class="space-y-2 font-medium @if(Auth::user()->role === 'admin') hidden @endif">
                                <button id="tambahUserBtn" class="add-admin text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 8H4m8 3.5v5M9.5 14h5M4 6v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z"/>
                                    </svg>
                                    Tambah User
                                </button>
                            </li>
                        <li class="@if(Auth::user()->role === 'manajer') hidden @endif">
                                <button id="BarangOutBtn" class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M6 5a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L15.249 6H19a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2v-5a3 3 0 0 0-3-3h-3.22l-1.14-1.682A3 3 0 0 0 9.157 6H6V5Z" clip-rule="evenodd"/>
                                        <path fill-rule="evenodd" d="M3 9a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L12.249 10H3V9Zm0 3v7a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-7H3Z" clip-rule="evenodd"/>
                                    </svg>
                                    Keluarkan Barang
                                </button>
                            </li>
                            <li>
                                <button class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-xs items-center px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M6 5a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L15.249 6H19a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2v-5a3 3 0 0 0-3-3h-3.22l-1.14-1.682A3 3 0 0 0 9.157 6H6V5Z" clip-rule="evenodd"/>
                                        <path fill-rule="evenodd" d="M3 9a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L12.249 10H3V9Zm0 3v7a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-7H3Z" clip-rule="evenodd"/>
                                    </svg>
                                    <a href="{{route('barang.out')}}">Data Barang Keluar</a>
                                </button>
                            </li>
                            <li>
                                <button class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm2-2a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm0 3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm-6 4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-6Zm8 1v1h-2v-1h2Zm0 3h-2v1h2v-1Zm-4-3v1H9v-1h2Zm0 3H9v1h2v-1Z" clip-rule="evenodd"/>
                                    </svg>
                                    <a href="{{ route('fotos.index') }}">Data Foto</a>
                                </button>
                            </li>
                             @if(auth()->user()->role !== 'admin')
                                <li>
                                    <button id="tambahLokasiBtn" class="text-white hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                        <svg class="w-6 h-6 text-white dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 8H4m8 3.5v5M9.5 14h5M4 6v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z"/>
                                        </svg>
                                        Tambah Lokasi
                                    </button>
                                </li>
                            @endif
                            <li class="@if(Auth::user()->role === 'admin') hidden @endif">
                                <button class="text-white flex hover:bg-blue-400 focus:ring-4 focus:outline-none rounded-md focus:ring-blue-300 font-medium text-sm px-5 py-2.5 border-b-4 text-center w-full flex gap-4 border-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    <a href="{{route('user-log')}}" class="flex items-center gap-4">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
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
                                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.757 6 3.24 10.95a1.05 1.05 0 0 0 0 1.549l5.611 5.088m5.73-3.214v1.615a.948.948 0 0 1-1.524.845l-5.108-4.251a1.1 1.1 0 0 1 0-1.646l5.108-4.251a.95.95 0 0 1 1.524.846v1.7c3.312 0 6 2.979 6 6.654v1.329a.7.7 0 0 1-1.345.353 5.174 5.174 0 0 0-4.652-3.191l-.003-.003Z"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    </aside>

                    <div class="p-4 sm:ml-64 font-poppins">
                        <div class="container mx-auto mt-7">
                            <div class="flex items-center justify-between">
                                <h1 class="text-4xl font-bold mb-4 text-white">Data Barang <span class="underline">Keluar</span></h1>
                                <p class="text-white text-3xl capitalize font-medium font-poppins">Halo, {{ Auth::user()->username }}!</p>
                                @if(auth()->user()->role !== 'manajer')
                                <form action="{{ route('barangKeluar.report') }}" method="GET">
                                    <select name="range" class="p-2 rounded-md text-black">
                                        <option value="weekly">Mingguan</option>
                                        <option value="monthly">Bulanan</option>
                                    </select>
                                    <button type="submit" class="text-white bg-blue-500 p-2 rounded-md hover:bg-blue-700 transition-all">Cetak Report</button>
                                </form>
                                @endif
                            </div>

                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-9">
                                <!-- Tabel untuk data barang -->
                                    <table class="w-full text-sm text-center text-black dark:text-gray-400">
                                        <thead class="text-sm text-white uppercase dark:bg-gray-700 dark:text-gray-400 border-b-2 border-white">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">ID Barang Keluar</th>
                                                <th scope="col" class="px-6 py-3">Nama Barang</th>
                                                <th scope="col" class="px-6 py-3">Waktu Keluar</th>
                                                <th scope="col" class="px-6 py-3">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($barangKeluar as $barang)
                                            <tr class="border-b dark:bg-gray-800 dark:border-gray-700 text-white hover:bg-blue-300">
                                                <td class="px-6 py-4">{{ $barang->id_barangkeluar }}</td>
                                                <td class="px-6 py-4">{{ $barang->barang->nama_barang ?? 'Nama Barang Tidak Ditemukan' }}</td>
                                                <td class="px-6 py-4">{{ $barang->tgl_keluar }}</td>
                                                <td class="px-6 py-4">{{ $barang->jumlah }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>




                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                        // URL halaman
                        const lokasiUrl = "{{ route('redirect.user') }}"; 
                        const homeUrl = "{{ route('redirect.user') }}";
                        const BarangOut = "{{ route('redirect.user') }}";
                        const addBarang = "{{ route('redirect.user') }}"; 

                        // Tombol
                        const tambahLokasiBtn = document.getElementById("tambahLokasiBtn");
                        const tambahUserBtn = document.getElementById("tambahUserBtn");
                        const tambahBarangOutBtn = document.getElementById("BarangOutBtn");
                        const tambahBarangBtn = document.getElementById("tambahBarangBtn");

                        // Fungsi untuk memeriksa halaman dan menambahkan event listener
                        function checkPageAndSetListener(button, validUrl, title, text) {
                            if (window.location.href === validUrl) {
                                button.disabled = false; // Aktifkan tombol jika halaman valid
                            } else {
                                button.addEventListener('click', function() {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: title,
                                        text: text,
                                        backdrop: 'rgba(0, 0, 0, 0.8)',
                                        confirmButtonText: 'Ok'
                                    });
                                });
                            }
                        }

                        checkPageAndSetListener(tambahBarangBtn, lokasiUrl, 'Akses Ditolak', 'Anda hanya bisa menambahkan barang di halaman Home!');
                        checkPageAndSetListener(tambahBarangOutBtn, lokasiUrl, 'Akses Ditolak', 'Anda hanya bisa mengeluarkan barang di halaman Home!');
                        checkPageAndSetListener(tambahLokasiBtn, lokasiUrl, 'Akses Ditolak', 'Anda hanya bisa menambah lokasi di halaman Home!');
                        checkPageAndSetListener(tambahUserBtn, homeUrl, 'Akses Ditolak', 'Anda hanya bisa menambah user di halaman Home!');
                </script>
</body>
</html>