<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Task Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">

        <div class="text-center bg-white shadow rounded-4 p-5">

            <h1 class="fw-bold text-primary mb-3">
                Task Management System
            </h1>

            <p class="text-muted mb-4">
                Manage your tasks efficiently and track your work progress.
            </p>

            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5">
                Login
            </a>

        </div>

    </div>

</body>
</html>
