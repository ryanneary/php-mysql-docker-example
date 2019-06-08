# php-mysql-docker-example
This is an example setup of two Docker containers:
- `mysql`: Running MySQL 8.0.
- `web`: Running PHP 7.2 on Debian's Apache httpd.

## Prerequisites
- Docker
- Make
- A web browser

## File structure
Familiarise yourself with the file structure. It will help you understand what everything does.

### `service/mysql/init`
Your custom `.sql` and/or `.sh` files. These are executed in alphanumerical order when the `mysql` container is
initialised.

### `service/web`
- `php.ini` is your custom PHP configuration.
- `Dockerfile`:
  - Copies the aforementioned `php.ini` file.
  - Installs the `pdo_mysql` extension.

### `src`
Sample PHP code that is executed on the `web` container, and connects to a sample `app` database on the `mysql`
container.

### `.env.example`
Example file for you to copy, when creating your custom `.env` file. The `.env` file will contain environment variables
that are used to build the containers.

### `.gitignore`
Tells `git` to ignore the `.env` file from commits, since it's environment-specific.

### `docker-compose.yml`
Defines the `mysql` and `web` containers.

### `Makefile`
Defines `make` commands to be run from the command line in the project's root directory.

This includes common Docker commands, but you can add other common developer commands as well.

## Build the containers
1. Copy `.env.example` to create your own `.env` file in the root project directory.
1. Run `make clean` to build the Docker containers.

## Connect to the `web` container
1. Run `make web` to connect to the `web` container as the `root` user in a new Bash session.
1. Run `ls -la`, and optionally try some other Bash commands.
1. Run `exit` when you're done.

## Connect to the `mysql` container
1. Run `make mysql` to connect to the `mysql` container as the `root` user in a new MySQL session.
1. Run `show databases;`, and optionally try some other MySQL commands.
1. Run `exit` when you're done.

If you'd prefer to connect via a database management app, the details are:

| Label    | Value                                                  |
| -------- | ------------------------------------------------------ |
| Host     | `0.0.0.0`                                              |
| Username | `root`                                                 |
| Password | The value of `MYSQL_ROOT_PASSWORD` in your `.env` file |
| Port     | The value of `HOST_PORT_MYSQL` in your `.env` file     |

## Test the app
1. Visit `http://localhost:90` in your web browser, where `90` is the port you configured.
1. The first time the page loads successfully, it'll create a user in the database.
1. Subsequent page loads will fetch the previously-created user's data from the database.
1. Try adding `echo 'Hello world';` to `indexAction` within the file `src/AppBundle/Controller/IndexController.php`,
then reload the page. Your change should take effect immediately.

## Container logs
If a container falls over, check `make logs-mysql` or `make logs-web` to work out why.

## Notes:
- "Connection refused" occurs when the MySQL container has not fully initialised yet, so you may need to wait a few
seconds for it to finish.
- If the containers are killed (e.g. you restart your machine), running `make up` will restart them, without losing
any modifications (i.e. if you have manually modified the database or filesystem after `make clean`).
- If you run `make clean` again, this will destroy the containers and create new ones.
- If you make changes to `service/mysql/init`, you will need to run `make clean` for the changes to take effect.
