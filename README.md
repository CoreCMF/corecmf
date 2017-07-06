# corecmf

## Structure

```
databases/        
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
CoreCMF\corecmf\CorecmfServiceProvider::class,
```
##install
```
php artisan corecmf:install
```
