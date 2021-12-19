import { BehaviorSubject } from "rxjs";
import getConfig from "next/config";
import Router from "next/router";
import { fetchWrapper } from "../helpers/fetch-wrapper";

const { publicRuntimeConfig } = getConfig();
const userLocalStorageKey = "user";
const loginRoute = "/login";
const usersApiEndpoint = "/users";

const userSubject = new BehaviorSubject(
  process.browser &&
    JSON.parse(localStorage.getItem(userLocalStorageKey) || "{}")
);

const login = (username: string, password: string) => {
  return fetchWrapper
    .post(publicRuntimeConfig.apiUrl + loginRoute, { username, password })
    .then((user) => {
      // publish user to subscribers and store in local storage to stay logged in between page refreshes
      userSubject.next(user);
      localStorage.setItem(userLocalStorageKey, JSON.stringify(user));

      return user;
    });
};

const logout = () => {
  // remove user from local storage, publish null to user subscribers and redirect to login page
  localStorage.removeItem(userLocalStorageKey);
  userSubject.next(null);
  Router.push(loginRoute);
};

const getAll = () => {
  return fetchWrapper.get(publicRuntimeConfig.apiUrl + usersApiEndpoint);
};

export const userService = {
  user: userSubject.asObservable(),
  get userValue() {
    return userSubject.value;
  },
  login,
  logout,
  getAll,
};
