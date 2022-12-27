# Django Newspaper

## Project description

This project is a basic newspaper platform, it is inspired to the django for beginners project whose repository 
is available at https://github.com/wsvincent/djangoforbeginners


## Project configuration

In order to make it work the requisite are
```
mysql (mariadb)
python
```

### Configure python environment

(optional) Configure a virtualenv before by installing `python-virtualenv` and executing the command:
```shell
virtualenv venv && source venv/bin/activate
```

To configure python environment simply launch
```shell
pip install -r requirements.txt
```
NOTE: if you get an error installing mysqlclient, try installing python-mysqlclient in the system, it will install required packages

### Install and configure database
In order to interact with a mysql db, install mysql and create a db (edit configuration in `django_project/prod-settings.py` accordingly). For local development sqlite will be used.


## First Start in Development
Nothing different from standard django development environment, makemigration/migrate to apply migration on a sqlite 
database and runserver to start



## PRODUCTION 

Before deployment in production, test must be run:
```shell
python manage.py test accounts articles pages
```

In order to deploy the project in production, first you have to generate and export DJANGO_SECRET environment variable, and also set DJANGO_SETTINGS_MODULE environment variable to `django_project/production_settings.py`

In order to run a mysql docker instead of installing mysql on production site:
`docker run --rm --name django-db-test -e MYSQL_PASSWORD=password -e MYSQL_USER=django -e MYSQL_DATABASE=blog -e MYSQL_RANDOM_ROOT_PASSWORD='True' mysql`
where parameters are:
- MYSQL_DATABASE -> database name
- MYSQL_USER -> mysql user with all access to specified db 
- MYSQL_PASSWORD -> mysql user password
- MYSQL_RANDOM_ROOT_PASSWORD -> with any value different from NULL it randomly creates a root user password (mandatory)

The first 3 are necessary in django settings too

Migrations must be generated, **committed** and migrated, i.e. let say that there are changes in `pages` application models, steps should be:
```shell
python makemigrations pages
git add pages/migrations
git commit -m "Pages application's migrations added"
git push
python manage.py migrate
```
These step could be automated **BUT**:
- you should not generate migrations without verifying that they works
- migrations should not be generated directly in production
- migrations should be generated and applied into a database identical in terms of tables and relation to the production one


Project must be run with uwsgi, in order to do that you have to implement uwsgi.ini.example, specifically `chdir` parameter, eventually `pidfile` and `http`

Then run the server with the command:
`uwsgi --ini uwsgi.ini`

Complete documentation to uwsgi at https://uwsgi-docs.readthedocs.io/en/latest/WSGIquickstart.html


## DEVOPS assignment

For the DevOps improvements of this project there is no need for change to the logic of the application; the application must be considered as a legacy application.

Hence, DevOps changes must concentrate on automation and enhancement of the application's maintainer experience, as shon during last seminar on the matter.

### examples

WRONG enhancement:

Make dev and prod settings identical, that is, making so both development and production use the same database. It is a part of the project design making so that developer does not need a mysql server running.

RIGHT enhancement:

Create an environment variable that if set change the settings file to production_settings.py, which contains settings to work with mysql server, else it will backups on a sqlite instance.