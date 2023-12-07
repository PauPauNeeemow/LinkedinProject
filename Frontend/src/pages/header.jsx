import '../App.scss';
import { useEffect, useState } from 'react';
import Navbar from 'react-bootstrap/Navbar';
import SearchBar from '../SearchBar';
import Logo from '../img/logo.png';
import OGimage from '../img/original.png';
import post from '../pages/bodysearch'
export default function Header(){

    // Appel à la fonction SearchBar
    const [searchResults, setSearchResults] = useState([]);
    const [searchInput, setSearchInput] = useState("");
    const [verifconnect, setverif] = useState("");

    const Verifcompteconnexion = ()=>{
      const verif = localStorage.getItem('verif');
      if (verif === "True"){
        return <Navbar.Brand className='brandText' href="/compte">Mon compte</Navbar.Brand>
      }else{
        return <Navbar.Brand className='brandText' href="/connexion">Connexion</Navbar.Brand>
      }
    }

    

    return (
        <div className='bg-white flexDiv1'>
          <div className='imgBox1'>
            <img className='image1' height="auto" width="100%" src={Logo} alt="Logo" fluid />
          </div>
          <div className='imgBox2'>
            <img className='image2' height="auto" width="100%" src={OGimage} alt="OGimage" fluid />
          </div>
          <Navbar className='navPad'>
              <Navbar.Brand className='brandText' href="/">Accueil</Navbar.Brand>
              <Verifcompteconnexion/>
          </Navbar>
        </div>
    );
}