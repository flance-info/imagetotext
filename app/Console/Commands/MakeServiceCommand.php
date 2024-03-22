<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command {
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $name = $this->argument( 'name' );
        $path = app_path( "Services/{$name}.php" );
        if ( file_exists( $path ) ) {
            $this->error( "Service {$name} already exists!" );

            return;
        }
        $namespace = 'App\Services';
        $template  = str_replace(
            [ '{{namespace}}', '{{class}}' ],
            [ $namespace, $name ],
            $this->getStub()
        );
        if ( ! file_exists( app_path( 'Services' ) ) ) {
            mkdir( app_path( 'Services' ), 0777, true );
        }
        file_put_contents( $path, $template );
        $this->info( "Service {$name} created successfully." );
    }

    protected function getStub() {
        return <<<EOT
        <?php

        namespace {{namespace}};

        class {{class}}
        {
            //
        }
        EOT;
    }
}
