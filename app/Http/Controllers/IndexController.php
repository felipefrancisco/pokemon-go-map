<?php

namespace App\Http\Controllers;

use App\Services\MarkerService;
use App\Services\PokemonService;
use Illuminate\Support\Collection;
use App\Library\QuickGit;

class IndexController extends Controller
{
    /**
     * @var PokemonService
     */
    protected $pokemonService;

    /**
     * @var MarkerService
     */
    protected $markerService;

    /**
     * IndexController constructor.
     * @param PokemonService $pokemonService
     * @param MarkerService $markerService
     */
    public function __construct(PokemonService $pokemonService, MarkerService $markerService)
    {
        $this->pokemonService = $pokemonService;
    }

    /**
     * Main page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index.map', [
           'pokemon' => $this->pokemonService->get(),
           'version' => QuickGit::version()
        ]);
    }

    /**
     * Compile resources to generate compiled.js.
     *
     * @throws \Exception
     */
    public function compile()    {

        if(getenv('APP_ENV') == 'production')
            throw new \Exception('epa epa epa!');

        try {


            $files = new Collection();

            $js =  base_path() .'/public/js';

            $files->push( $js .'/functions.js' );
            $files->push( $js .'/angular/config.js' );
            $files->push( $js .'/angular/directives.js' );

            $path = $js .'/lib/';

            /** @var \DirectoryIterator $fileInfo */
            foreach (new \DirectoryIterator($path) as $fileInfo) {

                if($fileInfo->isDot())
                    continue;

                $files->push( $fileInfo->getPathname() );
            }

            $path = $js .'/angular/services/';

            /** @var \DirectoryIterator $fileInfo */
            foreach (new \DirectoryIterator($path) as $fileInfo) {

                if($fileInfo->isDot())
                    continue;

                $files->push( $fileInfo->getPathname() );
            }

            $path = $js .'/angular/controllers/';

            /** @var \DirectoryIterator $fileInfo */
            foreach (new \DirectoryIterator($path) as $fileInfo) {

                if($fileInfo->isDot())
                    continue;

                $files->push( $fileInfo->getPathname() );
            }

            $output = $js . '/compiled.js';

            $oldDir = getcwd();
            chdir(dirname(__FILE__));
            $fp = @fopen($output, 'w');
            chdir($oldDir);
            if ($fp === false) {
                throw new \Exception("Failed to open pipe: ${php_errormsg}");
            }

            foreach ($files as $file) {
                fwrite($fp, file_get_contents($file));
                fwrite($fp, "\n");
            }
            fclose($fp);

        }
        catch (\Exception $e) {

            echo $e->getMessage();
            die();
        }

    }
}