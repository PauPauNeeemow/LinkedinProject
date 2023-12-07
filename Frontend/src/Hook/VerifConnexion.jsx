
import { Navigate, Outlet } from "react-router-dom";

export const VerifConnexion = () => {
  const verif = localStorage.getItem("verif")
  if (verif !== "True"|| verif === "") {
    return <Navigate to="/connexion" replace />;
   
  } else {
    return <Outlet />;
  }
};