// db.js
export const pages = {
    home: {
      id: 'home',
      title: 'Home',
      modules: {
        hero: {
          title: 'Benvenuti nel nostro sito!',
          subtitle: 'Scopri i nostri servizi',
          image: '/images/hero.jpg',
        },
        'sub-hero': {
          title: 'Chi siamo',
          content: 'Siamo un\'azienda dedicata alla qualità.',
        },
        location: {
          address: 'Via Roma 123',
          mapUrl: 'https://maps.google.com/example',
        },
      },
    },
    'about-us': {
      id: 'about-us',
      title: 'Chi Siamo',
      modules: {
        text: {
          content:
            'Siamo un team di professionisti dedicati a fornire servizi di alta qualità.',
        },
      },
    },
    contact: {
      id: 'contact',
      title: 'Contatti',
      modules: {
        contactForm: {
          email: 'info@example.com',
          phone: '123-456-7890',
        },
      },
    },
  };