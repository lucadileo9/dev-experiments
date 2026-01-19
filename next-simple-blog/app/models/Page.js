// models/Page.js
const mongoose = require('mongoose');

const moduleSchema = new mongoose.Schema({
  type: { type: String, required: true }, // Tipo del modulo (es. 'hero', 'sub-hero', 'location')
  data: { type: Object, required: true }, // Contenuti del modulo (oggetto JSON)
});

const pageSchema = new mongoose.Schema({
  id: { type: String, required: true, unique: true }, // ID della pagina (es. 'home', 'about-us')
  title: { type: String, required: true },            // Titolo della pagina
  modules: [moduleSchema],                            // Array di moduli
});

const Page = mongoose.models.Page || mongoose.model('Page', pageSchema);

module.exports = Page;