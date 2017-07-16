<?php

namespace CoreCMF\corecmf\Commands;

use Illuminate\Console\Command;

use CoreCMF\core\Support\Commands\Install;

class InstallCommand extends Command
{
    /**
     *  install class.
     * @var object
     */
    protected $install;
    protected $isDataSetted = false;
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     * @translator laravelacademy.org
     */
    protected $signature = 'corecmf:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'corecmf install';

    public function __construct(Install $install)
    {
        parent::__construct();
        $this->install = $install;
        $this->data = collect();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->install->publish('public'));
        if (!$this->isDataSetted) {
          $this->setDataCommands();
        }
        $this->setEnv();
        $this->installModule();
    }
    public function setEnv()
    {
         $this->info(
            $this->install->setEnv('APP_NAME', $this->data->get('website'))
         );
         $this->info(
            $this->install->setEnv('DB_CONNECTION', $this->data->get('driver'))
         );
         $this->info(
            $this->install->setEnv('DB_HOST', $this->data->get('database_host'))
         );
         $this->info(
            $this->install->setEnv('DB_PORT', $this->data->get('database_port'))
         );
         $this->info(
            $this->install->setEnv('DB_DATABASE', $this->data->get('database'))
         );
         $this->info(
            $this->install->setEnv('DB_USERNAME', $this->data->get('database_username'))
         );
         $this->info(
            $this->install->setEnv('DB_PASSWORD', $this->data->get('database_password'))
         );
    }
    public function installModule()
    {
       $this->install->installModule('core');
       $this->install->installModule('admin');
    }
    public function setDataCommands()
    {
        $this->data->put('driver', $this->ask('数据库引擎(mysql/pgsql/sqlite)：'));
        if (in_array($this->data->get('driver'), [
            'mysql',
            'pgsql',
        ])) {
            $this->data->put('database_host', $this->ask('数据库服务器：'));
            $this->data->put('database_port', $this->ask('数据库服务器端口(3306/5432)：'));
            $this->data->put('database', $this->ask('数据库名：'));
            $this->data->put('database_username', $this->ask('数据库用户名：'));
            $this->data->put('database_password', $this->ask('数据库密码：'));
        }
        // $this->data->put('database_prefix', $this->ask('数据库表前缀：'));
        $this->data->put('admin_account', $this->ask('管理员帐号：'));
        $this->data->put('admin_password', $this->ask('管理员密码：'));
        $this->data->put('admin_email', $this->ask('电子邮箱：'));
        $this->data->put('website', $this->ask('网站标题：'));
        $this->info('所填写的信息是：');
        $this->info('数据库引擎：' . $this->data->get('driver'));
        if (in_array($this->data->get('driver'), [
            'mysql',
            'pgsql',
        ])) {
            $this->info('数据库服务器：' . $this->data->get('database_host'));
            $this->info('数据库服务器端口：' . $this->data->get('database_port'));
            $this->info('数据库名：' . $this->data->get('database'));
            $this->info('数据库用户名：' . $this->data->get('database_username'));
            $this->info('数据库密码：' . $this->data->get('database_password'));
        }
        // $this->info('数据库表前缀：' . $this->data->get('database_prefix'));
        $this->info('管理员帐号：' . $this->data->get('admin_account'));
        $this->info('管理员密码：' . $this->data->get('admin_password'));
        $this->info('电子邮箱：' . $this->data->get('admin_email'));
        $this->info('网站标题：' . $this->data->get('website'));
        $this->isDataSetted = true;
    }
    /**
     * Get data controller.
     *
     * @param array $data
     */
    public function setSqlController(array $data)
    {
        $this->data->put('driver', $data['database_engine']);
        $this->data->put('database_host', $data['database_host']);
        $this->data->put('database', $data['database_name']);
        $this->data->put('database_username', $data['database_username']);
        $this->data->put('database_password', $data['database_password']);
        $this->data->put('database_port', $data['database_port']);
        // $this->data->put('admin_account', $data['account_username']);
        // $this->data->put('admin_password', $data['account_password']);
        // $this->data->put('admin_email', $data['account_mail']);
        $this->data->put('website', $data['sitename']);
        $this->isDataSetted = true;
    }
}
