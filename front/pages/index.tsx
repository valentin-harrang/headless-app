import Link from "next/link";
import { useEffect, useState } from "react";
import { getNews } from "../api/queries/news";
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
        news.map(({ title, description, publicationDate, id }: News) => (
          <div key={id} className="card mt-4">
            <div className="card-header">
              <h2>
                <Link href="/news/[id]" as={`/news/${id}`}>
                  <a>{title}</a>
                </Link>
              </h2>
            </div>
            <div className="card-body">{description}</div>
            <div className="card-footer">
              Publié le
              {` ${new Date(publicationDate)
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
