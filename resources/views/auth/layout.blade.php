<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <style>
        :root {
            --auth-primary: #1f6f5f;
            --auth-secondary: #f4a261;
            --auth-surface: rgba(255, 255, 255, 0.92);
            --auth-border: rgba(31, 111, 95, 0.18);
            --auth-text: #16332c;
            --auth-muted: #5f6f69;
            --auth-danger: #b42318;
            --auth-success: #166534;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Source Sans Pro", sans-serif;
            color: var(--auth-text);
            background:
                radial-gradient(circle at top left, rgba(244, 162, 97, 0.42), transparent 32%),
                radial-gradient(circle at bottom right, rgba(42, 157, 143, 0.35), transparent 30%),
                linear-gradient(135deg, #f7f4ea 0%, #dcefe8 50%, #eef7f3 100%);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .auth-shell {
            width: 100%;
            max-width: 460px;
        }

        .auth-card {
            padding: 42px 34px;
            background: var(--auth-surface);
            border: 1px solid rgba(255, 255, 255, 0.55);
            border-radius: 28px;
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(22, 51, 44, 0.14);
        }

        .auth-card h2 {
            margin: 0 0 8px;
            font-size: 2rem;
        }

        .auth-card > p {
            margin: 0 0 28px;
            color: var(--auth-muted);
            line-height: 1.5;
        }

        .auth-form {
            display: grid;
            gap: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .input-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid var(--auth-border);
            border-radius: 16px;
            padding: 0 16px;
            background: #fff;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .input-wrap i {
            color: #7b8a84;
        }

        .input-wrap input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            padding: 16px 0;
            font-size: 1rem;
            color: var(--auth-text);
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .checkbox-wrap {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--auth-muted);
        }

        .auth-button {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 15px 18px;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--auth-primary), #2a9d8f);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 14px 28px rgba(31, 111, 95, 0.2);
        }

        .auth-button:hover {
            transform: translateY(-1px);
        }

        .auth-switch {
            margin: 24px 0 0;
            text-align: center;
            color: var(--auth-muted);
        }

        .auth-switch a,
        .text-link {
            color: var(--auth-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .form-error {
            display: block;
            margin-top: 8px;
            color: var(--auth-danger);
        }

        .flash {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 0.96rem;
        }

        .flash.success {
            background: rgba(22, 101, 52, 0.08);
            color: var(--auth-success);
            border: 1px solid rgba(22, 101, 52, 0.14);
        }

        .flash.error {
            background: rgba(180, 35, 24, 0.08);
            color: var(--auth-danger);
            border: 1px solid rgba(180, 35, 24, 0.14);
        }

        @media (max-width: 900px) {
            .auth-card {
                padding: 32px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-shell">
        <main class="auth-card">
            <h2>@yield('heading')</h2>
            <p>@yield('subtitle')</p>

            @if (session('success'))
                <div class="flash success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="flash error">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash error">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>
