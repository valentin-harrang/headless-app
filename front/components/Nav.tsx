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
      <ul className="navbar-nav ml-auto">
        <li className="nav-item">
          <NavLink href="/" exact className="nav-link">
            Accueil
          </NavLink>
        </li>
        <li className="nav-item">
          <a onClick={logout} className="nav-link">
            Déconnexion
          </a>
        </li>
      </ul>
    </nav>
  );
};

export default Nav;
