<?php

namespace App\Controllers;

use App\Models\TransactionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $role = session()->get('role');
        $companyId = session()->get('company_id');

        // Inisialisasi builder
        $builder = $db->table('transactions');

        // LOGIKA FILTER: Pasang filter SEBELUM query apapun dijalankan
        if ($role === 'manager') {
            $builder->where('company_id', $companyId);
        }

        // Simpan data transaksi ke array (Jalankan query pertama)
        // Kita gunakan clone agar builder utama tidak reset saat menghitung saldo
        $data['transactions'] = (clone $builder)->get()->getResult();

        // Hitung Saldo menggunakan builder yang sudah terfilter tadi
        $debit = (clone $builder)->where('type', 'debit')
            ->selectSum('amount')
            ->get()->getRow()->amount ?? 0;

        $kredit = (clone $builder)->where('type', 'kredit')
            ->selectSum('amount')
            ->get()->getRow()->amount ?? 0;

        $data['total_saldo'] = $debit - $kredit;

        return view('dashboard', $data);
    }

    public function store()
    {
        // Manager DAN Admin sekarang bisa tambah data
        $role = session()->get('role');
        if ($role !== 'manager' && $role !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new TransactionModel();

        // Logika: Jika Admin tambah data, dia harus input company_id manual 
        // (Tapi di form kita, kita asumsikan untuk UTS ini Manager yang input)
        $model->save([
            'company_id' => session()->get('company_id'),
            'type' => $this->request->getPost('type'),
            'amount' => $this->request->getPost('amount'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/dashboard')->with('success', 'Transaksi berhasil disimpan');
    }

    public function delete($id)
    {
        $role = session()->get('role');
        $companyId = session()->get('company_id');

        if ($role !== 'manager' && $role !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $model = new TransactionModel();
        $transaction = $model->find($id);

        if ($transaction) {
            // Filter Keamanan: Manager tidak bisa hapus data orang lain lewat URL
            if ($role === 'manager' && $transaction['company_id'] != $companyId) {
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Bukan data perusahaan Anda.');
            }

            $model->delete($id);
            return redirect()->to('/dashboard')->with('success', 'Berhasil dihapus');
        }

        return redirect()->to('/dashboard')->with('error', 'Data tidak ditemukan');
    }
}