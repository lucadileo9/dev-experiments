const mongoose = require('mongoose');

const blogPostSchema = new mongoose.Schema({
  title: { type: String, required: true }, // Titolo dell'articolo
  content: { type: String, required: true }, // Contenuto completo
  author: { type: String, required: true }, // Autore dell'articolo
});

const BlogPost = mongoose.models.BlogPost || mongoose.model('BlogPost', blogPostSchema);

module.exports = BlogPost;