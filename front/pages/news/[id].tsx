import { useRouter } from "next/router";
import ErrorPage from "next/error";
import { useEffect, useState } from "react";
import { getOneNewsById } from "../../api/queries/news";
import { News } from "../../types/News";

const Post = () => {
  const router = useRouter();
  const id = parseInt(router.query.id as string);
  const [errorStatusCode, setErrorStatusCode] = useState(200);
  const [news, setNews] = useState<News>();

  useEffect(() => {
    (async () => {
      if (id) {
        try {
          setNews(await getOneNewsById(id));
          setErrorStatusCode(200);
        } catch (err) {
          // @ts-ignore
          setErrorStatusCode(err.status);
        }
      }
    })();

    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [id]);

  if (errorStatusCode === 200) {
    if (news) {
      const { title, description, publicationDate } = news;
      return (
        <div>
          <h1>{title}</h1>
          <p>{description}</p>
          <i>
            {" "}
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
          </i>
        </div>
      );
    }

    return (
      <div className="spinner-border spinner-border-sm mx-auto d-block"></div>
    );
  }

  return <ErrorPage statusCode={errorStatusCode} />;
};

export default Post;
