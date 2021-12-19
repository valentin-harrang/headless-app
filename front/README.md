This is a [Next.js](https://nextjs.org/) project bootstrapped with [`create-next-app`](https://github.com/vercel/next.js/tree/canary/packages/create-next-app).
This front-end application communicates with the backend which is an API platform.

## Getting Started

First, run the development server:

```bash
npm run dev
# or
yarn dev
```

Open [http://localhost:3000](http://localhost:3000) with your browser to see the result. To log in, use the login details displayed on the login page.

## Learn More

To learn more about Next.js, take a look at the following resources:

- [Next.js Documentation](https://nextjs.org/docs) - learn about Next.js features and API.
- [Learn Next.js](https://nextjs.org/learn) - an interactive Next.js tutorial.

You can check out [the Next.js GitHub repository](https://github.com/vercel/next.js/) - your feedback and contributions are welcome!

## Deploy on Vercel

The easiest way to deploy your Next.js app is to use the [Vercel Platform](https://vercel.com/new?utm_medium=default-template&filter=next.js&utm_source=create-next-app&utm_campaign=create-next-app-readme) from the creators of Next.js.

Check out our [Next.js deployment documentation](https://nextjs.org/docs/deployment) for more details.

## Possible improvements

- Use server-side rendering (SSR)
- Create user context
- Store JWT in cookie instead of local storage
- Replace Bootstrap by Material UI
- Add pagination
- Filtering articles by categories and by feed
- Add search bar
- Code optimization
- Add register form

## Blocking points

I think it would have been possible to do server side rendering (SSR) to display the news. I chose to store the JWT in local storage which is a good thing for a React application but with Next.js it doesn't seem possible to access local storage via server side rendering functions (getStaticProps and getStaticPaths ), storing in a cookie could make that possible.