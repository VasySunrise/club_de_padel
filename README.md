# 🏓 Proyecto: Club de Pádel - Gestión Web

---

## 📄 Descripción

Este proyecto implementa un sistema de gestión para un club de pádel. Incluye funcionalidades para administrar usuarios, pistas y reservas, diferenciando entre administradores y usuarios normales. Los administradores pueden gestionar los datos del sistema (usuarios, pistas, reservas), mientras que los usuarios pueden realizar y cancelar sus propias reservas.

El sistema asegura una experiencia de usuario intuitiva y responsiva, incorporando seguridad como la verificación de contraseñas antes de acciones críticas.

---

## 💻 Tecnologías Utilizadas

- **Lenguaje:** PHP
- **Base de Datos:** MySQL
- **Frontend:**
    - HTML5
    - CSS3 (diseño responsivo)
    - JavaScript (interactividad y confirmaciones)
- **Entorno de Desarrollo:**
    - Visual Studio Code (u otros IDEs compatibles)
- **Control de Versiones:** Git
- **Servidor Local:** XAMPP o similar

---

## 📋 Requisitos

- **PHP:** Versión 7.4 o superior.
- **MySQL:** Base de datos configurada con el esquema del sistema.
- **Servidor Local:** XAMPP o cualquier otro servidor con soporte para PHP y MySQL.
- **Navegador Web:** Cualquier navegador moderno (Google Chrome, Mozilla Firefox, Microsoft Edge).
- **Git:** Para clonar y versionar el proyecto (opcional).

---

## 🛠️ Instalación

1. **Clonar el Repositorio:**
   ```bash
   git clone https://github.com/VasySunrise/club_de_padel.git
    ```
2. **Configurar el Servidor Local:**
   - Copia el proyecto a la carpeta `htdocs` de XAMPP (o el directorio raíz del servidor web configurado).

3. **Configurar la Base de Datos:**
   - Importa el archivo `db.sql` incluido en el proyecto a tu servidor MySQL.
     - Desde phpMyAdmin:
       1. Crea una base de datos llamada `padel`.
       2. Importa el archivo `database.sql` desde la opción "Importar".

4. **Configurar el Archivo de Conexión a la Base de Datos:**
   - Abre `includes/db.php` y ajusta las credenciales de acceso a tu base de datos:
     ```php
     $host = 'localhost:3306';
     $user = 'root';
     $password = '';
     $database = 'padel';
     ```

5. **Iniciar el Servidor Local:**
   - Abre el panel de XAMPP y activa los módulos `Apache` y `MySQL`.

---

## ▶️ Ejecución

Accede al sistema desde tu navegador web en:

   ```bash
   http://localhost/club-de-padel
   ```
## **1. Generar el usuario administrador**
1. Haz clic en el botón **"Generar Usuario 'ADMIN'"**. (esta opcion solo es accesible una vez.)
2. Introduce la contraseña que desees para el usuario administrador.
3. Haz clic en **"Crear Usuario"** para confirmar.

---

## **2. Volver al inicio e iniciar sesión**
Después de generar el usuario administrador:
1. Vuelve a la pantalla principal de inicio de sesión.
2. Introduce las credenciales:
    - **Usuario:** `admin`.
    - **Contraseña:** La que configuraste en el paso anterior.
3. Haz clic en **"Entrar"**.

---

## **2. Comenzar a usar la aplicación**
- **Administradores:**
    - Gestionar usuarios, pistas y reservas desde el panel de administración.
- **Usuarios:**
    - Realizar y cancelar reservas desde el panel de usuario.

---

## 🌐 Despliegue

El proyecto está diseñado para ejecutarse en un entorno local. No requiere despliegue en un servidor en línea, pero puede subirse a un hosting compatible con PHP y MySQL si se desea.

---

## 🤝 Contribuciones

Las contribuciones son bienvenidas para mejorar el sistema o añadir nuevas funcionalidades.

1. **Realizar un fork del repositorio:**
   ```bash
   git clone https://github.com/VasySunrise/club_de_padel.git
    ```
2. **Crear una nueva rama:**
   ```bash
   git checkout -b feature/nueva-funcionalidad
    ```
3. **Realizar los cambios y hacer un commit:**
   ```bash
   git commit -m "Añadir nueva funcionalidad"
    ```
4. **Enviar un Pull Request:** Explica los cambios realizados.

---

## 📜 Licencia

Este proyecto está diseñado con fines **educativos** y se encuentra bajo la **Licencia Pública de la Unión Europea (EUPL)**, versión 1.2. Esta licencia asegura que puedes usar, modificar y distribuir el software bajo los términos establecidos, promoviendo la colaboración y el acceso al conocimiento.

### Resumen de la EUPL:

- **Permisos:**
    - Uso personal y educativo.
    - Modificación y redistribución.
    - Inclusión en proyectos similares siempre que se respete la misma licencia.
- **Obligaciones:**
    - Incluir el aviso de copyright original.
    - Mantener la misma licencia para las obras derivadas.
    - Respetar las disposiciones legales aplicables.

#### Texto completo de la licencia:

La licencia EUPL 1.2 está disponible en todos los idiomas oficiales de la Unión Europea. Puedes leer el texto completo en español en el siguiente enlace:  
[Licencia EUPL 1.2 - Español](https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12).

---

```text
Licencia Pública de la Unión Europea, versión 1.2

Esta licencia cubre todas las obras protegidas por derechos de autor bajo las condiciones descritas. Permite copiar, distribuir y modificar el software, siempre que se respete esta misma licencia y se mantengan los términos del acuerdo.

Para detalles completos, consulta el enlace proporcionado arriba.
