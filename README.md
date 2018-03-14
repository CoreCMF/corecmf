# corecmf

## Structure

```     
resources/
src/
```

## Install

Via Composer

```bash
$ composer require corecmf/corecmf:^2.3
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
