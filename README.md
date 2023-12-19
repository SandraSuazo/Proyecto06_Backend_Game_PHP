
# GeeksHubs <img src= "src/assets/Readme/geek-logo.png" width="100"> 

<a>Proyecto 6- BACKEND ASANGAME.</a>

## Tabla de contenidos

- [Descripción 📝](#Descripción)
- [Diseño de la BBDD](#Diseño-de-la-BBDD)
- [Endpoints](#Endpoints)
- [Tecnologías - Bibliotecas - Herramientas 🛠️](#Tecnologías-y-Bibliotecas-Herramientas)
- [Instalación  🚀](#Instalación)
- [Endpoints ⛏️⚙️](#Endpoints)
- [Contribuciones  🤝](#Contribuciones)
- [Licencia y Copyright📃](#licencia-y-copyright)


## Descripción 

Backend AsanGames creado por **Sandra Suazo** y **Ángel Díaz Calleja** como parte del Bootcamp de Full Stack Developer de Geekshubs

AsanGames ha sido diseñado con la finalidad de recrear un portal de juegos utilizando **PHP, Laravel y mySQL**. El usuario podrá hacer register, login, editar y eliminar su perfil, así como acceder a información reservada si eres aadmin -listado de users o citas-, y creación de juegos, salas de juego y mensajes dentro de las mismas. 

## Diseño de la BBDD


# Endpoints del Proyecto 🚀

Este Backend está preparado para realizar los siguientes endpoints

- **REGISTER**

Permite registrar al usuario. Es necesario que cumpla la validación del nombre, email y password para poder registrarse.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| POST   | `http://localhost:8000/api/register` | Registra al usuario               |

**Payload de Ejemplo:**
```json
{
    "name": "Nombre del Usuario",
    "email": "correo@ejemplo.com",
    "password": "contraseña del Usuario"
}
```

- **LOGIN**

Permite loguear al usuario. Es necesario que cumpla la validación del email y password para poder acceder.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| POST   | `http://localhost:8000/api/login`    |         Loguea al usuario          |

**Payload de Ejemplo:**
```json
{
    "email": "correo@ejemplo.com",
    "password": "contraseña del Usuario"
}
```

- **LOGIN**

El usuario cierra sesión.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| POST   | `http://localhost:8000/api/logout`   |               Cierra sesión       |


