<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="{{ asset('asset/style.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('components.navbar')
        <button id="sidebarToggle" class="btn btn-primary rounded-circle position-fixed d-md-none"
            style="bottom: 20px; right: 20px; z-index: 1050; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;"
            onclick="toggleSidebar()">
            <i class="bi bi-list fs-4"></i>
        </button>

        <!-- Main Content -->
        <div class="main-content">
        