# TFG - Sistema de Gestión de Almacén

**Proyecto Final de Grado Superior**

## 📋 Descripción

Este proyecto constituye un Trabajo de Fin de Grado Superior desarrollado por Pablo Martínez Mainer. Se trata de una aplicación web completa diseñada para automatizar y optimizar la gestión integral de almacenes, inventarios y cadena de suministro en pequeñas y medianas empresas.
El sistema nace de la necesidad real de las empresas de modernizar sus procesos de gestión de stock, históricamente llevados en hojas de cálculo o sistemas legacy poco eficientes. Esta solución proporciona una interfaz web intuitiva y accesible desde cualquier dispositivo con conexión a internet, eliminando la necesidad de instalaciones complejas.

## 🚀 Características

- **Gestión de Inventario**: Control completo del stock y productos almacenados
- **Componentes**: Administración de componentes y piezas
- **Proveedores**: Gestión de información de proveedores
- **Referencias**: Sistema de referencias de productos
- **Sugerencias**: Módulo de sugerencias y recomendaciones
- **Tipos**: Clasificación por tipos de productos
- **Sistema de Autenticación**: Login seguro con gestión de sesiones

## 🛠️ Tecnologías Utilizadas

- **Frontend**:
  - HTML5
  - CSS3
  - JavaScript

- **Backend**:
  - PHP

- **Base de Datos**:
  - MySQL

- **Estructura**:
  - Arquitectura MVC (Model-View-Controller)
  - Sistema de includes para componentes reutilizables

## 📁 Estructura del Proyecto

```
TFG/
├── bd/                    # Scripts y configuración de base de datos
├── componente/            # Módulo de gestión de componentes
├── imagenes/              # Recursos gráficos
├── include/               # Archivos PHP reutilizables (header, footer, etc.)
├── inventario/            # Módulo de gestión de inventario
├── lib/                   # Librerías y dependencias
├── proveedor/             # Módulo de gestión de proveedores
├── referencia/            # Módulo de gestión de referencias
├── sugerencia/            # Módulo de sugerencias
├── tipo/                  # Módulo de tipos de productos
├── almacen.sql           # Schema de la base de datos
├── doLogin.php           # Procesamiento de autenticación
├── index.php             # Página principal
├── login.php             # Página de login
└── logout.php            # Cierre de sesión
```

## 📊 Base de Datos

El archivo `almacen.sql` contiene la estructura completa de la base de datos, incluyendo:
- Tablas para inventario
- Tablas para componentes
- Tablas para proveedores
- Tablas para referencias
- Tablas para tipos
- Tablas para sugerencias
- Tablas para usuarios y autenticación

## 📝 Licencia

Este proyecto fue desarrollado como Trabajo de Fin de Grado Superior.

## ✒️ Autor

**Pablo Martínez Mainer**

