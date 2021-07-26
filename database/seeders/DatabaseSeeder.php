<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     * @return void
     */
    public function run() {

        /* RANDOMISER */
        $account = Account::create(['name' => 'Vaskador Space']); 

        User::factory()
            ->create([
                'account_id' => $account->id,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'johndoe@example.com',
                'owner' => true,
            ],
        );

        User::factory(4)
            ->create(['account_id' => $account->id])
            ->each(function ($user) use ($account) {
                $user->update(['account_id' => $account->id]);
            });

        $organisations = Organisation::factory(10)
            ->create(['account_id' => $account->id])
            ->each(function ($organisation) use ($account) {
                $organisation->update(['account_id' => $account->id]);
            });

        Contact::factory(20)
            ->create()
            ->each(function ($contact) use ($organisations) {
                $contact->update(
                    ['organisation_id' => $organisations->random()->id],
                    ['account_id' => 1]
                );
            });
    }
}
