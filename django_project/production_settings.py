import os
from django_project.settings import *

# import pymysql
# pymysql.install_as_MySQLdb()

DATABASES = {
    "default": {
        "ENGINE": "django.db.backends.mysql",
        "NAME": os.environ.get("MYSQL_DATABASE", "blog"),
        "USER": os.environ.get("MYSQL_USER", "django"),
        "PASSWORD": os.environ.get("MYSQL_PASSWORD", "django_password"),
        "HOST": os.environ.get("MYSQL_HOST", "db"),  # Nome servizio Docker
        "PORT": os.environ.get("MYSQL_PORT", "3306"),
        "OPTIONS": {
            "charset": "utf8mb4",
        },
    }
}


SECRET_KEY = os.environ.get("DJANGO_SECRET_KEY", "temp-key")
ALLOWED_HOSTS = ["localhost", "127.0.0.1", "web"]
