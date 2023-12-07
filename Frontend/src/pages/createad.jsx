import React, { useState } from 'react';
import { Button, Card } from 'react-bootstrap';

export default function CreateApply() {
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    idAd: '',
    salaire: '',
    mission: '',
    localisation: '',
    emploitype: '',
    competances: '',
    namecomp: '',
  });

  const valueChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  const createButton = async () => {
   setFormData({
    title: formData.title,
    description: formData.description,
    id: localStorage.getItem('id') ,
    salaire: formData.salaire,
    mission: formData.mission,
    localisation: formData.localisation,
    emploitype: formData.emploitype,
    competences: formData.competance,
    namecomp: formData.compagnie,
   })
   const res = await fetch("http://localhost/api/advertissements",{
    method: 'POST',
    body: JSON.stringify(formData)
   })
  };

  return (
    <div className='flexAd'>
      <Card border="dark" className='cardPad'>
        <Card.Header >Title <input type="text" name="title" onChange={valueChange} defaultValue={formData.title} /></Card.Header>
        <Card.Body>
          <Card.Title>Description</Card.Title>
          <Card.Text>
            <ul className='list-create'>
              <li className='list'>
                Description <input type="text" name='description' onChange={valueChange} defaultValue={formData.description} />
              </li>
              <li className='list'>
                Salaire <input type="text" name='salaire' onChange={valueChange} defaultValue={formData.salaire} />
              </li>
              <li className='list'>
                Mission <input type="text" name='mission' onChange={valueChange} defaultValue={formData.mission} />
              </li>
              <li className='list'>
                Localisation <input type="text" name='localisation' onChange={valueChange} defaultValue={formData.localisation} />
              </li>
              <li className='list'>
                Emploitype <input type="text" name='emploitype' onChange={valueChange} defaultValue={formData.emploitype} />
              </li>
              <li className='list'>
                Competance <input type="text" name='competance' onChange={valueChange}defaultValue={formData.competance} />
              </li>
              <li className='list'>
                Campagnie <input type="text" name='compagnie' onChange={valueChange} value={formData.compagnie} />
              </li>
            </ul>
          </Card.Text>
          <Button onClick={createButton}>Créer</Button>
        </Card.Body>
      </Card>
    </div>
  );
};