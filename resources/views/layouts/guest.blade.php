<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Fast One Billing System - Log in</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
        {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}


        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                /* background-image: url('/img/login_bg.png'); */
                /* background-size: cover; */
                /* background-position: bottom; */
                background-color: rgb(193, 193, 193);
                display: flex;
                justify-content: center;
                align-items: center;    
                height: 98vh;
            }

            .login-container {
                display: flex;
                border-radius: 0.75rem;
                background-color: red;
                overflow: hidden;
            }

            /* From Uiverse.io by Yaya12085 */ 
            .form-container {
            width: 300px;
            background-color: rgb(13, 29, 64);
            padding-bottom: 30px;
            color: rgba(243, 244, 246, 1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            }

            .form-container:nth-child(2) {
                background-color: rgb(231, 231, 231);
                justify-content: start;
                padding: 10px;
            }

            .form-container:nth-child(2) img {
                width: 70%;
                margin-bottom: 110px;
            }

            .form-container:nth-child(2) h3 {
                font-size: 20px;
                color: #00558e;
            }

            .title {
            text-align: center;
            font-size: 1.5rem;
            line-height: 2rem;
            font-weight: 700;
            margin-bottom: 0;
            }

            .input-group {
            width: 230px;
            margin-top: 20px;
            font-size: 0.875rem;
            line-height: 1.25rem;
            display: flex;
            flex-direction: column;
            }

            .input-group label {
            display: block;
            color: rgba(156, 163, 175, 1);
            margin-bottom: 4px;
            }

            .form .remember_me {
                margin: 10px 0;
                margin-bottom: 40px;
            }

            .form .error {
                color: red;
                font-size: 12px;
            }

            .input-group .input {
            border-radius: 0.375rem;
            border: 1px solid rgba(55, 65, 81, 1);
            outline: 0;
            background-color: rgba(17, 24, 39, 1);
            padding: 0.75rem 1rem;
            color: rgba(243, 244, 246, 1);
            }

            .input-group .input:focus {
            border-color: rgba(167, 139, 250);
            }

            .sign {
            display: block;
            width: 100%;
            background-color: rgb(133, 109, 202);
            padding: 0.75rem;
            text-align: center;
            color: rgb(255, 255, 255);
            border: none;
            border-radius: 0.375rem;
            font-weight: 600;
            }

            .sign:hover {
            background-color: rgb(99, 69, 166);
            }

            /* From Uiverse.io by Vazafirst */ 
            #page {
            display: flex;
            justify-content: center;
            align-items: center;
            }

            #container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            }

            #h3 {
            color: rgb(82, 79, 79);
            font-size: 12px;
            font-weight: bold;
            }

            #ring {
            width: 190px;
            height: 190px;
            border: 1px solid transparent;
            border-radius: 50%;
            position: absolute;
            }

            #ring:nth-child(1) {
            border-bottom: 8px solid rgb(240, 42, 230);
            animation: rotate1 2s linear infinite;
            }

            @keyframes rotate1 {
            from {
                transform: rotateX(50deg) rotateZ(110deg);
            }

            to {
                transform: rotateX(50deg) rotateZ(470deg);
            }
            }

            #ring:nth-child(2) {
            border-bottom: 8px solid rgb(240, 19, 67);
            animation: rotate2 2s linear infinite;
            }

            @keyframes rotate2 {
            from {
                transform: rotateX(20deg) rotateY(50deg) rotateZ(20deg);
            }

            to {
                transform: rotateX(20deg) rotateY(50deg) rotateZ(380deg);
            }
            }

            #ring:nth-child(3) {
            border-bottom: 8px solid rgb(3, 170, 170);
            animation: rotate3 2s linear infinite;
            }

            @keyframes rotate3 {
            from {
                transform: rotateX(40deg) rotateY(130deg) rotateZ(450deg);
            }

            to {
                transform: rotateX(40deg) rotateY(130deg) rotateZ(90deg);
            }
            }

            #ring:nth-child(4) {
            border-bottom: 8px solid rgb(207, 135, 1);
            animation: rotate4 2s linear infinite;
            }

            @keyframes rotate4 {
            from {
                transform: rotateX(70deg) rotateZ(270deg);
            }

            to {
                transform: rotateX(70deg) rotateZ(630deg);
            }
            }
            /* Improving visualization in light mode */


        </style>
    </head>
    <body>
        <div class="login-container">
            {{ $slot }}
        </div>
    </body>
</html>
