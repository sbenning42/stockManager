<?php

use Illuminate\Database\Seeder;

use App\Account;
use App\Role;
use App\FileType;
use App\Country;
use App\UserGlobalModelState;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AccountsTableSeeder');
        $this->command->info('Accounts table seeded!');
        $this->call('RolesTableSeeder');
        $this->command->info('Roles table seeded!');
        $this->call('FileTypesTableSeeder');
        $this->command->info('FileTypes table seeded!');
        $this->call('CountriesTableSeeder');
        $this->command->info('Countries table seeded!');
        $this->call('UserGlobalModelStatesTableSeeder');
        $this->command->info('UserGlobalModelStates table seeded!');
    }
}

class AccountsTableSeeder extends Seeder {
    
    public function run()
    {
        $accounts = ['none', 'partner', 'sponsor', 'prenium'];
        foreach ($accounts as $account) {Account::create(['name' => $account]);}
    }
    
}
class RolesTableSeeder extends Seeder {
    
    public function run()
    {
        $roles = ['none', 'user', 'admin', 'dev', 'god'];
        foreach ($roles as $role) {Role::create(['name' => $role]);}
    }
    
}
class FileTypesTableSeeder extends Seeder {
    
    public function run()
    {
        $types = ['none', 'picture', 'doc', 'raw'];
        foreach ($types as $type) {FileType::create(['name' => $type]);}
    }
    
}
class CountriesTableSeeder extends Seeder {
    
    public function run()
    {
        $countries = ['france', 'spain', 'belgium'];
        foreach ($countries as $country) {Country::create(['name' => $country]);}
    }
    
}
class UserGlobalModelStatesTableSeeder extends Seeder {
    
    public function run()
    {
        $states = ['none', 'created', 'submited', 'validated', 'incomplete', 'ineligible'];
        foreach ($states as $state) {UserGlobalModelState::create(['name' => $state]);}
    }
    
}

