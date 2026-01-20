# Next.js Simple Blog

![Next.js](https://img.shields.io/badge/Next.js-000000?style=flat&logo=nextdotjs&logoColor=white)
![React](https://img.shields.io/badge/React-61DAFB?style=flat&logo=react&logoColor=black)
![TypeScript](https://img.shields.io/badge/TypeScript-3178C6?style=flat&logo=typescript&logoColor=white)
![MongoDB](https://img.shields.io/badge/MongoDB-47A248?style=flat&logo=mongodb&logoColor=white)

Minimalist blog to experiment with Next.js, database integration, and authentication.

## 🎯 Objective

Build a functional blog to learn:
- Full-stack development with Next.js
- Database integration (MongoDB/Mongoose)
- Authentication system
- API Routes and Server Components
- CRUD operations

## 🛠️ Tech Stack

- **Next.js** - Full-stack React framework
- **React 18** - UI library
- **TypeScript** - Type safety
- **MongoDB** - NoSQL database
- **Mongoose** - ODM for MongoDB
- **Tailwind CSS** - Styling
- **shadcn/ui** - UI components

## 💡 What I'm Learning

- Advanced routing with Next.js App Router
- Authentication and session management
- API Routes for backend
- Database integration with Mongoose
- Server Components vs Client Components
- Middleware for route protection
- Form handling and validation

## 🚀 Setup

### Prerequisites
- Node.js 18+
- MongoDB installed locally or MongoDB Atlas account

### Environment Variables

Create a `.env.local` file:

```env
MONGODB_URI=your_mongodb_connection_string
NEXTAUTH_SECRET=your_secret_key
NEXTAUTH_URL=http://localhost:3000
```

### Installation and Start

```bash
# Install dependencies
npm install

# Start development server
npm run dev

# Open browser at
# http://localhost:3000
```

### Database Setup

```bash
# Make sure MongoDB is running
# If using local MongoDB:
mongod

# Database will be created automatically on first run
```

## 📁 Project Structure

```
app/
├── (admin)/         # Admin area
├── (user)/          # Public area
├── api/             # API routes
├── components/      # Shared components
├── middleware/      # Custom middleware
├── models/          # Mongoose models
├── utils/           # Utility functions
└── db.js            # Database configuration
```

## 🔧 Features

- ✅ Article creation and management
- ✅ Authentication system
- ✅ Protected admin area
- ✅ Responsive design
- 🚧 Comments (in development)
- 🚧 Categories and tags (planned)

## 📝 Notes

- See `/models` for database schema
- Learning project, not production-ready
