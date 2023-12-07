import { useEffect, useState } from "react";
import { Navigate, Outlet } from "react-router-dom";


export const AuthUser = () => {
    const [verif, setverif] = useState();
    let token = localStorage.getItem("token");
    let id = localStorage.getItem('id')
    let adm = localStorage.getItem('adm')
    if (token === null || id === null){
        token = "";
        id = "";
        adm = "";
    }

    
    let data ={'token': token,'id': id, "adm": adm}

    const tokenVerif = async () => {
        const resp = await fetch(`http://backend.local/api/login/verif`, {
          method: 'POST',
          body: JSON.stringify(data)
        });
        const res = await resp.json();

        setverif(res["verif"]);
      };

    useEffect(() => {
        tokenVerif();
    }, []);
   if (verif !== 'True' || data["id"] === "" || data["token"] === ""){
    localStorage.setItem("id", "");
    localStorage.setItem("token", "")
    localStorage.setItem("verif",false)
    return <Outlet />;
       
   }else{
    return <Navigate to="/compte" replace />;
   }
};