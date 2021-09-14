<?php

namespace Sitic\Auth\Console\Commands\sitic;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Sitic\Settings\Http\Models\Setting;
use Sitic\Settings\Http\Models\SettingItem;

class InstallAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitic:auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install default settings.';

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
     * @return mixed
     */
    public function handle()
    {
        // Copy Migrations
        $this->mycopy(__DIR__. '/../../../database/migrations/2021_09_07_150923_create_users_table.php', base_path('/database/migrations/2021_09_07_150923_create_users_table.php'));
        $this->mycopy(__DIR__. '/../../../database/migrations/2016_06_01_000001_create_oauth_auth_codes_table.php', base_path('/database/migrations/2016_06_01_000001_create_oauth_auth_codes_table.php'));
        $this->mycopy(__DIR__. '/../../../database/migrations/2016_06_01_000002_create_oauth_access_tokens_table.php', base_path('/database/migrations/2016_06_01_000002_create_oauth_access_tokens_table.php'));
        $this->mycopy(__DIR__. '/../../../database/migrations/2016_06_01_000003_create_oauth_refresh_tokens_table.php', base_path('/database/migrations/2016_06_01_000003_create_oauth_refresh_tokens_table.php'));
        $this->mycopy(__DIR__. '/../../../database/migrations/2016_06_01_000004_create_oauth_clients_table.php', base_path('/database/migrations/2016_06_01_000004_create_oauth_clients_table.php'));
        $this->mycopy(__DIR__. '/../../../database/migrations/2016_06_01_000005_create_oauth_personal_access_clients_table.php', base_path('/database/migrations/2016_06_01_000005_create_oauth_personal_access_clients_table.php'));
        $this->mycopy(__DIR__. '/../../../database/migrations/2021_09_14_160411_create_jobs_table.php', base_path('/database/migrations/2021_09_14_160411_create_jobs_table.php'));

        // Copy Configs
        $this->mycopy(__DIR__. '/../../../config/auth.php', base_path('/config/auth.php'));
        $this->mycopy(__DIR__. '/../../../config/passport.php', base_path('/config/passport.php'));
        $this->mycopy(__DIR__. '/../../../config/permission.php', base_path('/config/permission.php'));
        $this->mycopy(__DIR__. '/../../../config/services.php', base_path('/config/services.php'));
        $this->mycopy(__DIR__. '/../../../config/sluggable.php', base_path('/config/sluggable.php'));
        $this->mycopy(__DIR__. '/../../../config/mail.php', base_path('/config/mail.php'));
        $this->mycopy(__DIR__. '/../../../config/queue.php', base_path('/config/queue.php'));

        // Copy Models
        $this->mycopy(__DIR__. '/../../../Http/Models/User.php', base_path('/app/Models/User.php'));

        // Copy Views
        $this->mycopy(__DIR__ . '/../../../resources/views/auth/reset/resetCodeCreated.blade.php', base_path('/resources/views/auth/UserResetPassword/resetCodeCreated.blade.php'));

        // Mail Views
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/themes/default.css', base_path('/resources/views/vendor/mail/html/themes/default.css'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/button.blade.php', base_path('/resources/views/vendor/mail/html/button.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/footer.blade.php', base_path('/resources/views/vendor/mail/html/footer.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/header.blade.php', base_path('/resources/views/vendor/mail/html/header.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/layout.blade.php', base_path('/resources/views/vendor/mail/html/layout.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/message.blade.php', base_path('/resources/views/vendor/mail/html/message.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/panel.blade.php', base_path('/resources/views/vendor/mail/html/panel.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/subcopy.blade.php', base_path('/resources/views/vendor/mail/html/subcopy.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/html/table.blade.php', base_path('/resources/views/vendor/mail/html/table.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/text/button.blade.php', base_path('/resources/views/vendor/mail/text/button.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/text/footer.blade.php', base_path('/resources/views/vendor/mail/text/footer.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/text/header.blade.php', base_path('/resources/views/vendor/mail/text/header.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/text/layout.blade.php', base_path('/resources/views/vendor/mail/text/layout.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/text/message.blade.php', base_path('/resources/views/vendor/mail/text/message.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/text/panel.blade.php', base_path('/resources/views/vendor/mail/text/panel.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/text/subcopy.blade.php', base_path('/resources/views/vendor/mail/text/subcopy.blade.php'));
        $this->mycopy(__DIR__. '/../../../resources/views/vendor/mail/text/table.blade.php', base_path('/resources/views/vendor/mail/text/table.blade.php'));
    }

    private function mycopy($s1,$s2) {
        $path = pathinfo($s2);
        if (!file_exists($path['dirname'])) {
            mkdir($path['dirname'], 0777, true);
        }
        if (!copy($s1,$s2)) {
            echo "copy failed \n";
        }
    }
}
