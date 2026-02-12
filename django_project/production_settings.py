import os
from django_project.settings import *

# import pymysql
# pymysql.install_as_MySQLdb()


DATABASES = {
    "default": {
        "ENGINE": "django.db.backends.mysql",
        # abbiamo tolto tutti i default per forzare l'uso delle variabili d'ambiente, così da evitare errori di connessione in produzione
        "NAME": os.environ.get("MYSQL_DATABASE"),
        "USER": os.environ.get("MYSQL_USER"),
        "PASSWORD": os.environ.get("MYSQL_PASSWORD"),
        "HOST": os.environ.get("MYSQL_HOST"),  # Nome servizio Docker
        "PORT": os.environ.get("MYSQL_PORT"),
        "OPTIONS": {
            "charset": "utf8mb4",
        },
    }
}


SECRET_KEY = os.environ.get("DJANGO_SECRET_KEY", "temp-key")
ALLOWED_HOSTS = ["localhost", "127.0.0.1", "web"]
