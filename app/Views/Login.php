<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Global Finance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: transparent;
            border: none;
            padding-top: 30px;
        }

        .btn-primary {
            background: #764ba2;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #5a3782;
            transform: translateY(-2px);
        }

        .form-control {
            border-radius: 8px;
            padding: 25px 15px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="font-weight-bold text-dark">Global Finance</h3>
                        <p class="text-muted">Silakan masuk ke akun Anda</p>
                    </div>
                    <div class="card-body px-4 pb-5">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger border-0 small"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <form action="/login" method="post">
                            <div class="form-group">
                                <label class="small font-weight-bold">USERNAME</label>
                                <input type="text" name="username" class="form-control"
                                    placeholder="admin / manager_maju" required>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold">PASSWORD</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-4">MASUK SISTEM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>