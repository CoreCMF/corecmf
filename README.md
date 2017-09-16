# corecmf

## Structure

```     
resources/
src/
```

## Install

Via Composer

```bash
$ composer require corecmf/corecmf
```

## Usage
安装完成后需要在config/app.php中注册服务提供者到providers数组：
```
CoreCMF\Corecmf\CorecmfServiceProvider::class,
```
##install   
直接浏览器访问项目地址安装   
例: http://corecmf.dev/
```
php artisan corecmf:install
```
**Important Note: Compatibility with Symfony 3 Event Dispatcher**

If you are using Symfony 3 (or Symfony 3 components), please note that Omnipay 2.x still relies on Guzzle3, which in turn depends on symfony/event-dispatcher 2.x. This conflicts with Symfony 3 (standard install), so cannot be installed. Development for Omnipay 3.x is still in progress at the moment.

If you are just using the Symfony 3 components (eg. stand-alone or Silex/Laravel etc), you could try to force the install of symfony/event-dispatcher:^2.8, which is compatible with both Symfony 3 components and Guzzle 3.

```
composer require symfony/event-dispatcher:^2.8
```

**Please do not submit any more issues or pull requests for updating Omnipay from Guzzle 3 to GuzzleHttp.  The update is going to happen in Omnipay version 3.0 which is not yet ready for release.**
