<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeHelper extends Command
{
    protected $signature = 'make:helper {name}';
    protected $description = 'Create a new helper class';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Helpers/{$name}.php");

        if (File::exists($path)) {
            $this->error("Helper {$name} already exists!");
            return false;
        }

        if (!File::isDirectory(app_path('Helpers'))) {
            File::makeDirectory(app_path('Helpers'), 0755, true);
        }

        $stub = <<<PHP
<?php

namespace App\Helpers;

class {$name}
{
    //
}

PHP;

        File::put($path, $stub);

        $this->info("Helper {$name} created successfully at app/Helpers/{$name}.php");
        return true;
    }
}
