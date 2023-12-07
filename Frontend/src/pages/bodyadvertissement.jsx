import '../App.scss';
import { useState } from 'react';
import { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import Button from 'react-bootstrap/Button';
import Card from 'react-bootstrap/Card';
import Header from './header';

export default function BodyAdvertissement() {

    const [post, setPost] = useState();
    const { postidAd } = useParams();

    const getAd = async () => {

        const resp = await fetch(`http://backend.local/api/advertissements/${postidAd}`)
        const data = await resp.json();
        setPost(data);
      
    }

    useEffect(() => {
      getAd();
    }, []);
    console.log(post)

    return (
        <div>
            <Header></Header>
            {post ? (
                <div className='flexAd' name={post.id}>
                <Card border="dark" className='cardPad'>
                    <Card.Header as= "h5">{post.title}</Card.Header>
                    <Card.Body>
                    <Card.Title>Description</Card.Title>
                    <Card.Text >
                        {post.description}
                    </Card.Text>
                    <Button variant="primary">Apply</Button>
                    </Card.Body>
                </Card>
                </div>
            ) : (
                <p>Annonce non trouvée.</p>
            )}
        </div>
    );
}