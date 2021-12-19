import { useEffect } from "react";
import { useRouter } from "next/router";
import { useForm } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import * as Yup from "yup";
import { userService } from "../api/queries/users";
import { UrlObject } from "url";

interface OnSubmitProps {
  username: string;
  password: string;
}

const Login = () => {
  const router = useRouter();

  useEffect(() => {
    // redirect to home if already logged in
    if (userService.userValue) {
      router.push("/");
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  // form validation rules
  const validationSchema = Yup.object().shape({
    username: Yup.string().required(
      "Veuillez renseigner votre nom d'utilisateur"
    ),
    password: Yup.string().required("Veuillez renseigner votre mot de passe"),
  });
  const formOptions = { resolver: yupResolver(validationSchema) };

  // get functions to build form with useForm() hook
  const { register, handleSubmit, setError, formState } = useForm(formOptions);
  const { errors } = formState;

  function onSubmit({ username, password }: OnSubmitProps) {
    return userService
      .login(username, password)
      .then(() => {
        // get return url from query parameters or default to '/'
        const returnUrl: string | string[] = router.query.returnUrl || "/";
        router.push(returnUrl as UrlObject);
      })
      .catch((error) => {
        setError("apiError", { message: error });
      });
  }

  return (
    <div className="col-md-6 offset-md-3 mt-5">
      <div className="alert alert-info">
        <ul>
          <li>{`Nom d'utilisateur : contact@valentin-harrang.fr`}</li>
          <li>{`Mot de passe : 123456!`}</li>
        </ul>
      </div>
      <div className="card">
        <div className="card-body">
          <form onSubmit={handleSubmit(onSubmit)}>
            <div className="form-group">
              <label>{`Nom d'utilisateur`}</label>
              <input
                type="text"
                {...register("username")}
                className={`form-control ${
                  errors.username ? "is-invalid" : ""
                }`}
              />
              <div className="invalid-feedback">{errors.username?.message}</div>
            </div>
            <div className="form-group">
              <label>Mot de passe</label>
              <input
                type="password"
                {...register("password")}
                className={`form-control ${
                  errors.password ? "is-invalid" : ""
                }`}
              />
              <div className="invalid-feedback">{errors.password?.message}</div>
            </div>
            <button
              disabled={formState.isSubmitting}
              className="btn btn-primary"
            >
              {formState.isSubmitting && (
                <span className="spinner-border spinner-border-sm mr-1"></span>
              )}
              Connexion
            </button>
            {errors.apiError && (
              <div className="alert alert-danger mt-3 mb-0">
                {errors.apiError?.message}
              </div>
            )}
          </form>
        </div>
      </div>
    </div>
  );
};

export default Login;
