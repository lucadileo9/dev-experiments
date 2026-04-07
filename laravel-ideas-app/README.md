<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Ideas Dashboard 🚀

A modern and responsive learning project built with **Laravel 11**, crafted to securely manage, organize, and track your personal and professional ideas. This project focuses on backend architecture, code optimization, robust security, and a modular frontend built with **Atomic Design** principles, **Tailwind CSS v4** and **DaisyUI**.

## ✨ Features

### Backend (Robust & Secure)
- **MVC Architecture**: Clean separation of Models, Views, and Controllers.
- **Advanced Authorization**: Real-world protection against IDOR (Insecure Direct Object Reference). The app implements **Policies**, **Route Middlewares**, and **Gates** guaranteeing that users can only view, edit, or delete their own ideas or update belonging steps.
- **Form Requests**: Centralized, clean validation logic including custom Authorization strategies per request action.
- **Query Optimization**: Efficient database aggregated querying (`selectRaw()`, `groupBy`) reducing the previous N+1 logic structure drastically. Implements PHP 8.1 internal Enums (`IdeaStatus`) bound directly to validation rules.
- **Route Model Binding**: Automatic fetching of DB resources.
- **Database Customization**: Dynamic database structure supported by factories, providing pre-populated users and associated mock ideas for fast experimentation.

### Frontend (Modern & Modular)
- **Vite Integration**: Blazing fast asset bundling for the UI component tracking.
- **Tailwind CSS v4 & DaisyUI**: Full implementation delivering out-of-the-box beautiful semantic elements (Cards, Buttons, Inputs, Modals, Navbars).
- **Extensive Blade Engine**: Built on reusable components (`<x-ideas.form>`, `<x-ui.modal>`, `<x-layouts.app>`). The whole project has been refactored dropping redundant custom pages, using dynamic partials instead.
- **Dynamic Theme Switcher**: 32+ theme palette saved persistently within the local storage, offering custom Dark and Light modes.

---

## 🛠️ Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm

### Installation

1. **Clone the repository**:
   ```bash
   git clone <repository_url>
   cd laravel-ideas-app
   ```
2. **Install PHP dependencies**:
   ```bash
   composer install
   ```
3. **Install Frontend dependencies**:
   ```bash
   npm install
   ```
4. **Environment Setup**:
   Copy the example environment file and generate the application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. **Database Setup & Mock Data**:
   This command will run all migrations and populate the database with a test user and fake ideas. *(Note: you must configure your `.env` connection first)*
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start the Development Servers**:
   You need two terminals running simultaneously.
   
   Terminal 1 (Backend):
   ```bash
   php artisan serve
   ```
   
   Terminal 2 (Frontend Builder):
   ```bash
   npm run dev
   ```

7. **Visit**: `http://localhost:8000`

---

## 📚 Advanced Concepts Implemented
During the development, the following concepts and challenges have been tackled:
- **English Translation**: Complete localization into English of the entire application.
- **Refactoring & Modularity**: Turning redundant, standalone create/edit blades into a master Form component invoked programmatically within Modals and Layouts.
- **IDOR Protection Implementation**: Developing an `IdeaPolicy`, injected as explicit Middleware for Routes and within Controllers to restrict lateral movements.
- **Performance Filtering**: Building singular scalable DB aggregation processes for dashboard statistic loading. 
- **Profile Module**: Providing a dedicated end-user environment to edit critical info securely via `$request->user()->update(...)`.

## Documentation
Check the `docs/` folder in the root path to understand the decision-making and step-by-step logic on:
- [Implementation of system Authorization & Anti-IDOR (Phase 1)](docs/01-implementazione-autorizzazione.md)
- [Query optimization logic & User Profile creation (Phase 2)](docs/02-refactoring-filtro-e-profilo.md)

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
