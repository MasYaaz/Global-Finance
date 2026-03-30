<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Global Finance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
        }

        .navbar {
            background: #fff !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .stat-card {
            transition: 0.3s;
            border-left: 5px solid #764ba2;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .table thead th {
            border-top: none;
            background: #f8f9fa;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 6px;
        }

        .btn-input {
            border-radius: 8px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-primary" href="#"><i
                    class="fas fa-wallet mr-2"></i>GlobalFinance</a>
            <div class="ml-auto d-flex align-items-center">
                <span class="mr-3 small text-muted">Halo, <strong><?= strtoupper(session()->get('username')) ?></strong>
                    (<?= ucfirst(session()->get('role')) ?>)</span>
                <a href="/logout" class="btn btn-outline-danger btn-sm px-3">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted small mb-1">TOTAL SALDO SAAT INI</p>
                        <h2 class="font-weight-bold <?= $total_saldo >= 0 ? 'text-success' : 'text-danger' ?>">
                            Rp <?= number_format($total_saldo, 0, ',', '.') ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-dark text-white shadow-sm">
                    <div class="card-body text-center">
                        <p class="small mb-1 text-uppercase">Status Perusahaan</p>
                        <h4 class="mb-0"><?= session()->get('company_id') ? 'Anak Perusahaan' : 'Pusat (Holding)' ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (session()->get('role') == 'manager'): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-4">Transaksi Baru</h5>
                            <form action="/dashboard/store" method="post">
                                <div class="form-group">
                                    <label class="small font-weight-bold">JENIS</label>
                                    <select name="type" class="form-control" required>
                                        <option value="debit">Pemasukan (Debit)</option>
                                        <option value="kredit">Pengeluaran (Kredit)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold">NOMINAL (RP)</label>
                                    <input type="number" name="amount" class="form-control" placeholder="0" min="1"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold">KETERANGAN</label>
                                    <textarea name="description" class="form-control" rows="2"
                                        placeholder="Tujuan transaksi..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block btn-input shadow-sm">SIMPAN
                                    DATA</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="<?= session()->get('role') == 'manager' ? 'col-md-8' : 'col-md-12' ?>">
                <div class="card p-0 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 font-weight-bold">Riwayat Transaksi</h5>
                            <span class="badge badge-light border"><?= count($transactions) ?> Record</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pl-4">Tipe</th>
                                        <th>Keterangan</th>
                                        <th>Nominal</th>
                                        <?php if (session()->get('role') == 'manager'): ?>
                                            <th class="text-center">Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $t): ?>
                                        <tr>
                                            <td class="pl-4">
                                                <i
                                                    class="fas <?= $t->type == 'debit' ? 'fa-arrow-down text-success' : 'fa-arrow-up text-danger' ?> mr-2"></i>
                                                <strong><?= strtoupper($t->type) ?></strong>
                                            </td>
                                            <td><span class="text-muted small"><?= $t->description ?></span></td>
                                            <td><strong>Rp <?= number_format($t->amount, 0, ',', '.') ?></strong></td>
                                            <?php if (session()->get('role') == 'manager' || session()->get('role') == 'admin'): ?>
                                                <td class="text-center">
                                                    <a href="/dashboard/delete/<?= $t->id ?>" class="text-danger"
                                                        onclick="return confirm('Hapus?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($transactions)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center p-4">Belum ada transaksi tercatat.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>