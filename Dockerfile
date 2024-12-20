# Usa una imagen base de PHP
FROM php:8.3-cli


# Establece el directorio de trabajo
WORKDIR /app


# Copia el código de tu aplicación al contenedor
COPY . .


# Expone el puerto 10000
EXPOSE 10000


# Comando para iniciar el servidor PHP
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]