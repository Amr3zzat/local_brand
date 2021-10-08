local Brand Demo Application
========================

The Employee management system demo

Requirements
------------

* PHP 7.4 or higher;
* PDO-SQLite PHP extension enabled;
* and the [usual Symfony application requirements][2].

Installation
------------


```bash
$ composer install
```
then
```bash
$ php bin/console doctrine:migrations:migrate
```

To load dummy data run:
```bash
$ php bin/console doctrine:fixtures:load
```

Usage
-----

There's no need to configure anything to run the application. If you have
[installed Symfony][5] binary, run this command:

```bash
$ symfony server:start
```

Command For upload file

curl --location --request POST 'http://127.0.0.1:8000/employee/upload' \
--form 'data=@"/dir/import.csv"'

API
-----
Docs can be found here (<http://127.0.0.1:8000/api/doc>)
