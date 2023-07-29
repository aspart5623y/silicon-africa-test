<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {repo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function repoPath($repo)
    {
        $repo = str_replace('.','/',$repo). '.php';

        $path = 'app/Repositories/'.$repo;

        return $path;
    }

    public function createDir($path)
    {
        $dir = dirname($path);

        if (! file_exists($dir)) {

            mkdir($dir,0777,true);
        }
    }

    public function handle()
    {
        $repo = $this->argument('repo');

        $path = $this->repoPath($repo);

        $this->createDir($path);

        if (File::exists($path)) {

            $this->error('Repository already exists!');

            return;
        }

        $class = explode('/', $repo);
        $class_path = array_pop($class);
        $class = implode("\\", $class);

        $write = "<?php
namespace App\Repositories\\".$class.";

class ".$class_path."
{
    //
}";

        File::put($path, $write);

        $this->info('Repository created successfully.');
    }
}
