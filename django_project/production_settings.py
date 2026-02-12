import os
from django_project.settings import *

# import pymysql
# pymysql.install_as_MySQLdb()

db_options = {
    "charset": "utf8mb4",
}

# SE E SOLO SE siamo in GitLab CI, disabilitiamo la verifica SSL
if os.environ.get("GITLAB_CI") == "true":
    db_options["ssl"] = {"disabled": True}

DATABASES = {
    "default": {
        "ENGINE": "django.db.backends.mysql",
        "NAME": os.environ.get("MYSQL_DATABASE", "blog"),
        "USER": os.environ.get("MYSQL_USER", "django"),
        "PASSWORD": os.environ.get("MYSQL_PASSWORD", "django_password"),
        "HOST": os.environ.get("MYSQL_HOST", "db"),  # Nome servizio Docker
        "PORT": os.environ.get("MYSQL_PORT", "3306"),
        "OPTIONS": db_options,
    }
}


SECRET_KEY = os.environ.get("DJANGO_SECRET_KEY", "temp-key")
ALLOWED_HOSTS = ["localhost", "127.0.0.1", "web"]
