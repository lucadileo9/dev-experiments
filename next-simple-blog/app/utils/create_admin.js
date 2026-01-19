const mongoose = require('mongoose');
const bcrypt = require('bcryptjs');
const Admin = require('../models/Admin'); // Importa il modello Admin

(async () => {
  try {
    // Connetti al database
    await mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/cms', {
        useNewUrlParser: true,
        useUnifiedTopology: true,
        });

    // Verifica se esiste già un admin
    const existingAdmin = await Admin.findOne();
    if (existingAdmin) {
      console.log('Un admin esiste già nel database.');
      process.exit(0);
    }

    // Crea il primo admin
    const email = 'pollo@123'; // Email predefinita
    const password = '1111'; // Password predefinita
    const hashedPassword = await bcrypt.hash(password, 10);

    const newAdmin = new Admin({ email, password: hashedPassword });
    await newAdmin.save();

    console.log('Primo admin creato con successo!');
  } catch (error) {
    console.error('Errore durante la creazione dell\'admin:', error);
  } finally {
    mongoose.disconnect(); // Chiudi la connessione al database
  }
})();