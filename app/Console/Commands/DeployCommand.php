<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class DeployCommand extends Command
{
    const SERVER_DEVELOPMENT = 'dev';
    const SERVER_LIVE = 'live';
    const SERVER_PRODUCTION = 'production';

    const SERVER_DEVELOPMENT_HOST = '';
    const SERVER_LIVE_HOST = 'live';
    const SERVER_PRODUCTION_HOST = '';
    const SERVER_LOCAL_HOST = 'vagrant@';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy application to server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->getDeploymentData();
        $this->startDeployment($data);

    }

    private function getDeploymentData(): array
    {
        $data = [];

        $data['server'] = select(
            label: 'Select server to deploy to.',
            options: ['dev', 'live', 'production'],
            default: 'dev',
            required: true
        );

        $data['branch'] =  select(
            label: 'Select github branch to deploy from',
            options: ['enhanced', 'new-prod', 'master'],
            default: 'enhanced',
            required: true
        );

        $data['appName'] = text(
            label: 'Write app name',
            placeholder: 'code/roms_backend',
            default: 'code/roms_backend',
            required: true,
            hint: 'Make sure to write the correct path to your app folder.'
        );

        $data['withBuild'] = confirm(
            label: 'Do you want to deploy with build?',
            default: true,
            yes: "Yes",
            no: "No",
            hint: "Choosing 'yes' means building assets on your local, push it to github,
            reset local after build, removing built assets, push to github again"
        );

        $data['pushMessage'] = text(
            label: 'Write push message',
            placeholder: 'build for delpoy',
            default: "build for ".$data['server'],
            hint: 'This message will be reflected in github commits.',
            required: true
        );

        $data['localIp'] = text(
            label: 'Enter your Homestead IP',
            placeholder: '192.168.56.56',
            default: "192.168.56.56",
            required: true
        );

        return $data;
    }

    private function startDeployment($data): void
    {
        if ($data['withBuild']) {

            $this->buildOnLocal($data);
            $this->deployToServer($data);
            $this->resetAfterBuild($data);

        } else {

            $this->deployToServer($data);
        }
    }

    private function buildOnLocal($data): void
    {
        echo "<----------------------start build on local---------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";

        $commands = [
            'cd '.$data['appName'],
            'pwd',
            "npm install",
            "npm run build-mode ".$data['server'],
            "git add .",
            "git commit -m '".$data['pushMessage']."'",
            "git pull origin ".$data['branch'],
            "git push origin ".$data['branch']
        ];

        $result = Process::run('ssh '.self::SERVER_LOCAL_HOST.$data['localIp'].' 2>&1 "'.implode(' && ', $commands).'"',
        function (string $type, string $output) {
            echo $output;
        });

        echo $result->output()."\r\n";
        echo "*********************** end push after building assets ***********************\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<---------------------- end build on local ---------------------->\r\n";
    }

    private function deployToServer($data):void
    {
        if ($data['server'] === self::SERVER_DEVELOPMENT) {

            $this->deployToDevelopment($data);

        } elseif ($data['server'] === self::SERVER_PRODUCTION) {

            $this->deployToProduction($data);
        }

    }

    private function deployToDevelopment($data): void
    {
        echo "<---------------------- start deploy on ".$data['server']." server ---------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";

        $commands = [
            'cd public_html',
            'pwd',
            'git pull origin '.$data['branch'].' --ff',
            '/opt/cpanel/ea-php82/root/bin/php /opt/cpanel/composer/bin/composer install --optimize-autoloader --ignore-platform-reqs',
            'php artisan migrate --force',
            'php artisan optimize:clear',
            'php artisan queue:restart'
        ];

        $result = Process::run('ssh '.self::SERVER_DEVELOPMENT_HOST.' 2>&1 "'.implode(' && ', $commands).'"',
        function (string $type, string $output) {
            echo $output;
        });

        echo $result->output()."\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<---------------------- end deploy on ".$data['server']." server ---------------------->\r\n";
    }

    private function deployToProduction($data): void
    {
        echo "<---------------------- start deploy on ".$data['server']." server ---------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";

        $commands = [
            'cd /var/www/html/new-roms/',
            'pwd',
            'git config --global --add safe.directory /var/www/html/new-roms',
            'git pull origin '.$data['branch'].' --ff',
            'composer install --optimize-autoloader --ignore-platform-reqs',
            'php artisan migrate --force',
            'php artisan optimize:clear',
            'php artisan queue:restart'
        ];

        $result = Process::run('ssh '.self::SERVER_PRODUCTION_HOST.' 2>&1 "'.implode(' && ', $commands).'"',
        function (string $type, string $output) {
            echo $output;
        });

        echo $result->output()."\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<---------------------- end deploy on ".$data['server']." server ---------------------->\r\n";
    }

    private function resetAfterBuild($data): void
    {
        echo "<---------------------- start reset local after build ---------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";

        $commands = [
            'cd '.$data['appName'],
            'pwd',
            'rm -rf public/build',
            'git add .',
            "git commit -m '".$data['pushMessage']."'",
            'git pull origin '.$data['branch'],
            'git push origin '.$data['branch']

        ];

        $result = Process::run('ssh '.self::SERVER_LOCAL_HOST.$data['localIp'].' 2>&1 "'.implode(' && ', $commands).'"',
        function (string $type, string $output) {
            echo $output;
        });

        echo $result->output()."\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<-------------------------------------------------------------------------->\r\n";
        echo "<----------------------end reset local after build---------------------->\r\n";
    }
}
