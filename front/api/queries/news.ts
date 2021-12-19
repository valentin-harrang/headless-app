import getConfig from "next/config";
import { fetchWrapper } from "../helpers/fetch-wrapper";

const NEWS_ENDPOINT = "/news";
const { publicRuntimeConfig } = getConfig();

export const getNews = async () => {
  const response = await fetchWrapper.get(publicRuntimeConfig.apiUrl + NEWS_ENDPOINT);

  return response["hydra:member"];
};
