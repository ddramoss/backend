<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncate('tasks');

        $user_ids = User::pluck('id')->toArray();

        $statuses = ['Pendiente','En progreso','Completada'];
        $priorities = ['Baja','Media','Alta'];

        foreach ($user_ids as $user_id) {
            for ($i=1; $i <= 15 ; $i++) {

                $year = rand(2024, 2025);
                $month = rand(1, 12);
                $day = rand(1, 28);

                $due_date = "$year-$month-$day";
                $status = $statuses[array_rand($statuses)];
                $priority = $priorities[array_rand($priorities)];

                Task::create([
                    'user_id' => $user_id,
                    'title' => "Tarea $i",
                    'description' => "Descripción de la tarea $i",
                    'due_date' => $due_date,
                    'status' => $status,
                    'priority' => $priority,
                ]);
            }
        }
    }

    /**
     * truncate
     *
     * @param  string $table
     * @return void
     */
    public function truncate(string $table): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS =0;');
        DB::table($table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS =1;');
    }
}
