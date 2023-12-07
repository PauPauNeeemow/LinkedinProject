import '../App.scss';
import { useState } from 'react';
import { useEffect } from 'react';
import SearchBar from '../SearchBar';
import Button from 'react-bootstrap/Button';
import Card from 'react-bootstrap/Card';
import Header from './header';
import ApplyForm from './applyform';
import ModifAd from './modifad';
import CreateApply from './createad';

export default function BodySearch(){
    // État pour gérer la visibilité du texte
    const [createvi,setvisible] = useState();
    const [modifyvi,setvisiblemodif] = useState(false);
    const [textVisible, setTextVisible] = useState(true);
    const [textVisible2, setText2Visible] = useState(false);
    const [verifadm, setadm] = useState();
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

    const [post, setPost] = useState();
   

    const getAd = async () => {


      const resp = await fetch(`http://localhost/api/advertissements`)
      .then((resp =>resp.json()));
      setPost(resp);
      
    }
   


    // Appel à la fonction SearchBar
    const [searchResults, setSearchResults] = useState([]);

    const handleSearch = async (e) => {
      
      if (e === ''){
        localStorage.setItem("search", "false");

        let response = await fetch(`http://localhost/api/advertissements`);

        response = await response.json();
        setPost(response);
      }else{
        e = e.replace(/\s/g, '');

        let resp = await fetch(`http://localhost/api/advertissements/${e}`)
        resp = await resp.json();
        localStorage.setItem("search", "true");
        setPost(resp)
      }

    };

    const handleSearch2 = async(e) => {
      if (e === ''){
        localStorage.setItem("search", "false");
        let response = await fetch(`http://localhost/api/advertissements`);

        response = await response.json();
        setPost(response);
      }else{
        e = e.replace(/\s/g, '');
        let resp = await fetch(`http://localhost/api/advertissements/comp/${e}`)

        resp = await resp.json();
        localStorage.setItem("search", "true");
        setPost(resp)
      }

    };
    const deleteAd = async (e) => {

      const idAd = e.target.getAttribute('idAd');
      let del = await fetch(`http://localhost/api/advertissements/${idAd}`,{
        method : 'DELETE'
      })
      del = await del.json();
      window.location.reload();
    }

    //afficher un formulaire pour postuler
    const [showForm, setShowForm] = useState(false);

    const handleApplyClick = async (cardId) => {
      setShowForm((prevsearchVisible) => ({
        ...prevsearchVisible,
        [cardId]: !prevsearchVisible[cardId],
      }));
    };

    const createvisible = () =>{
      if (createvi){
        setvisible(false)
      }else{
        setvisible(true)
      }

    }
    const handleModifyAd = async (cardId) => {
      setvisiblemodif((prevmodifyvi) => ({
        ...prevmodifyvi,
        [cardId]: !prevmodifyvi[cardId],
      }))
    }
    useEffect(() => {
      let searchverif = localStorage.getItem('search');
      if (searchverif === "true" ){
        localStorage.setItem('search', "false")
        handleSearch();
        handleSearch2();
      }
      else{
        getAd();
        const admverif = localStorage.getItem('adm')
        
        if (admverif === null || admverif === undefined){
          setadm(false);
        }else{
          setadm(admverif)
        }
      }
    }, []);
    return (
      <div>
        <Header></Header>
        <div className='flexDiv2'>
          <div className='divSearch'>
            <div className='searchTitleDiv'>
              <h2 className='searchtitle'>Rechercher via le titre :</h2>
            </div>
            <div className='searchBar'>
              <SearchBar onSearch={handleSearch} />
            </div>
            <div className='searchTitleDiv'>
              <h2 className='searchtitle'>Rechercher via l'Employeur :</h2>
            </div>
            <div className='searchBar'>
              <SearchBar  onSearch={handleSearch2} />
            </div>
          </div>
          <div className='divCreateButton'>
            <Button className={'ButtonAdmCreate'+(verifadm)} onClick={createvisible} variant='primary'>create</Button>
          </div>
          {createvi ? <CreateApply/>: null }
          {post && post.map((post,index) =>
            <div className='flexAd'>
            <Card border="dark" className='cardPad' key={post.id}>
                <Card.Header as= "h5">{post.title}</Card.Header>
                <Card.Body>
                  <Card.Title>Description</Card.Title>
                  <Card.Text>
                  {textVisible[post.id] ? 
                    null
                     : (<p className='shortDescription'>{post.description}</p>)}
                  {textVisible2[post.id] ? (
                    <ul>
                      {post.description ? (
                        <li className='list'><p>- {post.description}</p></li>
                      ) : null}
                      {post.salaire ? (
                        <li className='list'><p>- {post.salaire}</p></li>
                      ) : null}
                      {post.mission ? (
                        <li className='list'><p>- {post.mission}</p></li>
                      ) : null}
                      {post.localisation ? (
                        <li className='list'><p>- {post.localisation}</p></li>
                      ) : null}
                       {post.emploitype ? (
                        <li className='list'><p>- {post.emploitype}</p></li>
                      ) : null}
                      {post.competences ? (

                        <li className='list'><p>- {post.competences}</p></li>
                      ) : null}
                      {post.namecomp ? (
                        <li className='list'><p>- {post.namecomp}</p></li>
                      ) : null}
                    </ul>
                    ) : null}
                  </Card.Text>
                  {/* <Link to={`/advertissement/${post.idAd}`}> */}
                  <Button
                    onClick={() => {handleToggleText(post.id);handleToggleText2(post.id)}}
                    variant="light"
                  >
                  {textVisible2[post.id] ? 'Hide Text' : 'Read more ...'}
                  </Button>
                  {/* </Link> */}
                  <Button onClick={() => handleApplyClick(post.id)} variant="primary">Apply</Button>
                  {showForm[post.id] && <ApplyForm idAd={post.id} />}
                  <Button className={'ButtonAdmModif'+(verifadm)} onClick={() => handleModifyAd(post.id)} variant='primary'>Modify</Button>
                  {modifyvi[post.id] && <ModifAd idAd={post.id}/>}
                  <Button className={'ButtonAdmDelete'+(verifadm)} onClick={deleteAd} idAd={post.id} variant='primary'>Delete</Button>
                </Card.Body>
            </Card>
          </div>)}
        </div>
      </div>
    );
}