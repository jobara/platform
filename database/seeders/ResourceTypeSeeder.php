<?php

namespace Database\Seeders;

use App\Models\ResourceType;
use Illuminate\Database\Seeder;

class ResourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resource_types = [
            __('Guidelines and best practices'),
            __('Practical guides and how tos'),
            __('Templates and forms'),
            __('Case studies'),
        ];

        foreach ($resource_types as $resource_type) {
            ResourceType::firstOrCreate([
                'name->en' => $resource_type,
                'name->fr' => trans($resource_type, [], 'fr'),
            ]);
        }
    }
}
