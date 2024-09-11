<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <!-- <x-jet-authentication-card-logo /> -->
            <div class="basis-1/6 w-full mt-10 font-semibold text-6xl text-blue-700 text-center">
                福壽飼育平台
            </div>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="account" value="{{ __('帳號') }}" />
                <x-jet-input id="account" class="block mt-1 w-full" type="text" name="account" :value="old('account')"
                    required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('密碼') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />

            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('記得我') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('登入') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>

{{-- <!DOCTYPE html>
<html lang="TW">

<head>
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <title>福壽飼育平台</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>

<body class="bg-gradient-to-tr from-cyan-100 via-sky-50 to-blue-200">

    <div class="container mx-auto h-screen px-10 py-10">
        <div class="basis-1/6 w-full mt-10 font-semibold text-6xl text-blue-700 text-center">
            福壽飼育平台
        </div>
        <form class="w-full mt-10">
            <!-- Account -->
            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="label" for="inline-full-name"> 帳號 </label>
                </div>
                <div class="w-1/3">
                    <input class="input" id="account" type="text" placeholder="Username or Email"
                        autofocus="autofocus">
                </div>
            </div>
            <!-- Password -->
            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="label" for="inline-password"> 密碼 </label>
                </div>
                <div class="w-1/3 relative ">
                    <input class="input" id="password" type="password" placeholder="********">
                    <i class="bi bi-eye-slash text-xl text-gray-700 absolute right-2 top-1" id="togglePassword"></i>
                </div>
            </div>
            <!-- Register and Login Buttons -->
            <div class="flex justify-center w-full space-x-10">
                <button class="btn" type="button">註冊</button>
                <button class="btn" type="button">
                    <a href="MainSearchPage.html">登入</a>
                </button>
            </div>
        </form>
    </div>

    <footer class="footer">
        <!-- Copyright &copy; 2018 (^◔ᴥ◔^) MAYA. -->
        <p class="text-center copyright">Copyright &copy;
            <script>
                document.write(new Date().getFullYear());
            </script>
            <!-- &nbsp; =^◔ᴥ◔^= &nbsp; MAYA. -->
        </p>
    </footer>

    <!-- <script src="js/jquery-3.5.1.min.js"></script> -->
    <!--  <script src="js/tailwindcss.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>


    <script>
        var btn_style =
            "shadow bg-blue-400 hover:bg-blue-600 focus:shadow-outline focus:outline-none font-semibold text-lg text-white py-2 px-4 rounded";
        var input_style =
            "bg-gray-200 appearance-none border-2 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500";
        var label_style = "block font-semibold text-lg text-right text-blue-700 pr-4";
        $(".btn").addClass(btn_style);
        $(".input").addClass(input_style);
        $(".label").addClass(label_style);
    </script>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function() {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // toggle the icon
            this.classList.toggle("bi-eye");
        });
    </script>
</body>

</html> --}}
