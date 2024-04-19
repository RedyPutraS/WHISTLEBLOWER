<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MySql;
use Alert;

class TechnicalController extends BaseController
{
    public function index()
    {
        return view('dashboard.technical.index');
    }

    public function backup()
    {
        $database = 'whistleblower';
        $host = 'localhost';
        $user = 'ramadhan';
        $password = '';

        $filename = "backup-" . date("d-m-Y") . ".sql.gz";
        $mime = "application/x-gzip";

        header(
            "Content-Type: " . $mime
        );
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $result = exec("mysqldump { $database } --user={ $user } --password={ $password } --host={ $host } --single-transaction | gzip --best", $output);

        if ($output) {
            Alert::success('Sukses', 'Database berhasil dibackup!');
            return redirect()->route('technical.index');
        }

        Alert::warning('Gagal', 'Database gagal dibackup!');
        return redirect()->route('technical.index');
    }
}
