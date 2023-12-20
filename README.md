
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

Backend AsanGames creado por **Ángel Díaz Calleja** y **Sandra Suazo López**  como parte del Bootcamp de Full Stack Developer de Geekshubs

AsanGames ha sido diseñado con la finalidad de recrear un portal de juegos utilizando **PHP, Laravel y mySQL**. El usuario podrá hacer register, login, editar y eliminar su perfil, así como acceder a información reservada si eres aadmin -listado de users o citas-, y creación de juegos, salas de juego y mensajes dentro de las mismas. 

## Diseño de la BBDD


# Endpoints del Proyecto 🚀

Este Backend está preparado para realizar los siguientes endpoints

**USERS**

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
| POST   | `http://localhost:8000/api/login`    |         Loguea al usuario         |

**Payload de Ejemplo:**
```json
{
    "email": "correo@ejemplo.com",
    "password": "contraseña del Usuario"
}
```

- **LOGOUT**

El usuario cierra sesión.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| POST   | `http://localhost:8000/api/logout`   |               Cierra sesión       |


- **PROFILE**

El usuario accede a su perfil.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| GET   | `http://localhost:8000/api/profile`   |          Muestra el perfil        |



- **UPDATE-PROFILE**

El usuario accede a su perfil.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| PUT    | `http://localhost:8000/api/user`     |          Modifica el perfil       |



**Payload de Ejemplo:**
```json
{
    "name": "nombreACambiar", 
    "email": "correo@ejemplo.com",
    "password": "contraseña del Usuario"
}
```
No es necesario modificar todos los cambios de forma conjunta, es decir, puedes cambiar, por ejemplo, simplemente el nombre. Para ello, en el payload debes indicar y rellenar los campos a modificar.


- **GET-ALL-USERS**

El admin puede listar todos los usuarios registrados.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| GET    | `http://localhost:8000/api/users`    |     Lista todos los usuarios      |


Esta acción sólo puede ser realizada si eres admin.


- **DELETE-USER**

El admin puede eliminar usuarios.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| DELETE | `http://localhost:8000/api/user/id`  |       Elimina el usuario          |

Esta acción sólo puede ser realizada si eres admin.

**GAMES**

- **CREATE-GAME**

Crea un juego nuevo. Es necesario que cumpla la validación del email y password para poder acceder.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| POST   |   `http://localhost:8000/api/game`   |         Crea un videojuego        |

**Payload de Ejemplo:**
```json
{
    "name": "Nombre del juego", 
    "category": "action",
}
```
El nombre del juego no debe superar los 60 carácteres y la categoría del juego puede ser **action, shooter o arcade**. El id del usuario que cree el juego será asignado al juego.


- **GET-GAME-BY-ID**

El usuario puede buscar un videojuego por el id del mismo

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
|  GET   |  `http://localhost:8000/api/game/id` |      Burcar videojuego por Id     |

- **GET-ALL-GAMES**

El usuario puede buscar todos los videojuegos que han sido creados.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
|  GET   |   `http://localhost:8000/api/games`  |   Mostrar todos los videojuegos   |

- **UPDATE-GAME**

Funcionalidad reservada al admin. Debe introducirse el id del videojuego a editar.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
|  PUT   |  `http://localhost:8000/api/game/id` |       Editar un videojuego        |

**Payload de Ejemplo:**
```json
{
    "name": "Nombre del juego", 
    "category": "action",
}
```
Puede ser modificado simplemente uno de los campos o todos si así se desea. Para ello, en el payload debes indicar y rellenar los campos a modificar.

- **DELETE-GAME**

Funcionalidad reservada al admin. Debe introducirse el id del videojuego a eliminar.

| Método |              Endpoint                |             Descripción           |
|--------|--------------------------------------|-----------------------------------|
| DELETE |  `http://localhost:8000/api/game/id` |      Elimina un videojuego        |



