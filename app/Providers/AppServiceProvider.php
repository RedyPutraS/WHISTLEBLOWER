<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $email = Pengaturan::active()->where('pgtr_label', 'Konfigurasi SMTP Email')->pluck('pgtr_nilai', 'pgtr_nama');
        if ($email) {
            $config = array(
                'transport'     => $email['Mailer'],
                'host'       => $email['Host'],
                'port'       => $email['Port'],
                'from'       => array('address' => $email['Username'], 'name' => 'PT. Multi Nitrotama Kimia (MNK)'),
                'encryption' => $email['Enkripsi'],
                'username'   => $email['Username'],
                'password'   => $email['Password'],
            );
            
            config(['mail.mailers.smtp' => $config]);
        }
    }
}
