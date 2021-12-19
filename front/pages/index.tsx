import { AppContext } from "next/app";
import getConfig from "next/config";
import { useEffect, useState } from "react";
import { fetchWrapper } from "../api/helpers/fetch-wrapper";
import { getNews } from "../api/queries/news";
import { userService } from "../api/queries/users";
import { News } from "../types/News";

const Home = () => {
  const [news, setNews] = useState<News[]>([]);

  useEffect(() => {
    (async () => {
      setNews(await getNews());
    })();

    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  return (
    <>
      <h1>{`Dernières news l'Equipe`}</h1>
      {news &&
        news.map((singleNews: News) => (
          <div key={singleNews.id} className="card mt-4">
            <div className="card-header">
              <h2>{singleNews.title}</h2>
            </div>
            <div className="card-body">{singleNews.description}</div>
            <div className="card-footer">
              Publié le
              {` ${new Date(singleNews.publicationDate)
                .toLocaleDateString("fr-FR", {
                  month: "long",
                  day: "numeric",
                  year: "numeric",
                  hour: "2-digit",
                  minute: "2-digit",
                })
                .replace(",", " à")}`}
            </div>
          </div>
        ))}

      {!news && <div className="spinner-border spinner-border-sm"></div>}
    </>
  );
};

export default Home;
