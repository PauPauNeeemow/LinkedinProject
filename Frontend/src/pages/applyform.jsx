import '../App.scss';
import React, { useEffect, useState } from 'react';

export default function ApplyForm({idAd}, {idComp}) {
  const [verif, setverif] = useState()
  
  // État local pour les données du formulaire
  const [formData, setFormData] = useState({
    name: '',      // Nom de l'utilisateur
    email: '',     // Email de l'utilisateur
    message: ''   // Message du formulaire
  });

  const getInf = async () =>{
    const id = localStorage.getItem("id");
    if ((localStorage.getItem('id'))) {
      let response = await fetch(`http://localhost/api/user/${id}`)
      response = await response.json()
      if (response.id !== "") {
        setFormData({
          name: response.name,
          surname: response.surname,
          number: response.number,
          email: response.email
        })
      }else{
        setFormData({
          name: "",
          surname: "",
          number: "",
          email: ""
        })
      }
    }
  }


  const postForm = async () => {
    const id = localStorage.getItem("id");

    if ((localStorage.getItem('id'))) {
      const response = await fetch(`http://localhost/api/user/${id}`)
      if (response.ok) {
        const responseData = await response.json();
        let Sendmail = 1;
        // responseData contient potentiellement des données importantes depuis le serveur
        const dataToSend = {
          idUser: responseData.id, 
          idAd: idAd, 
          idComp: idComp,
          name: responseData.name,
          email: responseData.email,
          emailSend: Sendmail,
          message: formData.message,
          surname: responseData.surname,
          number: responseData.number
        };
        const sendEmail = await fetch(`http://localhost/api/mail`,{
          method: 'POST',
          body:JSON.stringify({email: responseData.email, emailcomp: "emaildestinatere", message: dataToSend.message})
        })
      } else {
        let Sendmail = 1;
        let dataUserGet = document.getElementsByClassName('formulaireApply')
        const dataToSend = {
          idUser: "", 
          idAd: idAd, 
          idComp: idComp,
          name: dataUserGet.name,
          email: dataUserGet.email,
          emailSend: Sendmail,
          message: dataUserGet.message,
          surname: dataUserGet.surname,
          number: dataUserGet.number
        };
        let infoResponse = await fetch(`http://localhost/api/information`, {
          method: 'POST',
      });
      infoResponse = await infoResponse.json();
    }
    }
  };
  useEffect(()=>{
    getInf();
    if((localStorage.getItem('verif'))){
      setverif(true)
    }else{
      setverif(false)
    }
  },[])

  return (
    <form className='formulaireApply'>
        <label>Nom : </label>
        <input type="text" name="name" defaultValue={verif ? formData.name : ""}  />
        <label>Prénom : </label>
        <input type="text" name="surname" defaultValue={verif ? formData.surname : ""} />
        <label>Email : </label>
        <input type="email" name="email" defaultValue={verif ? formData.email : ""} />
        <label>Numéro : </label>
        <input type="text" name="number" defaultValue={verif ? formData.number : ""} />
        <label>Message : </label>
        <input type="text" name="message" defaultValue={verif ? formData.message : ""}/>
        <button onClick={postForm} type="button">Soumettre</button>
    </form>
  );
}