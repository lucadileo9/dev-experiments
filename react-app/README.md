# React Experiments

![React](https://img.shields.io/badge/React-61DAFB?style=flat&logo=react&logoColor=black)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black)

Playground to experiment with React's basic features.

## 🎯 Objective

Learn React fundamentals through small components and practical examples:
- State management with hooks
- Props and component composition
- Event handling
- Conditional rendering
- Component lifecycle

## 🛠️ Tech Stack

- **React 18** - UI library
- **Create React App** - Toolchain setup
- **JavaScript (ES6+)** - Main language

## 💡 What I Learned

- **useState Hook** - Local state management in components
- **Component Composition** - Building complex UIs from simple components
- **Props Drilling** - Passing data between components
- **Event Handling** - Managing clicks, inputs, and other events
- **Conditional Rendering** - Showing/hiding elements dynamically
- **Component Organization** - Structuring a React project

## 🧩 Example Components

- **GuessNumber.js** - Number guessing game (state, events, logic)
- **Video.js** - Video player component
- **Contact.js** - Contact form
- **Btn.js** - Reusable button
- **Heading.js** - Heading component
- **Homepage.js** - Main page

## 🚀 Setup

### Prerequisites
- Node.js 14+
- npm

### Installation and Start

```bash
# Install dependencies
npm install

# Start in development mode
npm start
```

Browser will automatically open at [http://localhost:3000](http://localhost:3000)

### Other Commands

```bash
# Run tests
npm test

# Build for production
npm run build

# Analyze bundle
npm run build
npm install -g serve
serve -s build
```

## 📁 Structure

```
src/
├── App.js              # Main component
├── App.css             # App styles
├── index.js            # Entry point
├── GuessNumber.js      # Number guessing game
├── Video.js            # Video player
├── Contact.js          # Contact form
├── Btn.js              # Button component
├── Heading.js          # Heading component
└── Homepage.js         # Homepage
```

## 📝 Notes

I did this project during the two courses I took on React on Coursera.
- Project based on Create React App
- Focus on learning React basics
- Each component explores a specific concept
- Code intentionally simple for didactic clarity

### Code Splitting

This section has moved here: [https://facebook.github.io/create-react-app/docs/code-splitting](https://facebook.github.io/create-react-app/docs/code-splitting)

### Analyzing the Bundle Size

This section has moved here: [https://facebook.github.io/create-react-app/docs/analyzing-the-bundle-size](https://facebook.github.io/create-react-app/docs/analyzing-the-bundle-size)

### Making a Progressive Web App

This section has moved here: [https://facebook.github.io/create-react-app/docs/making-a-progressive-web-app](https://facebook.github.io/create-react-app/docs/making-a-progressive-web-app)

### Advanced Configuration

This section has moved here: [https://facebook.github.io/create-react-app/docs/advanced-configuration](https://facebook.github.io/create-react-app/docs/advanced-configuration)

### Deployment

This section has moved here: [https://facebook.github.io/create-react-app/docs/deployment](https://facebook.github.io/create-react-app/docs/deployment)

### `npm run build` fails to minify

This section has moved here: [https://facebook.github.io/create-react-app/docs/troubleshooting#npm-run-build-fails-to-minify](https://facebook.github.io/create-react-app/docs/troubleshooting#npm-run-build-fails-to-minify)
