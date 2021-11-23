<?php

namespace Database\Seeders;

use App\Models\Consultant;
use App\Models\Entity;
use App\Models\Impact;
use App\Models\PaymentMethod;
use App\Models\Project;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('en_CA');

        $this->call([
            DatabaseSeeder::class,
            CollectionSeeder::class,
        ]);

        // Retrieve impacts.
        $communicationImpact = Impact::where('name->en', 'Communication')->first();
        $programsAndServicesImpact = Impact::where('name->en', 'Programs and services')->first();
        $transportationImpact = Impact::where('name->en', 'Transportation')->first();

        // Retrieve payment types.
        $cashPaymentMethod = PaymentMethod::where('name->en', 'Cash')->first();
        $giftCardPaymentMethod = PaymentMethod::where('name->en', 'Gift card')->first();

        // Retrieve sector.
        $transportationSector = Sector::where('name->en', 'Transportation')->first();

        $communityMember = User::factory()
            ->create([
                'name' => 'Jonny Appleseed',
                'email' => 'jonny@example.net',
                'email_verified_at' => now(),
            ]);

        $consultantPage = Consultant::factory()
            ->create([
                'user_id' => $communityMember->id,
                'name' => $communityMember->name,
                'bio' => $faker->sentences(3),
                'locality' => 'Toronto',
                'region' => 'ON',
                'pronouns' => 'He/him/his',
                'email' => $communityMember->email,
                'phone' => $faker->phoneNumber(),
            ]);

        // Attach impacts.
        $consultantPage->impacts()->attach([
            $communicationImpact->id,
            $programsAndServicesImpact->id,
            $transportationImpact->id,
        ]);

        // Attach payment methods.
        $consultantPage->paymentMethods()->attach([
            $cashPaymentMethod->id,
            $giftCardPaymentMethod->id,
        ]);

        // Attach sector.
        $consultantPage->sectors()->attach($transportationSector->id);

        $entityRepresentative = User::factory()
            ->create([
                'name' => 'Daniel Addison',
                'email' => 'daniel@example.com',
                'email_verified_at' => now(),
                'context' => 'entity',
            ]);

        $entity = Entity::factory()
            ->hasAttached($entityRepresentative, ['role' => 'admin'])
            ->create([
                'name' => 'Example Corporation',
                'locality' => 'Toronto',
                'region' => 'ON',
            ]);

        $entity->sectors()->attach($transportationSector->id);

        $completedProject = Project::factory()
            ->create([
                'name' => '2020 Accessibility Plan',
                'entity_id' => $entity->id,
                'start_date' => '2020-01-01',
                'end_date' => '2020-12-31',
                'found_consultants' => true,
                'confirmed_consultants' => true,
                'scheduled_planning_meeting' => true,
                'notified_of_planning_meeting' => true,
                'prepared_project_orientation' => true,
                'prepared_contractual_documents' => true,
                'booked_access_services_for_planning' => true,
                'finished_planning_meeting' => true,
                'scheduled_consultation_meetings' => true,
                'notified_of_consultation_meetings' => true,
                'prepared_consultation_materials' => true,
                'booked_access_services_for_consultations' => true,
                'finished_consultation_meetings' => true,
                'prepared_accessibility_plan' => true,
                'prepared_follow_up_plan' => true,
                'shared_plans_with_consultants' => true,
                'published_accessibility_plan' => true,
            ]);

        $completedProject->impacts()->attach($communicationImpact->id);
        $completedProject->paymentMethods()->attach([
            $cashPaymentMethod->id,
            $giftCardPaymentMethod->id,
        ]);

        $recruitingProject = Project::factory()
            ->create([
                'name' => '2022 Accessibility Plan',
                'entity_id' => $entity->id,
                'start_date' => '2022-01-01',
                'end_date' => '2022-12-31',
            ]);

        $recruitingProject->impacts()->attach($programsAndServicesImpact->id);
        $recruitingProject->paymentMethods()->attach([
            $cashPaymentMethod->id,
            $giftCardPaymentMethod->id,
        ]);

        $consultingProject = Project::factory()
            ->create([
                'name' => '2021 Accessibility Plan',
                'entity_id' => $entity->id,
                'start_date' => '2021-01-01',
                'end_date' => '2021-12-31',
                'found_consultants' => true,
                'confirmed_consultants' => true,
                'scheduled_planning_meeting' => true,
                'notified_of_planning_meeting' => true,
                'prepared_project_orientation' => true,
                'prepared_contractual_documents' => true,
                'booked_access_services_for_planning' => true,
                'finished_planning_meeting' => true,
            ]);

        $consultingProject->impacts()->attach($transportationImpact->id);
        $consultingProject->paymentMethods()->attach([
            $cashPaymentMethod->id,
            $giftCardPaymentMethod->id,
        ]);
    }
}
