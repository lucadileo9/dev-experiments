import './App.css';
import Heading from './Heading';
import Btn from './Btn';
import GuessNumber from './GuessNumber';
import Contact from './Contact';
import Homepage from './Homepage';
import Video from './Video';
import { BrowserRouter, Link, Route, Routes } from 'react-router-dom';

function App() { 
  return ( 
    <BrowserRouter> {/* Avvolgi l'applicazione con BrowserRouter */}
    <div className="App"> 
    <nav>
      <Link to="/">Home</Link>
      <Link to="/contact">Contact</Link>
      <Link to="/video">Video</Link>
    </nav>

      <Routes>
        <Route path="/" element={<Homepage />}></Route>
        <Route path="/contact" element={<Contact />} />
        <Route path="/video" element={<Video />} />
      </Routes>
      {/* <Btn /> */}
    </div> 
    </BrowserRouter> // Chiudi il tag BrowserRouter
  ); 
} 
 
export default App;