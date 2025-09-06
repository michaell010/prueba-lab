# 🥖 Sistema de Inventario - Panadería
*Gestión integral de productos terminados*

## 📋 Descripción
Sistema web para gestión de inventario de panadería con funcionalidades CRUD completas.

## ✨ Características
- ✅ Gestión de productos terminados
- ✅ Control de stock y fechas de vencimiento  
- ✅ Cálculo automático de valor total
- ✅ Interfaz responsive
- ✅ API REST

## 🌐 Uso
- **Interfaz web:** `http://127.0.0.1:8000/public/inventario.html`
- **API REST:** `http://127.0.0.1:8000/api/v1/productos`

## 🚀 Instalación
```bash
git clone https://github.com/michaell010/prueba-lab.git
cd prueba-lab
composer install
cp .env.example .env
php artisan migrate
php artisan serve
