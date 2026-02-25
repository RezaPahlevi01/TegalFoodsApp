<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP | TegalFood</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Verifikasi Email UMKM</h5>
                    <small>Masukkan kode OTP yang dikirim ke email Anda</small>
                </div>

                <div class="card-body">

                    {{-- SUCCESS --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ERROR --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- VALIDATION ERROR --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('verify.otp') }}" method="POST">

                        @csrf

                        {{-- OTP INPUT --}}
                        <div class="mb-3">
                            <label class="form-label">Kode OTP</label>
                            <input type="text"
                                   name="otp"
                                   class="form-control text-center fs-4"
                                   placeholder="Masukkan 6 digit OTP"
                                   maxlength="6"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Verifikasi OTP
                        </button>

                    </form>

                </div>

                <div class="card-footer text-center">

                    <small>
                        Tidak menerima kode?
                        <a href="{{ route('resend.otp') }}">Kirim ulang OTP</a>
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
