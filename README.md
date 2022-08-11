# Symfony Docker LEMP

Docker box for running dummy Symfony project

## Prerequisites

### Required

It is assumed you have Docker installed and it can run commands as root.

---

## What's Included

* Ubuntu Server v20.04 LTS (Focal Fossa) 64bit
* Nginx
* PHP 7.4
* PHP 8.1
* MariaDB
* Redis
* Adminer
* Symfony core

---

## Installation

The first time you clone the repo.

```bash
git clone https://github.com/alex-kalanis/symfony-docker-lemp.git
cd symfony-docker-lemp
```

Now install system with simple commands. This also bring the box up.
That may take several minutes. If it doesn't explicitly
fail/quit, then it is still working.

```bash
./install.sh
```

Once the Docker finishes and is ready, you can verify PHP is working at
[http://localhost:40000/](http://localhost:40000/) for 7.4,
[http://localhost:40001/](http://localhost:40001/) for 8.1 and
[http://localhost:40009/](http://localhost:40009/) for Adminer.

## Default settings

MySQL
* root pass: 951357456852
* user: kalasymfony
* pass: kalasymfony654

Postgres
* user: kalasymfony
* pass: kalasymfony654

The aplication itself contains Symfony for basics, kw_mapper, kw_table and
kw_form for data manipulation and also Clipr for running tasks, so you can
run things inside php box and with docker syntax also from external environment.
Also many things can be set by running with different environment variables,
so you can change default users and passwords used to connections.

## Caveats

MariaDB install likes to crash with that chain of commands from CLI, so then
it's necessary to run its steps directly from included Adminer. Log as root
into database and then copy content of script
*application/migrations/system_user.sql* into SQL query textarea and
run it. Then you can run again install from CLI to process migrations.
Or if you are comfortable with CLI and phinx you can paste the command
directly into php docker shell.
