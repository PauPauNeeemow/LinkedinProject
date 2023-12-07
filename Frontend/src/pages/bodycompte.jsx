import '../App.scss';
import { useState } from 'react';
import { useEffect } from 'react';
import Header from './header';
import { Link } from 'react-router-dom';
import { Button, Card } from 'react-bootstrap';

export default function BodyCompte() {

    const [post, setPost] = useState();
    const [advert, setadvert] = useState();
    const [textVisible, setTextVisible] = useState(true);
    const [textVisible2, setText2Visible] = useState(false);

    const handleToggleText = (cardId) => {
        // Inversez l'état de la carte spécifique
        setTextVisible((prevtextVisible) => ({
          ...prevtextVisible,
          [cardId]: !prevtextVisible[cardId],
        }));
      };
  
      const handleToggleText2 = (cardId) => {
        // Inversez l'état de la carte spécifique
        setText2Visible((prevtextVisible2) => ({
          ...prevtextVisible2,
          [cardId]: !prevtextVisible2[cardId],
        }));
      };

    const getuser = async () => {

        const id = localStorage.getItem('id')
        const resp = await fetch(`http://localhost/api/user/${id}`)


        const data = await resp.json();
        setPost(data);

      
    }
    const getAd = async () =>{
        let result = []
        let resultpost = []
        const id = localStorage.getItem('id')


        let respad = await fetch(`http://localhost/api/information/${id}`)


        respad = await respad.json();
        respad.forEach((element) => {
            const idAd = element["idAd"];
            result.push(idAd)
        });
        for (let i = 0; i < result.length; i++) {

            let res = await fetch(`http://localhost/api/advertissements/${result[i]}`)

            res = await res.json();
            console.log()
            if (res.length !== 1){
                resultpost.push(res);
            }
            
        }
        console.log(result)
        setadvert(resultpost)        
    }
    const deletebutton = () =>{
        localStorage.clear()
        window.location.href = "/connexion"
    }
    useEffect(() => {
      getuser();
      getAd();
      
    }, []);

    return (
        <div>
            <Header></Header> 
            <div className="container divAccount">
                <div className="my-account mt-5">
                    <h2>Mon Compte</h2>
                    {post ? (
                        <div className="user-info">
                        <p><strong>Nom : </strong> {post.name}</p>
                        <p><strong>Surname : </strong> {post.surname}</p>
                        <p><strong>Email : </strong> {post.email}</p>
                        <p><strong>Number : </strong> {post.number}</p>
                        </div>
                    ) : (
                        <p>Chargement des données...</p>
                    )}
                    <Link to="modify" className="btn btn-primary logout-button">Modifier</Link>
                    <button onClick={deletebutton} className="btn btn-primary logout-button">Se Déconnecter</button>
                </div>
                <div className='flexAd'>
                        {advert && advert.map((advert) =>
                            <Card border="dark" className='cardPad' key={advert.idAd}>
                                <Card.Header as= "h5">{advert.title}</Card.Header>
                                <Card.Body>
                                    <Card.Title>Description</Card.Title>
                                    <Card.Text>
                                    {textVisible[advert.idAd] ? 
                                    null
                                        : (<p className='shortDescription'>{advert.description}</p>)}
                                    {textVisible2[advert.idAd] ? (
                                    <p>{advert.description}</p>
                                    ) : null}
                                    </Card.Text>
                                    {/* <Link to={`/advertissement/${post.idAd}`}> */}
                                    <Button
                                    onClick={() => {handleToggleText(advert.idAd);handleToggleText2(advert.idAd)}}
                                    variant="light"
                                    >
                                    {textVisible2[advert.idAd] ? 'Hide Text' : 'Read more ...'}
                                    </Button>
                                </Card.Body>
                            </Card>)
                        }
                    </div>
            </div>
      </div>
    );
}