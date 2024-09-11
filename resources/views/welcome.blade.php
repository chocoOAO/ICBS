<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>福壽-飼育平台</title>

    <!-- CDN -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <!-- asset -->
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0;
            background-color: #007bff; /* 淡蓝色 */
            background-image: linear-gradient(to bottom, #dbf9f3 50%, #ffffff 50%);
            /* background-image: linear-gradient(to bottom, #d9f9f3 50%, #ffffff 50%); */
            /* background-image: linear-gradient(to bottom, #c9fff6 50%, #ffffff 50%); */
            background-repeat: no-repeat;
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg,
        video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .p-11 {
            padding: 2.75rem; /* 44px */
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .py-14 {
            padding-top: 3.5rem; /* 56px */
            padding-bottom: 3.5rem; /* 56px */
        }

        .py-40 {
        	padding-top: 10rem; /* 160px */
            padding-bottom: 10rem; /* 160px */
        }

        .py-52 {
            padding-top: 13rem; /* 208px */
            pading-bottom: 13rem; /* 208px */
        }

        .py-72 {
            padding-top: 18rem; /* 288px */
            padding-bottom: 18rem; /* 288px */
        }

        .py-96 {
            padding-top: 24rem; /* 384px */
            padding-bottom: 24rem; /* 384px */
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        /* .border-solid {
            border-style: solid;
        } */

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width:1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }

            .dark\:text-gray-500 {
                --tw-text-opacity: 1;
                color: #6b7280;
                color: rgba(107, 114, 128, var(--tw-text-opacity))
            }
        }
    </style>
    <style>
        .left {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 50px;
        }
        .left-item {
            display: flex;
            place-items: start;
            width: 50%;
            height: 60%;
            margin-right: 12rem;
            margin-left: 12rem;
            background-color: rgb(249 250 251);
            flex-direction: column;
            align-items:center;
            border-color: #dbf9f3;
            border-width: 9px;
        }

        .pa {
            font-size:40px;
            /* text-decoration: underline; */
            margin-top: 3rem;
            letter-spacing: 0.3em;

        }

        .pa-title {
            font-size:50px;
            margin-top: 3.5rem;
            letter-spacing: 0.2em;
            margin-left:1.5rem;

        }

        .pa-in {
            margin-top:5rem;
        }

        .pa-login {
            display: flex;
            justify-content: center;
            align-items:center;
            margin-right:5rem;
            margin-left:5rem;
        }

        .pa-register {
            margin-right:5rem;
            margin-left:5rem;
        }


        .right {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-right:50px;
        }

        .right-img {
            padding:20px;
            background-color:white;
        }

        .left img {
            max-width: 95%;
            border-radius: 10%;
        }

        .icon {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text {
            margin-top: 20px;
            text-align: center;
            font-size:30px;
        }

        @keyframes fade-in {
            /* 由上往下 */
            /* 0% {
                opacity: 0;
                transform: translateY(-50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            } */

            /* 由下往上 */
            0% {
                opacity: 0;
                transform: translateY(50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fading-text {
            animation: fade-in 2s forwards;
        }

        /* nav {
            /* background-color: #008000;
            padding: 10px;
        }

        nav ul {
            list-style-type: none;
            margin-right: 20px;
            padding: 0;
            display: flex;
            justify-content: left;
        }

        nav li {
            margin: 0 10px;
            border: 1px solid black;
            place-items: left;
        }

        nav a {
            border: 1px solid black;
            color:black;
            text-decoration: none;
            margin:10px;
            align-items:left;
        } */

        .login-box  li a {
            position: relative;
            color: #03e9f4;
            font-size: 36px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .3s;
            width:200px;
            text-align: center;
        }

        .login-box a:hover {
            background: #03e9f4;
            color: #fff;
            box-shadow: 0 0 5px #03e9f4,
                        0 0 25px #03e9f4,
                        0 0 50px #03e9f4,
                        0 0 100px #03e9f4;
        }

        .login-box a span {
            position: absolute;
            display: block;
        }

        .login-box a span:nth-child(1) {
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #03e9f4);
            animation: btn-anim1 1s linear infinite;
        }

        @keyframes btn-anim1 {
            0% {
            left: -100%;
            }
            50%,100% {
            left: 100%;
            }
        }

        .login-box a span:nth-child(2) {
            top: -100%;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent, #03e9f4);
            animation: btn-anim2 1s linear infinite;
            animation-delay: .25s
        }

        @keyframes btn-anim2 {
            0% {
            top: -100%;
            }
            50%,100% {
            top: 100%;
            }
        }

        .login-box a span:nth-child(3) {
            bottom: 0;
            right: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(270deg, transparent, #03e9f4);
            animation: btn-anim3 1s linear infinite;
            animation-delay: .5s
        }

        @keyframes btn-anim3 {
            0% {
            right: -100%;
            }
            50%,100% {
            right: 100%;
            }
        }

        .login-box a span:nth-child(4) {
            bottom: -100%;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(360deg, transparent, #03e9f4);
            animation: btn-anim4 1s linear infinite;
            animation-delay: .75s
        }

        @keyframes btn-anim4 {
            0% {
            bottom: -100%;
            }
            50%,100% {
            bottom: 100%;
            }
        }
    </style>
</head>

<body>
    <div  style="display:flex" class=" min-h-screen">
        <div class="left  items-center">
            {{-- <img src="{{ asset('images/chickens3.webp') }}" alt="封面圖片"> --}}
            <div class="left-item" >
                <div>
                    <p class="pa font-bold">Welcome</p>
                </div>
                <div>
                    <p class="pa-title font-bold ">福壽－飼育平台</p>
                </div>
                {{-- 在此添加內容 --}}
                <div class="flex whitespace-pre-line text-center">
                                    content
                                content content
                                content content
                    content content content content content
                    content content content content content
                    content content content content content
                </div>
                <div>
                        <ul class="pa-in flex ">
                            @if (Route::has('login'))
                                {{-- <div style="display: flex"> --}}
                                    @auth

                                        @php
                                            $user = Auth::user();
                                            $auth_type = $user->getAuth_type();
                                        @endphp
                                        <div class="login-box pa-login">
                                            <li>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                @if ($auth_type == 'worker')
                                                    <a href="{{ url('/guest') }}" class="rounded-full text-lg h-8 underline">進入網站</a>
                                                @else
                                                    <a href="{{ url('/contracts') }}" class="rounded-full text-lg h-8 underline">合約</a>
                                                @endif
                                            </li>

                                        </div>
                                        <div class="pa-login login-box ">

                                        <form method="POST" action="{{ route('logout') }}" class="inline">
                                            @csrf

                                            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                                                {{ __('Log Out') }}
                                            </button>
                                        </form>

                                        </div>

                                    @else
                                        <div class="pa-login login-box ">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <li>
                                                <a href="{{ route('login') }}" class="rounded-full text-lg  h-4  underline">登入</a>
                                            </li>
                                        </div>
                                        <div class="pa-register login-box">
                                            @if (Route::has('register'))
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <li>
                                                    <a href="{{ route('register') }}" class="rounded-full text-lg h-8 underline" style="color: rgb(243, 243, 243)">註冊</a>
                                                </li>
                                            @endif
                                        </div>
                                    @endauth
                            @endif

                            {{-- <li><a href="#">服務</a></li>
                            <li><a href="#">聯絡我們</a></li> --}}
                        </ul>
                </div>
            </div>
        </div>

        <div class="right">
            {{-- <img src="your-icon.png" alt="圓形Icon"> --}}
            <div class="right-img  rounded-full">
                <img src="{{ asset('images/chicken.png') }}" alt="chickenLogo"  class="rounded-full h-auto" />
            </div>
            <div class="text">
                <h2 class="fading-text font-bold">福壽-飼育平台</h2>
                <!-- 暫無 -->
                <p></p>
            </div>
        </div>

    </div>

</body>


</html>
