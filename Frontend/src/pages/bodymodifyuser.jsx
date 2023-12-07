import '../App.scss';
import Header from './header';
import React from 'react';
import image from '../img/original.png'
import {MDBContainer, MDBCol, MDBRow, MDBBtn, MDBIcon, MDBInput, MDBCheckbox } from 'mdb-react-ui-kit';

export default function BodyModifyUser() {

   

    const postForm = async () => {
        const id = localStorage.getItem('id')
        let email = document.getElementById('email');
        let password = document.getElementById('pwd');
        let name = document.getElementById('name');
        let surname = document.getElementById('surname');
        let number = document.getElementById('number');
        const data={
            'name': name.value,
            'email': email.value,
            'password': password.value,
            'number': number.value,
            'surname': surname.value,
            'id': id
        };

        let resp = await fetch(`http://localhost/api/user`, {

            method: 'PUT',
            body: JSON.stringify(data),
            
        })
        resp = await resp.json();
        console.log(resp);  
    }

    return (
        <div>
            <Header></Header>
            <MDBContainer fluid className="p-3 my-5 h-custom">

                <MDBRow>

                    <MDBCol col='4' md='6' className='connexionPad'>

                        <MDBInput wrapperClass='mb-4' label='Name' id='name' type='name' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Lastname' id='surname' type='surname' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Number' id='number' type='number' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Email address' id='email' type='email' size="lg"/>
                        <MDBInput wrapperClass='mb-4' label='Password' id='pwd' type='password' size="lg"/>

                        <div className='text-center text-md-start mt-4 pt-2'>
                            <button as="input" id="buttonForm" onClick={postForm} type="submit">Modify</button>
                        </div>

                    </MDBCol>

                </MDBRow>
            </MDBContainer>
        </div>
    );
    
}