// initializeDB.js
const Page = require('../models/Page'); // Assicurati che Page usi `module.exports`
const connectDB = require('./db'); // Assicurati che connectDB usi `module.exports`

const initializeDB = async () => {
    // Connessione al database
    connectDB();
  // Verifica se la pagina "home" esiste
  const homePage = await Page.findOne({ id: 'home' });
  if (!homePage) {
    await Page.create({
      id: 'home',
      title: 'Home',
      modules: [
        {
          type: 'hero',
          data: {
            title: 'Benvenuti nel nostro sito!',
            subtitle: 'Scopri i nostri servizi',
            image: '/images/hero.jpg',
          },
        },
        {
          type: 'sub-hero',
          data: {
            title: 'Chi siamo',
            content: 'Siamo un\'azienda dedicata alla qualità.',
          },
        },
        {
          type: 'location',
          data: {
            address: 'Via Roma 123',
            mapUrl: 'https://maps.google.com/example',
          },
        },
      ],
    });
  }
  console.log('Home inizializzata');

   // Aggiungi altre pagine fisse (es. 'about-us', 'contact')...
  const aboutUsPage = await Page.findOne({ id: 'about-us' });
    if (!aboutUsPage) {
      await Page.create({
        id: 'about-us',
        title: 'About Us',
        modules: [
          {
            type: 'text',   
            data: {
              content: 'We are a team of professionals dedicated to providing high-quality services.',
            },
            },
        ],
        });   
    }
    
    console.log('About Us inizializzata');

    const contactPage
    = await Page.findOne({ id: 'contact' });
    if (!contactPage) {
      await Page.create({
        id: 'contact',
        title: 'Contact',
        modules: [
          {
            type: 'contactForm',
            data: {
                email: 'info@example.com',
                phone: '123-456-7890',
            },
            },
        ],
        });
    }
    console.log('Contact inizializzata');
                
 }

initializeDB();