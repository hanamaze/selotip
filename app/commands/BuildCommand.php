<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BuildCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'build';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Build everything we need.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if (!$this->option('no-less'))
		{
			$this->info('Compile "less" files into "public/css/style.min.css"...');

		    $inputFile = app_path().'/assets/less/style.less';
		    $outputFile = public_path().'/css/style.min.css';

		    $less = new lessc;
		    $less->setFormatter('compressed');

		    // Create a new cache object, and compile
		    $cache = $less->cachedCompile($inputFile);

		    file_put_contents($outputFile, $cache["compiled"]);

		    // The next time we run, write only if it has updated
		    $last_updated = $cache["updated"];
		    $cache = $less->cachedCompile($cache);
		    if ($cache["updated"] > $last_updated) {
		        file_put_contents($outputFile, $cache["compiled"]);
		    }
		}

		$this->call('clear');

		if (PHP_OS == 'Linux')
		{
			$this->info('Execute "chmod 775 -R ./app/storage/"');
			exec('chmod 777 app/storage/');
		}

		$this->info('Drop all tables...');
		$this->call('migrate:reset');

		$this->info('Migrating...');
		$this->call('migrate', array('--package' => 'cartalyst/sentry'));
		$this->call('migrate');

		if (!$this->option('no-seed')) {
			$this->info('Seeding...');
			$this->call('db:seed');
		}

		$this->info('Done!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	// protected function getArguments()
	// {
		// return array(
			// array('example', InputArgument::OPTIONAL, 'An example argument.'),
		// );
	// }

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('no-less', null, InputOption::VALUE_NONE, 'Don\'t compile less files into CSS.', null),
			array('no-seed', null, InputOption::VALUE_NONE, 'Don\'t seed', null),
		);
	}

}
