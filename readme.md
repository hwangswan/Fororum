<h1 align="center">Fororum</h1>
<p align="center">
  <i>Forum creavit cum Laravel</i>
</p>
<p align="center">
  <a href="https://github.styleci.io/repos/134251696"><img src="https://github.styleci.io/repos/134251696/shield?style=square" alt="StyleCI"></a>
  <a href="https://github.com/trhgquan/Fororum/blob/master/LICENSE"><img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="license"></a>
</p>

# What is Fororum, anyway?
An open-source Forum project made with Laravel 5.6. _Fororum_ in Latin means _Forums_.

This project also had a very-long-time-ago-and-simplest-as-i-could-thought name: _MyApp_.

# Why Fororum?
- Easy to install (which is not correct when you do not know what is Composer).
- SEO Friendly
- Fully-support admin in managing users and forum posts.

# Launching Fororum
## 1. Requirements:
- PHP >= 7.0
- Composer (for installing support packages).

## 2. Download
__Install via Git__.
```
git clone https://github.com/trhgquan/Fororum.git
```

Open the console (In Windows: Ctrl + Right click on the Fororum's folder -> Open Command Prompt here) and type the command below to install support packages.
```
composer install
```

## 3. Setting up

Now you need to configure your .env file, so these code can works!

- First of all, create a new database.

- Then, in the .env.example file, make some changes on these lines:

    ```
    DB_HOST=127.0.0.1   // to your database host
    ...
    DB_DATABASE=fororum // to your database name
    DB_USERNAME=root    // to your database username
    DB_PASSWORD=root    // to your database password
    ```

    Also on .env.example file, if you want to change the _Fororum_ name into your forum's name:

    ```
    APP_NAME=Fororum // to your Forum name.
    ```
    and then save it as `.env`

- Install the application's security key first:

    ```
    php artisan key:generate
    ```

- Then, we install the forum's database tables.

    Open the console in Fororum's folder, type this command and press Enter. Laravel Artisan will do everythings left for you.

    ```
    php artisan migrate
    ```

    Wait until Laravel Artisan install the forum database successfully.

- Next, we need to set up the admin account. In console, type

    ```
    php artisan db:seed
    ```

- After that, open your forum and login with your default credentials: admin / admin. From now on, Fororum is online!

# Authors
* **Quan, Tran Hoang** - *One-man army* - [trhgquan](https://github.com/trhgquan)
* **me_a_doge** - *unknown from dogeland* - [meadoge](https://github.com/meadoge)

# LICENSE
__Fororum is licensed under the MIT License__. [view LICENSE](https://github.com/trhgquan/Fororum/blob/master/LICENSE).

# Built with
* [Laravel](https://laravel.com) Laravel 5.6 - The newest PHP Framework for web artisans by Taylor Otwell
* [Bootstrap](https://getbootstrap.com) Bootstrap 3.3.7
