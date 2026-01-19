// utils/db.js
const mongoose = require('mongoose');

const connectDB = async () => {
  try {
    // Connessione al database
    await mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/cms', {
      useNewUrlParser: true,
      useUnifiedTopology: true,
    });
    console.log('Connesso a MongoDB');
  } catch (error) {
    console.error('Errore durante la connessione a MongoDB:', error);
    process.exit(1); // Termina il processo in caso di errore critico
  }
};

module.exports = connectDB; // Usa module.exports per CommonJS