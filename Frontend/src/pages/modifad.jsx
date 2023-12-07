import '../App.scss';
import Button from 'react-bootstrap/Button';
import {MDBContainer, MDBCol, MDBInput } from 'mdb-react-ui-kit';

export default function ModifAd({idAd}) {
  
  const postAd = async () => {
    let title = document.getElementById('title');
    let description = document.getElementById('description');
    let salaire = document.getElementById('salaire');
    let mission = document.getElementById('mission');
    let localisation = document.getElementById('localisation');
    let emploitype = document.getElementById('emploitype');
    let competences = document.getElementById('competences');
    let namecomp = document.getElementById('namecomp');
    const dataToSend = {
      'title': title.value,      
      'description': description.value,     
      'id': idAd,
      'salaire': salaire.value,
      'mission': mission.value,
      'localisation': localisation.value,
      'emploitype': emploitype.value,
      'competences': competences.value,
      'namecomp': namecomp.value
    };
    const infoResponse = await fetch(`http://localhost/api/advertissements`, {

      method: 'PUT',
      body: JSON.stringify(dataToSend),
    });
    if (infoResponse.ok) {
      window.location.reload();
    }
  }

  return (
    <div className='flexAdModif'>
      <MDBContainer className="p-3 my-5 h-custom">
          <MDBCol wrapperClass='xs-12 mb-8' className='modifPad'>
              <MDBInput className='inputModif'  label='Title : ' id='title' type='title' size="xs"/>
              <MDBInput className='inputModif'  label='Description : ' id='description' type='description' size="xs"/>
              <MDBInput className='inputModif'  label='Salaire : ' id='salaire' type='salaire' size="xs"/>
              <MDBInput className='inputModif'  label='Mission : ' id='mission' type='mission' size="xs"/>
              <MDBInput className='inputModif'  label='Localisation : ' id='localisation' type='localisation' size="xs"/>
              <MDBInput className='inputModif'  label='Contrat : ' id='emploitype' type='emploitype' size="xs"/>
              <MDBInput className='inputModif'  label='Competences : ' id='competences' type='competences' size="xs"/>
              <MDBInput className='inputModif'  label='Compagnie : ' id='namecomp' type='namecomp' size="xs"/>
              <div className='text-center'>
                <Button onClick={postAd} variant='primary'>Modifier</Button>
              </div>
          </MDBCol>
      </MDBContainer>
    </div>
  );
}