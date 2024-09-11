<!DOCTYPE html>
<html lang="TW">

<head>
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <title>登入起始頁</title>
</head>

<body class="bg-gradient-to-tr from-cyan-100 via-sky-50 to-blue-200">

    <div class="container mx-auto h-screen px-10 py-10">
        <div class="flex flex-col h-full justify-center items-center space-y-10">
            <!-- 緯創資訊平台 -------------------------------------------------------------------->
            <div class="basis-1/6 w-1/2">
                <input class="btn" type="button" value="緯創資訊平台"
                    onclick="location.href='http://1.34.47.251:28888/index.php'">
            </div>
            <!-- 福壽飼育平台 -------------------------------------------------------------------->
            <div class="basis-1/6 w-1/2">
                <input class="btn" type="button" value="福壽飼育平台" onclick="location.href='/welcome'">
            </div>
            <!-- 福壽飼育平台 END -------------------------------------------------------------------->
        </div>
    </div>

    <footer class="footer">
        <!-- Copyright &copy; 2018 (^◔ᴥ◔^) MAYA. -->
        <p class="text-center copyright">Copyright &copy;
            <script>
                document.write(new Date().getFullYear());
            </script>
            &nbsp; =^◔ᴥ◔^= &nbsp; MAYA.
        </p>
    </footer>

    {{-- <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/tailwindcss.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">

    <script>
        var btn_style =
            "w-full h-full bg-transparent hover:bg-blue-500 font-semibold text-2xl text-blue-700 hover:text-white border-2 border-blue-500 rounded hover:border-transparent";
        $(".btn").addClass(btn_style);
    </script>

</body>

</html>
