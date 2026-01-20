# Quasar Demo

![Quasar](https://img.shields.io/badge/Quasar-1976D2?style=flat&logo=quasar&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-4FC08D?style=flat&logo=vue.js&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat&logo=vite&logoColor=white)

Quasar framework demo to explore Vue.js and component-based development.

## 🎯 Objective

Learn Quasar Framework and Vue.js 3:
- Vue component system
- Quasar UI components
- Composition API
- Reactive state management
- Single File Components (SFC)

## 🛠️ Tech Stack

- **Quasar Framework v2** - Enterprise-ready Vue.js framework
- **Vue.js 3** - Progressive JavaScript framework
- **Vite** - Fast build tool
- **JavaScript (ES6+)** - Main language

## 💡 What I'm Learning

- Quasar CLI setup and configuration
- Vue 3 Composition API
- Quasar UI component library (buttons, cards, dialogs, etc.)
- Quasar layout system
- Routing with Vue Router
- Build configuration with Vite
- Component styling with Quasar

## 🚀 Setup

### Prerequisites
- Node.js 16+
- npm or yarn

### Global Quasar CLI Installation (optional)

```bash
npm install -g @quasar/cli
```

### Installation and Start

```bash
# Install dependencies
npm install
# or
yarn

# Start development server (hot-reload)
quasar dev
# or
npm run dev
```

Browser will automatically open on the configured port.

### Other Commands

```bash
# Lint code
npm run lint

# Format code
npm run format

# Build for production
quasar build
# or
npm run build

# Build for different platforms
quasar build -m electron    # Desktop app
quasar build -m cordova     # Mobile app
quasar build -m capacitor   # Mobile app (alternative)
```

## 📁 Project Structure

```
src/
├── App.vue              # Root component
├── assets/              # Static assets
├── boot/                # Boot files (plugins)
├── components/          # Reusable components
├── css/                 # Global styles
├── layouts/             # Layout templates
├── pages/               # Pages/views
└── router/              # Routing configuration
public/                  # Public static files
quasar.config.js         # Quasar configuration
```

## 🔧 Configuration

Main configuration is in `quasar.config.js`. Here you can:
- Enable/disable Quasar features
- Configure build modes
- Set environment variables
- Customize Vite/Webpack

See [Quasar config documentation](https://v2.quasar.dev/quasar-cli-vite/quasar-config-js)

## 📝 Notes
Essentially I followed a tutorial to get started with Quasar on YouTube.