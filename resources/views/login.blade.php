<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/sb-admin-2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">


    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

</head>

<body class="bg-gradient-primary">
    <div class="container" style="margin-top: 90px;">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sélectionner votre rôle</h1>
                                    </div>
                                    <div class="btn-container">
                                        <p><a href="{{ route('login-directeurs') }}" class="border-left-primary  btn btn-outline-primary btn-lg">Directeur</a></p>
                                        <p><a href="{{ route('login-enseignant-local') }}" class="border-left-primary  btn btn-outline-primary btn-lg">Enseignant local</a></p>
                                        <p><a href="{{ route('login-enseignant-missionnaire') }}" class="border-left-primary  btn btn-outline-primary btn-lg">Enseignant missionnaire</a></p>
                                        <p><a href="{{ route('login-etudiant') }}" class="border-left-primary  btn btn-outline-primary btn-lg">Étudiant</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>