<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2 class="text-center">QR Code Generator</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('qr.generate') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Matn yoki URL</label>
        <input type="text" class="form-control" name="text" required>
        @error('text') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <button type="submit" class="btn btn-primary">QR Kod Yaratish</button>
</form>

@if(session('qr_url'))
    <div class="mt-4 text-center">
        <h4>Yaratilgan QR Kod</h4>
        <img src="{{ session('qr_url') }}" alt="QR Code" class="img-fluid">
        <br>
        <a href="{{ route('qr.download', session('qr_id')) }}" class="btn btn-success mt-2">Yuklab olish</a>
    </div>
@endif

</body>
</html>
