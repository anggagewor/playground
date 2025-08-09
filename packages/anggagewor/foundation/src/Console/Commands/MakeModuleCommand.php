<?php

namespace Anggagewor\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeModuleCommand extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Generate a new module with Clean Architecture structure';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $module = Str::studly($this->argument('name'));
        $basePath = app_path("Modules/{$module}");

        if ($this->files->exists($basePath)) {
            $this->error("Module {$module} already exists!");
            return self::FAILURE;
        }

        // Struktur folder Clean Architecture
        $dirs = [
            "Domain/Entities",
            "Domain/Interfaces",
            "Application/UseCases",
            "Infrastructure/Services",
            "Interface/Http/Controllers",
            "Providers",
            "routes",
        ];

        foreach ($dirs as $dir) {
            $this->files->makeDirectory("{$basePath}/{$dir}", 0755, true);
        }

        // Generate file dari stub
        $this->publishStub('UseCase.stub', "{$basePath}/Application/UseCases/SampleUseCase.php", $module);
        $this->publishStub('Controller.stub', "{$basePath}/Interface/Http/Controllers/{$module}Controller.php", $module);
        $this->publishStub('ModuleServiceProvider.stub', "{$basePath}/Providers/ModuleServiceProvider.php", $module);
        $this->publishStub('web.stub', "{$basePath}/routes/web.php", $module);
        $this->publishStub('api.stub', "{$basePath}/routes/api.php", $module);

        $this->info("✅ Module {$module} created successfully with Clean Architecture structure.");
        $this->warn("⚠️  Don't forget to register App\\Modules\\{$module}\\Providers\\ModuleServiceProvider in config/app.php or via auto-discovery.");
        return self::SUCCESS;
    }

    private function publishStub(string $stubName, string $destination, string $module): void
    {
        $stubPath = __DIR__ . "/../../../stubs/{$stubName}";
        if (! file_exists($stubPath)) {
            $this->error("Stub {$stubName} not found at {$stubPath}");
            return;
        }
        $content = str_replace('{{ module }}', $module, file_get_contents($stubPath));
        $this->files->put($destination, $content);
    }
}
