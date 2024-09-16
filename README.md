# Todo-list Back-end

Este proyecto es la parte del frontend del todo list.

## Primeros Pasos

Para comenzar con el desarrollo, sigue estos pasos:

1. **Instala las dependencias**

   Ejecuta el siguiente comando para instalar las dependencias del proyecto:

   ```bash
   composer install
   ```

2. **Variables de entorno**

   Crea un archivo llamado `.env` en la raíz del proyecto y copia el contenido del archivo `.env.example`, cambia los valores de las variables que sean necesarias por ejemplo las de la conexión a la base de datos (es necesario tener una base de satos ya creada para el proyecto) y las credenciales del correo, aunque no es necesario cambiar las del correo ya que las que están configuradas funcionan.
   

3. **Creación de tablas con seeders**

   Ejecuta el siguiente comando para crear las tablas con datos de prueba:

   ```bash
   php artisan migrate --seed
   ```

   Los usuarios que se crearan por defecto son:
    - Diego Ramos
        - Usuario: diego@example.com
        - Contraseña: pass123

    - Ana Gómez
        - Usuario: ana@example.com
        - Contraseña: pass123

4. **Inicio del proyecto**

   Ejecuta el siguiente comando para iniciar el proyecto:

   ```bash
   php artisan serve
   ```

    Abre [http://localhost:8000](http://localhost:8000) con tu navegador.
