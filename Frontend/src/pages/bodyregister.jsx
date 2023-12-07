import '../App.scss';
import Header from './header';
import React from 'react';
import image from '../img/original.png'
import {MDBContainer, MDBCol, MDBRow, MDBBtn, MDBIcon, MDBInput, MDBCheckbox } from 'mdb-react-ui-kit';

export default function BodyRegister() {

   

    const postForm = async () => {
        const buttonForm=document.getElementById("buttonForm");
        buttonForm.addEventListener('click',async (event)=> {
            let email = document.getElementById('email');
            let password = document.getElementById('pwd');
            let name = document.getElementById('name');
            let surname = document.getElementById('surname');
            let number = document.getElementById('number');
            const data={
                'email': email.value,
                'password': password.value,
                'name': name.value,
                'surname': surname.value,
                'number': number.value
            };          
            const response = await fetch(`http://localhost/api/user`, {
                method: "POST",
                body: JSON.stringify(data)
            })
            const res = await response.json()
            if (!res["token"]){
                alert('connexion échouer!')
            }
            else{
                localStorage.setItem("token", res["token"]);
                localStorage.setItem("verif", res["verif"]);
                localStorage.setItem('id', res["id"] )
                localStorage.setItem("adm", res["adm"])
                window.location.href ="/compte";
                
            }
        })
        
    }

    return (
        <div>
            <Header></Header>
            <MDBContainer fluid className="p-3 my-5 h-custom">

                <MDBRow>

                    <MDBCol col='10' md='6'>
                        <img src={image} class="img-fluid imgConnexion" alt="Sample image" />
                    </MDBCol>

                    <MDBCol col='4' md='6' className='connexionPad'>

                        <MDBInput wrapperClass='mb-4' label='Name' id='name' type='name' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Surname' id='surname' type='surname' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Number' id='number' type='number' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Email address' id='email' type='email' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Password' id='pwd' type='password' size="lg"/>

                        <div className='text-center text-md-start mt-4 pt-2'>
                            <button as="input" id="buttonForm" onClick={postForm} type="submit">Register</button>
                            <p className="small fw-bold mt-2 pt-1 mb-2">Already have a acount ? <a href="/connexion" className="link-danger">Login</a></p>
                        </div>

                    </MDBCol>

                </MDBRow>
            </MDBContainer>
            <div className="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">

                <div className="text-white mb-3 mb-md-0">
                    Copyright © 2020. All rights reserved.
                </div>

            </div>
        </div>
    );
    
}