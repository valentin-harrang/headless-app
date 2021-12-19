import getConfig from "next/config";
import { userService } from "../queries/users";
const { publicRuntimeConfig } = getConfig();

const get = (url: string) => {
  const requestOptions: RequestInit = {
    method: "GET",
    headers: authHeader(url),
    redirect: "follow",
  };
  return fetch(url, requestOptions).then(handleResponse);
};

const post = (url: string, body: any) => {
  const requestOptions: RequestInit = {
    method: "POST",
    headers: { "Content-Type": "application/json", ...authHeader(url) },
    body: JSON.stringify(body),
    redirect: "follow",
  };
  return fetch(url, requestOptions).then(handleResponse);
};

const put = (url: string, body: any) => {
  const requestOptions: RequestInit = {
    method: "PUT",
    headers: { "Content-Type": "application/json", ...authHeader(url) },
    body: JSON.stringify(body),
    redirect: "follow",
  };
  return fetch(url, requestOptions).then(handleResponse);
};

// prefixed with underscored because delete is a reserved word in javascript
const _delete = (url: string) => {
  const requestOptions: RequestInit = {
    method: "DELETE",
    headers: authHeader(url),
    redirect: "follow",
  };
  return fetch(url, requestOptions).then(handleResponse);
};

// helper functions

const authHeader = (url: string): HeadersInit => {
  // return auth header with jwt if user is logged in and request is to the api url
  const user = userService.userValue;
  const isLoggedIn = user && user.token;
  const isApiUrl = url.startsWith(publicRuntimeConfig.apiUrl);
  const requestHeaders: HeadersInit = new Headers();

  if (isLoggedIn && isApiUrl) {
    requestHeaders.set("Authorization", `Bearer ${user.token}`);
  }

  return requestHeaders;
};

const handleResponse = (response: any) => {
  return response.text().then((text: string) => {
    const data = text && JSON.parse(text);

    if (!response.ok) {
      if ([401, 403].includes(response.status) && userService.userValue) {
        // auto logout if 401 Unauthorized or 403 Forbidden response returned from api
        userService.logout();
      }

      const error = (data && data.message) || response.statusText;
      return Promise.reject(error);
    }

    return data;
  });
};

export const fetchWrapper = {
  get,
  post,
  put,
  delete: _delete,
};
