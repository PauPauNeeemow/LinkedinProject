import '../App.scss';
import Header from './header';
import { Button } from 'react-bootstrap';
import CryptoJS from 'crypto-js';
import React from 'react';
import image from '../img/original.png'
import {MDBContainer, MDBCol, MDBRow, MDBBtn, MDBIcon, MDBInput, MDBCheckbox } from 'mdb-react-ui-kit';

export default function BodyConnexion() {

    const postForm = async () => {
        const buttonForm=document.getElementById("buttonForm");

        let email = document.getElementById('email');
        let password = document.getElementById('pwd');
        email=email.value;
        password=password.value;
        const data={
            'email': email,
            'password': password
        };

        const response = await fetch(`http://localhost/api/login`, {

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

                        <MDBInput wrapperClass='mb-4' label='Email address' id='email' type='email' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Password' id='pwd' type='password' size="lg"/>

                        <div className="d-flex justify-content-between mb-4">
                            <MDBCheckbox name='flexCheck' value='' id='flexCheckDefault' label='Remember me' />
                            <a className='linkPWD' href="./connexion/forgetpwd">Forget your password ?</a>
                        </div>

                        <div className='text-center text-md-start mt-4 pt-2'>
                            <button as="input" id="buttonForm" onClick={postForm} type="submit">Login</button>
                            <p className="small fw-bold mt-2 pt-1 mb-2">Don't have an account? <a href="./connexion/register" className="link-danger">Register</a></p>
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