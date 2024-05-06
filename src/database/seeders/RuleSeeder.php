<?php

namespace Database\Seeders;

use YFDev\System\App\Models\Rule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('rules') as $ruleData) {
            Rule::create([
                'name'        => $ruleData['name'],
                'method_id'   => $ruleData['method_id'],
                'permissions' => json_encode($ruleData['permissions']),
            ]);
        }
    }
}
