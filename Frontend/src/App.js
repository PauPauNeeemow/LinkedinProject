import './App.scss';
import { Route, Routes } from 'react-router-dom';
import React from 'react';
import BodySearch from './pages/bodysearch';
import BodyCompte from './pages/bodycompte';
import BodyMessagerie from './pages/bodymessagerie';
import BodyConnexion from './pages/bodyconnexion';
import BodyRegister from './pages/bodyregister';
import ForgetPWD from './pages/forgetpwd';
import BodyAdvertissement from './pages/bodyadvertissement';
import { AuthUser } from './Hook/Authuser';
import { VerifConnexion } from './Hook/VerifConnexion';
import BodyModifyUser from './pages/bodymodifyuser';


function App() {

  return (
  <Routes>
    <Route path='/' element={<BodySearch/>}/>
    <Route path='/connexion'  element={<AuthUser/>}>
      <Route index element={<BodyConnexion/>}/>
      <Route path='register' element={<BodyRegister/>}/>
      <Route path='forgetpwd' element={<ForgetPWD/>}/>
    </Route>
    <Route path='/compte' element={<VerifConnexion/>}>
      <Route index element={<BodyCompte/>}/>
      <Route path='modify' element={<BodyModifyUser/>}/>
    </Route>
    <Route path='/messagerie' element={<BodyMessagerie/>} />
    <Route path='/advertissement/:postidAd' component={BodyAdvertissement} element={<BodyAdvertissement/>} />

  </Routes>
  );
}

export default App;
