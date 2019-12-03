<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [['name' => 'Anas', 'email' => 'anas@gmail.com'], ['name' => 'Ahmad', 'email' => 'ahmad@gmail.com']];
        foreach ($clients as $client) {

            Client::create([
                'first_name'    => $client['name'],
                'last_name'     => 'client',
                'email'         => $client['email'],
                'password'      => sha1(112233),
            ]); //-- end of create client

        } //-- end of foreach

    } //-- end of run
}//-- end of client seeder
