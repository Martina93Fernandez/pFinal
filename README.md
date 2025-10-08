Proyecto pFinal
=================

Resumen
-------
Proyecto PHP estático con pequeño backend (MySQL) para gestión de socios.

Antes de subir a GitHub
-----------------------
- No subas credenciales reales. Este repositorio contiene `php/conexion.example.php` como plantilla. Crea `php/conexion.php` localmente con tus credenciales y NO lo subas.
- Asegúrate de que `php/conexion.php` esté en `.gitignore` (ya incluido).

Cómo preparar y probar localmente (Windows / XAMPP)
--------------------------------------------------
1. Copia la plantilla de conexión y configura tus credenciales:
   - Copia `php/conexion.example.php` -> `php/conexion.php` y edita host/usuario/contraseña/base_de_datos.

2. Arranca XAMPP: Apache y MySQL.

3. Crear tablas (si no existen):
   - Abre en el navegador: http://localhost/pFinal/php/crear_tablas.php

4. Abrir la app:
   - Login: http://localhost/pFinal/index.html

Pasos para subir a GitHub (resumen)
----------------------------------
En PowerShell (desde la carpeta del proyecto):

cd C:\xampp\htdocs\pFinal
git init
#Antes de añadir, asegúrate de que .gitignore existe y está correcto
git add .
git commit -m "Initial commit"

# Crear repo en GitHub (opción A: web)
# - Ve a https://github.com/new y crea un repositorio privado.
# - Después conecta y sube:
# git remote add origin https://github.com/USUARIO/REPO.git
# git branch -M main
# git push -u origin main

# (opción B: con GitHub CLI, si lo tienes instalado)
# gh repo create NOMBRE_REPO --private --source=. --remote=origin --push

Seguridad
--------
Si accidentalmente subiste `php/conexion.php` con credenciales, elimina el archivo del repo y cambia las credenciales en la base de datos (rotar contraseñas). Para eliminar del repo y del historial se requieren pasos adicionales (BFG/git filter-repo).

Contacto
--------
Si quieres, puedo:
- Crear el repo desde la CLI si me indicas el nombre y tienes instalado `gh`.
- Añadir instrucciones para eliminar secretos del historial si ya fueron commiteados.
