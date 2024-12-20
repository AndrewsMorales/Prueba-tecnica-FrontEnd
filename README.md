
# Prueba Técnica - Proyecto de Cocteles

Este proyecto fue desarrollado como parte de una prueba técnica para un puesto de trabajo. En este proyecto, se consume una API externa para obtener datos relacionados con cocteles. El sistema está desarrollado en **Laravel**, **Laravel Brezze** y utiliza varias librerías como **DataTables**, **Bootstrap**, **jQuery** y **SweetAlert**.

## Características del Proyecto

### 1. **Tablas y Procesamiento de Datos**
   - **Tabla de Cocteles en la Nube**: La primera tabla muestra los cocteles obtenidos desde una API externa en formato JSON mediante **Ajax**. Los datos se procesan en el lado del cliente para ser visualizados en el frontend.
   - **Tabla de Cocteles Locales**: La segunda tabla es un **DataTable** con procesamiento del lado del servidor (**Server-side**). Aquí, toda la carga, búsqueda y procesamiento de los datos se realiza en el servidor, y se pueden aplicar filtros y límites a la consulta de la base de datos.

### 2. **Actualización de Cocteles**
   - **Botón de Actualización Local**: Permite al usuario guardar los cambios que haya realizado en los datos de un coctel.
   - **Botón de Actualización desde la Nube**: Consulta la API externa para obtener la última versión de los datos del coctel y los actualiza en la base de datos.

## Requisitos para la Instalación

Antes de comenzar con la instalación del proyecto, asegúrate de tener instalados los siguientes programas:

- **Node.js**: Necesario para gestionar las dependencias del frontend.
- **Composer**: Para gestionar las dependencias de PHP.
- **Wamp o Xamp**: Para configurar un servidor local con PHP y MySQL.

### Pasos para la Instalación

1. **Generar la clave de la aplicación**:
   Ejecuta el siguiente comando para generar la clave de la aplicación en Laravel:
   ```bash
   php artisan key:generate
   ```

2. **Instalar las dependencias de Node.js**:
   Ejecuta el siguiente comando para instalar las dependencias necesarias para el frontend:
   ```bash
   npm install
   ```

3. **Compilar los archivos**:
   Para preparar los archivos que serán consumidos por el proyecto, ejecuta uno de los siguientes comandos:
   - Para producción:
     ```bash
     npm run build
     ```
   - Para desarrollo:
     ```bash
     npm run dev
     ```

4. **Instalar las dependencias de PHP**:
   Ejecuta el siguiente comando para instalar las dependencias de PHP necesarias:
   ```bash
   composer install
   ```

5. **Migrar la base de datos**:
   Antes de ejecutar la migración, asegúrate de haber creado la base de datos en tu servidor MySQL. Luego, ejecuta el siguiente comando para crear las tablas necesarias:
   ```bash
   php artisan migrate
   ```

6. **Configurar la base de datos**:
   Asegúrate de configurar correctamente la conexión de la base de datos en el archivo `.env` de tu proyecto. Aquí tienes un ejemplo de configuración:

   ```env
   APP_NAME=Laravel
   APP_ENV=local
   APP_KEY=base64:nMBUqD8t7kAGxQZmJVsnL/gTBlsLnGxbn1ON4JUq8AM=
   APP_DEBUG=true
   APP_TIMEZONE=UTC
   APP_URL=http://localhost/prueba_tecnica_fronend

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=prueba_tecnica_fronend
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### Uso del Aplicativo

1. **Registro**:
   Para usar la aplicación, primero debes registrarte.

2. **Guardar un Coctel**:
   Si al guardar un coctel no se guarda correctamente y muestra un mensaje de error indicando que intentes más tarde, no te preocupes. Este problema puede deberse a que la API externa que se utiliza en el proyecto tiene una versión dinámica para el acceso gratuito, lo que puede hacer que no siempre se obtengan los datos correctamente. Si encuentras este problema, espera un momento y vuelve a intentarlo.

---

## Notas Adicionales

Antes de ejecutar la migración (`php artisan migrate`), asegúrate de haber creado la base de datos y de haber configurado correctamente los detalles de la conexión en el archivo `.env`.

