<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventory - Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000000e6;
        }

        form > label {
            margin-top: 20px;
        }
    </style>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@100;300;400;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="">
    <div class="p-16 rounded-xl mx-auto bg-white" style="width: 95%;">
        <h1 class="text-center font-poppins text-4xl font-semibold">Welcome Back!</h1>
        <img src="{{ asset('image/download__15_-removebg-preview.png') }}" alt="logo" class="mx-auto mt-6" style="width:200px;">
        
        <!-- Alert untuk menampilkan pesan kesalahan -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-200 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Menampilkan pesan sukses atau error -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-200 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        <div class="">
            <form action="{{ route('login') }}" method="POST" class="mt-5">
                @csrf
                <label for="" class="mt-3">Username</label>
                <input type="text" name="username" class="w-full mx-auto rounded-md outline-none border-none mt-2 mb-6 placeholder-slate-950" style="border: 2px solid #000;" placeholder="Input Your Username ...">

                <label for="" class="mt-3">Password</label>
                <input type="password" id="password" name="password" class="w-full mx-auto rounded-md outline-none border-none mt-2 mb-6 placeholder-slate-950" style="border: 2px solid #000;" placeholder="Input Your Password ...">
                
                <div class="flex justify-between items-center mb-5">
                    <div class="">
                    <input type="checkbox" id="showPassword" class="mr-2" onclick="togglePasswordVisibility()">
                    <label for="showPassword">Show Password</label>
                </div>
                </div>
                
                <button class="bg-green-600 w-full mt-2 p-3 rounded-md text-white hover:bg-green-700 transition-all">Submit</button>
            </form>

            
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const passwordField = document.getElementById(inputId);
    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);
}
</script>



<script>
    function openForgotPasswordModal() {
        document.getElementById('forgotPasswordModal').classList.remove('hidden');
    }

    function closeForgotPasswordModal() {
        document.getElementById('forgotPasswordModal').classList.add('hidden');
    }
</script>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPassword');
        passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';
    }
</script>
</div>
</div>
</body>
</html>