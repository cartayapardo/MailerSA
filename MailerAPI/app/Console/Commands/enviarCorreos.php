<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreosUsuarios;
use App\Models\Correo;

class enviarCorreos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia los correos pendientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('enviando correos');
        $correos = Correo::where('estado', 'no enviado')->get();
        foreach ($correos as $correoUser) {
            Mail::to($correoUser->destinatario)->send(new CorreosUsuarios($correoUser));
            $enviado = Correo::find($correoUser->id);
            $enviado->update(['estado' =>'enviado']);
        }
        $this->info('Correos enviados');
    }
}
