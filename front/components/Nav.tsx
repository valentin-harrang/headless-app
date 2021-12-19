import { useState, useEffect } from "react";
import { userService } from "../api/queries/users";
import NavLink from "./NavLink";

const Nav = () => {
  const [user, setUser] = useState(null);

  useEffect(() => {
    const subscription = userService.user.subscribe((x) => setUser(x));
    return () => subscription.unsubscribe();
  }, []);

  function logout() {
    userService.logout();
  }

  // only show nav when logged in
  if (!user) return null;

  return (
    <nav className="navbar navbar-expand navbar-dark bg-dark">
      <div className="navbar-nav">
        <NavLink href="/" exact className="nav-item nav-link">
          Accueil
        </NavLink>
        <a onClick={logout} className="nav-item nav-link">
          Déconnexion
        </a>
      </div>
    </nav>
  );
};

export default Nav;
